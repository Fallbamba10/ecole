<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Notifications\NewGradeNotification;
use App\Services\ParentNotifier;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $classrooms = Classroom::all();
        $selectedClassroom = null;
        $subjects = collect();
        $students = collect();
        $grades = collect();
        $period = $request->get('period', 'Trimestre 1');

        if ($request->filled('classroom_id')) {
            $selectedClassroom = Classroom::find($request->classroom_id);
            $subjects = Subject::where('classroom_id', $request->classroom_id)->get();
            $students = Student::where('classroom_id', $request->classroom_id)->get();
            $grades = Grade::where('period', $period)
                ->whereIn('student_id', $students->pluck('id'))
                ->get()
                ->groupBy(['student_id', 'subject_id']);
        }

        return view('grades.index', compact('classrooms', 'selectedClassroom', 'subjects', 'students', 'grades', 'period'));
    }

    public function create(Request $request)
    {
        $classrooms = Classroom::all();
        $students = collect();
        $subjects = collect();

        if ($request->filled('classroom_id')) {
            $students = Student::where('classroom_id', $request->classroom_id)->get();
            $subjects = Subject::where('classroom_id', $request->classroom_id)->get();
        }

        return view('grades.create', compact('classrooms', 'students', 'subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'period' => 'required|string',
            'type' => 'required|in:devoir,composition,examen',
            'value' => 'required|numeric|min:0|max:20',
            'max_value' => 'required|numeric|min:1|max:20',
            'comment' => 'nullable|string|max:255',
        ]);

        $grade = Grade::create($validated);
        $grade->load(['student', 'subject']);

        ParentNotifier::notify($grade->student, new NewGradeNotification($grade));

        return redirect()->route('grades.index', ['classroom_id' => $request->classroom_id, 'period' => $validated['period']])
            ->with('success', 'Note enregistrée.');
    }

    public function batch(Request $request)
    {
        $classrooms = Classroom::all();
        $subjects = collect();
        $students = collect();
        $existingGrades = collect();
        $period = $request->get('period', 'Trimestre 1');

        if ($request->filled('classroom_id')) {
            $subjects = Subject::where('classroom_id', $request->classroom_id)->get();
            $students = Student::where('classroom_id', $request->classroom_id)->orderBy('last_name')->get();

            if ($request->filled('subject_id')) {
                $existingGrades = Grade::where('subject_id', $request->subject_id)
                    ->where('period', $period)
                    ->where('type', $request->get('type', 'devoir'))
                    ->whereIn('student_id', $students->pluck('id'))
                    ->get()
                    ->keyBy('student_id');
            }
        }

        return view('grades.batch', compact('classrooms', 'subjects', 'students', 'existingGrades', 'period'));
    }

    public function batchStore(Request $request)
    {
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'period' => 'required|string',
            'type' => 'required|in:devoir,composition,examen',
            'grades' => 'required|array',
            'grades.*.student_id' => 'required|exists:students,id',
            'grades.*.value' => 'nullable|numeric|min:0|max:20',
            'grades.*.comment' => 'nullable|string|max:255',
        ]);

        $count = 0;
        foreach ($request->grades as $gradeData) {
            if ($gradeData['value'] === null || $gradeData['value'] === '') {
                continue;
            }

            $grade = Grade::updateOrCreate(
                [
                    'student_id' => $gradeData['student_id'],
                    'subject_id' => $request->subject_id,
                    'period' => $request->period,
                    'type' => $request->type,
                ],
                [
                    'value' => $gradeData['value'],
                    'max_value' => 20,
                    'comment' => $gradeData['comment'] ?? null,
                ]
            );

            if ($grade->wasRecentlyCreated) {
                $grade->load(['student', 'subject']);
                ParentNotifier::notify($grade->student, new NewGradeNotification($grade));
            }

            $count++;
        }

        return redirect()->route('grades.batch', [
            'classroom_id' => $request->classroom_id,
            'subject_id' => $request->subject_id,
            'period' => $request->period,
            'type' => $request->type,
        ])->with('success', "$count note(s) enregistrée(s) avec succès.");
    }

    public function edit(Grade $grade)
    {
        return view('grades.edit', compact('grade'));
    }

    public function update(Request $request, Grade $grade)
    {
        $validated = $request->validate([
            'value' => 'required|numeric|min:0|max:20',
            'max_value' => 'required|numeric|min:1|max:20',
            'comment' => 'nullable|string|max:255',
        ]);

        $grade->update($validated);

        return redirect()->route('grades.index', ['classroom_id' => $grade->student->classroom_id, 'period' => $grade->period])
            ->with('success', 'Note modifiée.');
    }

    public function destroy(Grade $grade)
    {
        $classroomId = $grade->student->classroom_id;
        $period = $grade->period;
        $grade->delete();

        return redirect()->route('grades.index', ['classroom_id' => $classroomId, 'period' => $period])
            ->with('success', 'Note supprimée.');
    }
}

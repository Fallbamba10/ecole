<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\User;
use App\Notifications\StudentAbsentNotification;
use App\Services\ParentNotifier;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $classrooms = Classroom::withCount('students')->get();
        $selectedClassroom = null;
        $attendances = collect();
        $date = $request->get('date', now()->format('Y-m-d'));
        $stats = null;

        if ($request->filled('classroom_id')) {
            $selectedClassroom = Classroom::find($request->classroom_id);
            $students = Student::where('classroom_id', $request->classroom_id)->get();

            $attendances = Attendance::where('classroom_id', $request->classroom_id)
                ->where('date', $date)
                ->get()
                ->keyBy('student_id');

            $totalRecords = Attendance::where('classroom_id', $request->classroom_id)->count();
            if ($totalRecords > 0) {
                $presents = Attendance::where('classroom_id', $request->classroom_id)->where('status', 'present')->count();
                $stats = [
                    'total' => $totalRecords,
                    'presents' => $presents,
                    'taux' => round(($presents / $totalRecords) * 100, 1),
                ];
            }
        } else {
            $students = collect();
        }

        return view('attendances.index', compact('classrooms', 'selectedClassroom', 'students', 'attendances', 'date', 'stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'date' => 'required|date',
            'statuses' => 'required|array',
            'statuses.*' => 'in:present,absent,retard,justifie',
        ]);

        $classroom = Classroom::findOrFail($request->classroom_id);

        foreach ($request->statuses as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'date' => $request->date,
                ],
                [
                    'school_id' => $classroom->school_id,
                    'classroom_id' => $classroom->id,
                    'status' => $status,
                    'comment' => $request->comments[$studentId] ?? null,
                ]
            );

            if ($status === 'absent') {
                $student = Student::find($studentId);
                $notification = new StudentAbsentNotification($student, $request->date);

                $admin = User::where('school_id', $classroom->school_id)
                    ->role('admin_ecole')
                    ->first();

                if ($admin) {
                    $admin->notify($notification);
                }

                ParentNotifier::notify($student, $notification);
            }
        }

        return redirect()->route('attendances.index', [
            'classroom_id' => $request->classroom_id,
            'date' => $request->date,
        ])->with('success', 'Appel enregistré avec succès.');
    }

    public function history(Request $request, Student $student)
    {
        $attendances = Attendance::where('student_id', $student->id)
            ->orderBy('date', 'desc')
            ->get();

        $total = $attendances->count();
        $presents = $attendances->where('status', 'present')->count();
        $absents = $attendances->where('status', 'absent')->count();
        $retards = $attendances->where('status', 'retard')->count();
        $taux = $total > 0 ? round(($presents / $total) * 100, 1) : 0;

        return view('attendances.history', compact('student', 'attendances', 'total', 'presents', 'absents', 'retards', 'taux'));
    }
}

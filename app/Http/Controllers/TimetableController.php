<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Subject;
use App\Models\TimetableSlot;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index(Request $request)
    {
        $classrooms = Classroom::all();
        $selectedClassroom = $request->classroom_id ? Classroom::find($request->classroom_id) : $classrooms->first();

        $slots = [];
        if ($selectedClassroom) {
            $slots = TimetableSlot::where('classroom_id', $selectedClassroom->id)
                ->with('subject')
                ->orderBy('start_time')
                ->get()
                ->groupBy('day_of_week');
        }

        $days = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];

        return view('timetable.index', compact('classrooms', 'selectedClassroom', 'slots', 'days'));
    }

    public function create(Request $request)
    {
        $classrooms = Classroom::all();
        $subjects = Subject::all();
        $selectedClassroom = $request->classroom_id;

        return view('timetable.create', compact('classrooms', 'subjects', 'selectedClassroom'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'day_of_week' => 'required|in:lundi,mardi,mercredi,jeudi,vendredi,samedi',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'teacher_name' => 'nullable|string|max:255',
            'room' => 'nullable|string|max:100',
        ]);

        $conflicts = $this->detectConflicts($request);

        if ($conflicts->isNotEmpty()) {
            return back()->withInput()->withErrors([
                'conflict' => 'Conflit détecté : ' . $conflicts->first(),
            ]);
        }

        TimetableSlot::create($request->only([
            'classroom_id', 'subject_id', 'day_of_week', 'start_time', 'end_time', 'teacher_name', 'room',
        ]));

        return redirect()->route('timetable.index', ['classroom_id' => $request->classroom_id])
            ->with('success', 'Créneau ajouté avec succès.');
    }

    public function destroy(TimetableSlot $timetableSlot)
    {
        $classroomId = $timetableSlot->classroom_id;
        $timetableSlot->delete();

        return redirect()->route('timetable.index', ['classroom_id' => $classroomId])
            ->with('success', 'Créneau supprimé.');
    }

    private function detectConflicts(Request $request)
    {
        $conflicts = collect();

        // Conflit de classe (même classe, même jour, horaires chevauchés)
        $classConflict = TimetableSlot::where('classroom_id', $request->classroom_id)
            ->where('day_of_week', $request->day_of_week)
            ->where(function ($q) use ($request) {
                $q->where(function ($q2) use ($request) {
                    $q2->where('start_time', '<', $request->end_time)
                        ->where('end_time', '>', $request->start_time);
                });
            })->first();

        if ($classConflict) {
            $conflicts->push("Cette classe a déjà un cours de {$classConflict->subject->name} le {$request->day_of_week} de {$classConflict->start_time} à {$classConflict->end_time}.");
        }

        // Conflit de salle (même salle, même jour, horaires chevauchés)
        if ($request->room) {
            $roomConflict = TimetableSlot::where('room', $request->room)
                ->where('day_of_week', $request->day_of_week)
                ->where('classroom_id', '!=', $request->classroom_id)
                ->where(function ($q) use ($request) {
                    $q->where('start_time', '<', $request->end_time)
                        ->where('end_time', '>', $request->start_time);
                })->first();

            if ($roomConflict) {
                $conflicts->push("La salle {$request->room} est déjà occupée le {$request->day_of_week} de {$roomConflict->start_time} à {$roomConflict->end_time} par la classe {$roomConflict->classroom->name}.");
            }
        }

        // Conflit enseignant (même enseignant, même jour, horaires chevauchés)
        if ($request->teacher_name) {
            $teacherConflict = TimetableSlot::where('teacher_name', $request->teacher_name)
                ->where('day_of_week', $request->day_of_week)
                ->where('classroom_id', '!=', $request->classroom_id)
                ->where(function ($q) use ($request) {
                    $q->where('start_time', '<', $request->end_time)
                        ->where('end_time', '>', $request->start_time);
                })->first();

            if ($teacherConflict) {
                $conflicts->push("L'enseignant {$request->teacher_name} a déjà un cours le {$request->day_of_week} de {$teacherConflict->start_time} à {$teacherConflict->end_time} en {$teacherConflict->classroom->name}.");
            }
        }

        return $conflicts;
    }
}

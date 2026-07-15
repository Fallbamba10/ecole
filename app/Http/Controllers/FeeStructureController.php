<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\FeeStructure;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;

class FeeStructureController extends Controller
{
    public function index(Request $request)
    {
        $classrooms = Classroom::all();
        $selectedClassroom = $request->classroom_id ? Classroom::find($request->classroom_id) : $classrooms->first();

        $fees = [];
        $students = collect();

        if ($selectedClassroom) {
            $fees = FeeStructure::where('classroom_id', $selectedClassroom->id)->get();

            $totalDue = $fees->sum(fn($f) => $f->amount * $f->occurrences);

            $students = Student::where('classroom_id', $selectedClassroom->id)
                ->where('status', 'actif')
                ->with('payments')
                ->get()
                ->map(function ($student) use ($totalDue) {
                    $paid = $student->payments->where('status', 'paye')->sum('amount');
                    $student->total_due = $totalDue;
                    $student->total_paid_amount = $paid;
                    $student->balance = $totalDue - $paid;
                    return $student;
                });
        }

        return view('fees.index', compact('classrooms', 'selectedClassroom', 'fees', 'students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'label' => 'required|string|max:255',
            'type' => 'required|in:inscription,mensualite,frais_examen,autre',
            'amount' => 'required|integer|min:1',
            'occurrences' => 'required|integer|min:1|max:12',
        ]);

        FeeStructure::create($request->only(['classroom_id', 'label', 'type', 'amount', 'occurrences']));

        return redirect()->route('fees.index', ['classroom_id' => $request->classroom_id])
            ->with('success', 'Frais ajouté.');
    }

    public function destroy(FeeStructure $fee)
    {
        $classroomId = $fee->classroom_id;
        $fee->delete();

        return redirect()->route('fees.index', ['classroom_id' => $classroomId])
            ->with('success', 'Frais supprimé.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\SchoolYear;
use App\Models\Student;
use Illuminate\Http\Request;

class SchoolYearController extends Controller
{
    public function index()
    {
        $schoolYears = SchoolYear::orderBy('start_date', 'desc')->get();
        return view('school-years.index', compact('schoolYears'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        SchoolYear::where('is_current', true)->update(['is_current' => false]);

        SchoolYear::create([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_current' => true,
        ]);

        return redirect()->route('school-years.index')->with('success', "Année scolaire {$request->name} créée et définie comme active.");
    }

    public function activate(SchoolYear $schoolYear)
    {
        SchoolYear::where('is_current', true)->update(['is_current' => false]);
        $schoolYear->update(['is_current' => true]);

        return redirect()->route('school-years.index')->with('success', "Année {$schoolYear->name} activée.");
    }

    public function promote(Request $request)
    {
        $request->validate([
            'promotions' => 'required|array',
            'promotions.*.from_classroom' => 'required|exists:classrooms,id',
            'promotions.*.to_classroom' => 'required|exists:classrooms,id',
        ]);

        $promoted = 0;

        foreach ($request->promotions as $promotion) {
            if ($promotion['from_classroom'] == $promotion['to_classroom']) {
                continue;
            }

            $count = Student::where('classroom_id', $promotion['from_classroom'])
                ->where('status', 'actif')
                ->update(['classroom_id' => $promotion['to_classroom']]);

            $promoted += $count;
        }

        return redirect()->route('school-years.index')->with('success', "{$promoted} élève(s) promu(s) avec succès.");
    }

    public function promoteForm()
    {
        $classrooms = Classroom::withCount('students')->get();
        return view('school-years.promote', compact('classrooms'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('classroom')->get();
        $classrooms = Classroom::all();

        return view('subjects.index', compact('subjects', 'classrooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'coefficient' => 'required|integer|min:1|max:10',
            'classroom_id' => 'required|exists:classrooms,id',
        ]);

        Subject::create($validated);

        return redirect()->route('subjects.index')
            ->with('success', 'Matière ajoutée.');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()->route('subjects.index')
            ->with('success', 'Matière supprimée.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::withCount('students')->get();

        return view('classrooms.index', compact('classrooms'));
    }

    public function create()
    {
        return view('classrooms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'nullable|string|max:255',
            'section' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer|min:1',
        ]);

        Classroom::create($validated);

        return redirect()->route('classrooms.index')
            ->with('success', 'Classe créée avec succès.');
    }

    public function show(Classroom $classroom)
    {
        $classroom->load('students');

        return view('classrooms.show', compact('classroom'));
    }

    public function edit(Classroom $classroom)
    {
        return view('classrooms.edit', compact('classroom'));
    }

    public function update(Request $request, Classroom $classroom)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'nullable|string|max:255',
            'section' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer|min:1',
        ]);

        $classroom->update($validated);

        return redirect()->route('classrooms.index')
            ->with('success', 'Classe modifiée avec succès.');
    }

    public function destroy(Classroom $classroom)
    {
        $classroom->delete();

        return redirect()->route('classrooms.index')
            ->with('success', 'Classe supprimée avec succès.');
    }
}

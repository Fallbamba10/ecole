<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with('classroom');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('classroom_id')) {
            $query->where('classroom_id', $request->classroom_id);
        }

        $students = $query->latest()->paginate(20)->withQueryString();
        $classrooms = Classroom::all();

        return view('students.index', compact('students', 'classrooms'));
    }

    public function create()
    {
        $classrooms = Classroom::all();

        return view('students.create', compact('classrooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:M,F',
            'phone' => 'nullable|string|max:20',
            'parent_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:20',
            'parent_email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'classroom_id' => 'nullable|exists:classrooms,id',
            'photo' => 'nullable|image|max:1024',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('students', 'public');
        }

        Student::create($validated);

        return redirect()->route('students.index')
            ->with('success', 'Étudiant inscrit avec succès.');
    }

    public function show(Student $student)
    {
        $student->load('classroom');

        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $classrooms = Classroom::all();

        return view('students.edit', compact('student', 'classrooms'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:M,F',
            'phone' => 'nullable|string|max:20',
            'parent_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:20',
            'parent_email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'classroom_id' => 'nullable|exists:classrooms,id',
            'status' => 'nullable|in:actif,suspendu,transfere,diplome',
            'photo' => 'nullable|image|max:1024',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('students', 'public');
        }

        $student->update($validated);

        return redirect()->route('students.index')
            ->with('success', 'Étudiant modifié avec succès.');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Étudiant supprimé avec succès.');
    }
}

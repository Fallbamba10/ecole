<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = User::where('school_id', app('current_school')->id)
            ->role('enseignant')
            ->with('classrooms')
            ->get();

        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        $classrooms = Classroom::all();
        return view('teachers.create', compact('classrooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', Rules\Password::defaults()],
            'classrooms' => 'required|array|min:1',
            'classrooms.*' => 'exists:classrooms,id',
        ]);

        $teacher = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'school_id' => app('current_school')->id,
        ]);

        $teacher->assignRole('enseignant');
        $teacher->classrooms()->sync($request->classrooms);

        return redirect()->route('teachers.index')->with('success', 'Enseignant ajouté avec succès.');
    }

    public function edit(User $teacher)
    {
        $classrooms = Classroom::all();
        $teacherClassrooms = $teacher->classrooms->pluck('id')->toArray();
        return view('teachers.edit', compact('teacher', 'classrooms', 'teacherClassrooms'));
    }

    public function update(Request $request, User $teacher)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $teacher->id,
            'classrooms' => 'required|array|min:1',
            'classrooms.*' => 'exists:classrooms,id',
        ]);

        $teacher->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $teacher->update(['password' => Hash::make($request->password)]);
        }

        $teacher->classrooms()->sync($request->classrooms);

        return redirect()->route('teachers.index')->with('success', 'Enseignant mis à jour.');
    }

    public function destroy(User $teacher)
    {
        $teacher->classrooms()->detach();
        $teacher->delete();

        return redirect()->route('teachers.index')->with('success', 'Enseignant supprimé.');
    }
}

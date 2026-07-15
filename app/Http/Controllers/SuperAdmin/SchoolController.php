<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::withCount(['users', 'students', 'classrooms'])->latest()->get();

        return view('super-admin.schools.index', compact('schools'));
    }

    public function create()
    {
        return view('super-admin.schools.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'subscription_plan' => 'required|in:trial,basic,standard,premium',
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|unique:users,email',
        ]);

        $school = School::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'subscription_plan' => $validated['subscription_plan'],
            'trial_ends_at' => $validated['subscription_plan'] === 'trial' ? now()->addDays(14) : null,
            'is_active' => true,
        ]);

        $admin = User::create([
            'name' => $validated['admin_name'],
            'email' => $validated['admin_email'],
            'password' => bcrypt('password'),
            'school_id' => $school->id,
        ]);
        $admin->assignRole('admin_ecole');

        return redirect()->route('super-admin.schools.index')
            ->with('success', 'École créée avec succès. Mot de passe admin : password');
    }

    public function edit(School $school)
    {
        return view('super-admin.schools.edit', compact('school'));
    }

    public function update(Request $request, School $school)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'subscription_plan' => 'required|in:trial,basic,standard,premium',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $school->update($validated);

        return redirect()->route('super-admin.schools.index')
            ->with('success', 'École mise à jour.');
    }

    public function destroy(School $school)
    {
        $school->delete();

        return redirect()->route('super-admin.schools.index')
            ->with('success', 'École supprimée.');
    }
}

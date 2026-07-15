<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeSchool;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class SchoolRegistrationController extends Controller
{
    public function create()
    {
        return view('auth.register-school');
    }

    public function store(Request $request)
    {
        $request->validate([
            'school_name' => ['required', 'string', 'max:255'],
            'school_email' => ['required', 'email', 'max:255'],
            'school_phone' => ['required', 'string', 'max:20'],
            'school_address' => ['required', 'string', 'max:255'],
            'admin_name' => ['required', 'string', 'max:255'],
            'admin_email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $school = School::create([
            'name' => $request->school_name,
            'slug' => Str::slug($request->school_name),
            'email' => $request->school_email,
            'phone' => $request->school_phone,
            'address' => $request->school_address,
            'subscription_plan' => 'trial',
            'trial_ends_at' => now()->addMonth(),
            'is_active' => true,
        ]);

        $user = User::create([
            'name' => $request->admin_name,
            'email' => $request->admin_email,
            'password' => Hash::make($request->password),
            'school_id' => $school->id,
        ]);

        $user->assignRole('admin_ecole');

        Mail::to($user->email)->queue(new WelcomeSchool($user, $school));

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Bienvenue ! Votre essai gratuit d\'un mois commence maintenant.');
    }
}

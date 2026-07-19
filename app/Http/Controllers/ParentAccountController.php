<?php

namespace App\Http\Controllers;

use App\Models\ParentInvitation;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ParentAccountController extends Controller
{
    public function index()
    {
        $school = auth()->user()->school;

        $parents = User::where('school_id', $school->id)
            ->role('parent')
            ->get();

        $invitations = ParentInvitation::where('school_id', $school->id)
            ->whereNull('used_at')
            ->where('expires_at', '>', now())
            ->with('student')
            ->latest()
            ->get();

        return view('parents.index', compact('parents', 'invitations'));
    }

    public function create()
    {
        $students = Student::with('classroom')
            ->orderBy('last_name')
            ->get();

        return view('parents.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'method' => 'required|in:create_direct,send_invitation',
            'parent_phone' => 'nullable|string|max:20',
        ]);

        $school = auth()->user()->school;
        $student = Student::where('school_id', $school->id)->findOrFail($request->student_id);
        $phone = $request->parent_phone ?: $student->parent_phone;
        $email = $student->parent_email;

        if (!$phone && !$email) {
            return back()->withInput()->with('error', 'Aucun contact parent trouvé. Remplissez le champ téléphone.');
        }

        // Mettre à jour la fiche élève si le phone était manquant
        if ($phone && !$student->parent_phone) {
            $student->update(['parent_phone' => $phone]);
        }

        if ($request->method === 'create_direct') {
            $request->validate([
                'password' => 'required|min:6',
            ]);

            $existingUser = User::where('email', $email)
                ->orWhere('phone', $phone)
                ->first();

            if ($existingUser) {
                return back()->with('error', 'Un compte existe déjà avec cet email ou ce téléphone.');
            }

            $user = User::create([
                'name' => $student->parent_name ?? 'Parent de ' . $student->full_name,
                'email' => $email ?? $phone . '@parent.schoolmanager.app',
                'phone' => $phone,
                'password' => Hash::make($request->password),
                'school_id' => $school->id,
            ]);
            $user->assignRole('parent');

            return redirect()->route('parents.index')->with('success',
                "Compte créé. Identifiants : " . ($email ?? $phone) . " / " . $request->password
            );
        }

        // Send invitation link
        $token = Str::random(48);
        ParentInvitation::create([
            'school_id' => $school->id,
            'student_id' => $student->id,
            'phone' => $phone,
            'email' => $email,
            'token' => $token,
            'expires_at' => now()->addDays(7),
        ]);

        $link = route('parent.register', $token);

        return redirect()->route('parents.index')->with('success',
            "Lien d'invitation généré (valable 7 jours). Envoyez ce lien au parent : " . $link
        );
    }

    public function showRegistrationForm(string $token)
    {
        $invitation = ParentInvitation::where('token', $token)->firstOrFail();

        if (!$invitation->isValid()) {
            return view('parents.invitation-expired');
        }

        return view('parents.register', compact('invitation'));
    }

    public function register(Request $request, string $token)
    {
        $invitation = ParentInvitation::where('token', $token)->firstOrFail();

        if (!$invitation->isValid()) {
            return view('parents.invitation-expired');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|min:6|confirmed',
        ]);

        $email = $invitation->email ?? $invitation->phone . '@parent.schoolmanager.app';

        $existingUser = User::where('email', $email)->first();
        if ($existingUser) {
            return back()->withErrors(['email' => 'Un compte existe déjà avec cette adresse.']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $email,
            'phone' => $invitation->phone,
            'password' => Hash::make($request->password),
            'school_id' => $invitation->school_id,
        ]);
        $user->assignRole('parent');

        $invitation->update(['used_at' => now()]);

        auth()->login($user);

        return redirect()->route('parent.index')->with('success', 'Bienvenue ! Votre compte parent a été créé.');
    }

    public function destroy(User $parent)
    {
        if (!$parent->hasRole('parent') || $parent->school_id !== auth()->user()->school_id) {
            abort(404);
        }
        $parent->delete();
        return back()->with('success', 'Compte parent supprimé.');
    }
}

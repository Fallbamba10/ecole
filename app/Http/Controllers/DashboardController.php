<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Payment;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('enseignant')) {
            return $this->teacherDashboard($user);
        }

        if ($user->hasRole('parent')) {
            return redirect()->route('parent.index');
        }

        if ($user->hasRole('secretaire')) {
            return $this->secretaireDashboard();
        }

        return $this->adminDashboard();
    }

    private function teacherDashboard($user)
    {
        $classrooms = $user->classrooms()->withCount('students')->get();
        $classroomIds = $classrooms->pluck('id');

        $totalStudents = Student::whereIn('classroom_id', $classroomIds)->count();

        $today = now()->toDateString();
        $attendancesToday = Attendance::whereIn('classroom_id', $classroomIds)->where('date', $today)->count();
        $absentToday = Attendance::whereIn('classroom_id', $classroomIds)->where('date', $today)->where('status', 'absent')->count();

        return view('dashboard-teacher', compact('classrooms', 'totalStudents', 'attendancesToday', 'absentToday'));
    }

    private function secretaireDashboard()
    {
        $totalStudents = Student::count();

        $totalPaye = Payment::where('status', 'paye')->sum('amount');
        $totalEnAttente = Payment::where('status', 'en_attente')->sum('amount');
        $totalEnRetard = Payment::where('status', 'en_retard')->sum('amount');
        $paymentsEnRetard = Payment::with('student.classroom')->where('status', 'en_retard')->latest()->take(10)->get();

        $recentPayments = Payment::with('student.classroom')->where('status', 'paye')->latest()->take(10)->get();

        return view('dashboard-secretaire', compact(
            'totalStudents',
            'totalPaye',
            'totalEnAttente',
            'totalEnRetard',
            'paymentsEnRetard',
            'recentPayments'
        ));
    }

    private function adminDashboard()
    {
        $totalStudents = Student::count();
        $totalClassrooms = Classroom::count();

        // Paiements
        $totalPaye = Payment::where('status', 'paye')->sum('amount');
        $totalEnAttente = Payment::where('status', 'en_attente')->sum('amount');
        $totalEnRetard = Payment::where('status', 'en_retard')->sum('amount');
        $paymentsEnRetard = Payment::with('student.classroom')->where('status', 'en_retard')->latest()->take(5)->get();

        // Présences du jour
        $today = now()->toDateString();
        $attendancesToday = Attendance::where('date', $today)->count();
        $absentToday = Attendance::where('date', $today)->where('status', 'absent')->count();

        // Taux de présence global (30 derniers jours)
        $totalAttendances = Attendance::where('date', '>=', now()->subDays(30))->count();
        $totalPresents = Attendance::where('date', '>=', now()->subDays(30))->where('status', 'present')->count();
        $tauxPresence = $totalAttendances > 0 ? round(($totalPresents / $totalAttendances) * 100, 1) : 0;

        // Paiements des 6 derniers mois (pour graphique)
        $paymentsPerMonth = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $amount = Payment::where('status', 'paye')
                ->whereYear('paid_at', $month->year)
                ->whereMonth('paid_at', $month->month)
                ->sum('amount');
            $paymentsPerMonth[] = [
                'month' => $month->translatedFormat('M Y'),
                'amount' => $amount,
            ];
        }

        // Dernières inscriptions
        $recentStudents = Student::with('classroom')->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalStudents',
            'totalClassrooms',
            'totalPaye',
            'totalEnAttente',
            'totalEnRetard',
            'paymentsEnRetard',
            'attendancesToday',
            'absentToday',
            'tauxPresence',
            'paymentsPerMonth',
            'recentStudents'
        ));
    }
}

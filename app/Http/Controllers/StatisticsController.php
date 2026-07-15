<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Grade;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index()
    {
        // Paiements des 12 derniers mois
        $paymentsPerMonth = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $paid = Payment::where('status', 'paye')
                ->whereYear('paid_at', $month->year)
                ->whereMonth('paid_at', $month->month)
                ->sum('amount');
            $paymentsPerMonth[] = [
                'month' => $month->translatedFormat('M Y'),
                'amount' => $paid,
            ];
        }

        // Présences des 30 derniers jours
        $attendancePerDay = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $total = Attendance::where('date', $date)->count();
            $present = Attendance::where('date', $date)->where('status', 'present')->count();
            $attendancePerDay[] = [
                'date' => now()->subDays($i)->format('d/m'),
                'total' => $total,
                'present' => $present,
                'absent' => $total - $present,
            ];
        }

        // Moyennes par classe
        $classrooms = Classroom::withCount('students')->get();
        $classAverages = [];
        foreach ($classrooms as $classroom) {
            $students = Student::where('classroom_id', $classroom->id)->pluck('id');
            $avg = Grade::whereIn('student_id', $students)->avg('value');
            $classAverages[] = [
                'name' => $classroom->name,
                'average' => $avg ? round($avg, 2) : 0,
                'students_count' => $classroom->students_count,
            ];
        }

        // Répartition élèves par classe (pour pie chart)
        $studentsPerClass = $classrooms->map(fn($c) => [
            'name' => $c->name,
            'count' => $c->students_count,
        ])->toArray();

        // Taux de recouvrement
        $totalExpected = Payment::sum('amount');
        $totalCollected = Payment::where('status', 'paye')->sum('amount');
        $recoveryRate = $totalExpected > 0 ? round(($totalCollected / $totalExpected) * 100, 1) : 0;

        // Statuts paiements
        $paymentStats = [
            'paye' => Payment::where('status', 'paye')->count(),
            'en_attente' => Payment::where('status', 'en_attente')->count(),
            'en_retard' => Payment::where('status', 'en_retard')->count(),
        ];

        return view('statistics.index', compact(
            'paymentsPerMonth',
            'attendancePerDay',
            'classAverages',
            'studentsPerClass',
            'recoveryRate',
            'paymentStats'
        ));
    }
}

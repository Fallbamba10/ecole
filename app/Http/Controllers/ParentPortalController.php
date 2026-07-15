<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class ParentPortalController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $students = Student::where('parent_phone', $user->phone)
            ->orWhere('parent_email', $user->email)
            ->with('classroom')
            ->get();

        $studentIds = $students->pluck('id');

        $todayAbsences = Attendance::whereIn('student_id', $studentIds)
            ->where('date', now()->toDateString())
            ->where('status', 'absent')
            ->count();

        $unpaidPayments = Payment::whereIn('student_id', $studentIds)
            ->whereIn('status', ['en_attente', 'en_retard'])
            ->sum('amount');

        $recentGrades = Grade::whereIn('student_id', $studentIds)
            ->with(['subject', 'student'])
            ->latest()
            ->take(5)
            ->get();

        return view('parent.index', compact('students', 'todayAbsences', 'unpaidPayments', 'recentGrades'));
    }

    public function grades(Student $student)
    {
        $this->authorizeParent($student);

        $grades = Grade::where('student_id', $student->id)
            ->with('subject')
            ->orderBy('period')
            ->get()
            ->groupBy('subject.name');

        $subjects = Subject::where('classroom_id', $student->classroom_id)->get();

        $periods = ['Trimestre 1', 'Trimestre 2', 'Trimestre 3'];
        $averages = [];
        foreach ($periods as $period) {
            $periodGrades = Grade::where('student_id', $student->id)
                ->where('period', $period)
                ->with('subject')
                ->get();

            $totalW = 0;
            $totalC = 0;
            foreach ($subjects as $subject) {
                $subGrades = $periodGrades->where('subject_id', $subject->id);
                if ($subGrades->isNotEmpty()) {
                    $avg = $subGrades->avg('value');
                    $totalW += $avg * $subject->coefficient;
                    $totalC += $subject->coefficient;
                }
            }
            $averages[$period] = $totalC > 0 ? round($totalW / $totalC, 2) : null;
        }

        return view('parent.grades', compact('student', 'grades', 'averages'));
    }

    public function attendances(Student $student)
    {
        $this->authorizeParent($student);

        $attendances = Attendance::where('student_id', $student->id)
            ->orderBy('date', 'desc')
            ->limit(60)
            ->get();

        $stats = [
            'total' => $attendances->count(),
            'present' => $attendances->where('status', 'present')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'late' => $attendances->where('status', 'retard')->count(),
        ];
        $stats['rate'] = $stats['total'] > 0 ? round(($stats['present'] / $stats['total']) * 100, 1) : 0;

        return view('parent.attendances', compact('student', 'attendances', 'stats'));
    }

    public function payments(Student $student)
    {
        $this->authorizeParent($student);

        $payments = Payment::where('student_id', $student->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $totalPaid = $payments->where('status', 'paye')->sum('amount');
        $totalPending = $payments->whereIn('status', ['en_attente', 'en_retard'])->sum('amount');

        return view('parent.payments', compact('student', 'payments', 'totalPaid', 'totalPending'));
    }

    public function bulletin(Student $student, Request $request)
    {
        $this->authorizeParent($student);
        $period = $request->get('period', 'Trimestre 1');

        return redirect()->route('bulletins.show', ['student' => $student, 'period' => $period]);
    }

    private function authorizeParent(Student $student)
    {
        $user = auth()->user();
        if ($user->hasRole('parent')) {
            $isParent = ($student->parent_email === $user->email) || ($student->parent_phone === $user->phone);
            if (!$isParent) {
                abort(403);
            }
        }
    }
}

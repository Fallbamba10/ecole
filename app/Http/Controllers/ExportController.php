<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Grade;
use App\Models\Payment;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function paymentsExport(Request $request)
    {
        $payments = Payment::with('student')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->orderBy('created_at', 'desc')
            ->get();

        if ($request->format === 'pdf') {
            $pdf = Pdf::loadView('exports.payments-pdf', compact('payments'));
            return $pdf->download('paiements.pdf');
        }

        return $this->exportCsv($payments, 'paiements.csv', [
            'Élève', 'Montant', 'Type', 'Méthode', 'Statut', 'Date'
        ], function ($payment) {
            return [
                $payment->student->full_name ?? 'N/A',
                $payment->amount,
                $payment->type,
                $payment->payment_method,
                $payment->status,
                $payment->created_at->format('d/m/Y'),
            ];
        });
    }

    public function attendancesExport(Request $request)
    {
        $attendances = Attendance::with(['student', 'classroom'])
            ->when($request->classroom_id, fn($q) => $q->where('classroom_id', $request->classroom_id))
            ->when($request->date, fn($q) => $q->whereDate('date', $request->date))
            ->orderBy('date', 'desc')
            ->get();

        if ($request->format === 'pdf') {
            $pdf = Pdf::loadView('exports.attendances-pdf', compact('attendances'));
            return $pdf->download('presences.pdf');
        }

        return $this->exportCsv($attendances, 'presences.csv', [
            'Élève', 'Classe', 'Date', 'Statut'
        ], function ($attendance) {
            return [
                $attendance->student->full_name ?? 'N/A',
                $attendance->classroom->name ?? 'N/A',
                $attendance->date,
                $attendance->status,
            ];
        });
    }

    public function gradesExport(Request $request)
    {
        $grades = Grade::with(['student', 'subject'])
            ->when($request->classroom_id, function ($q) use ($request) {
                $q->whereHas('student', fn($s) => $s->where('classroom_id', $request->classroom_id));
            })
            ->when($request->period, fn($q) => $q->where('period', $request->period))
            ->orderBy('created_at', 'desc')
            ->get();

        if ($request->format === 'pdf') {
            $pdf = Pdf::loadView('exports.grades-pdf', compact('grades'));
            return $pdf->download('notes.pdf');
        }

        return $this->exportCsv($grades, 'notes.csv', [
            'Élève', 'Matière', 'Note', 'Sur', 'Type', 'Période'
        ], function ($grade) {
            return [
                $grade->student->full_name ?? 'N/A',
                $grade->subject->name ?? 'N/A',
                $grade->value,
                $grade->max_value,
                $grade->type,
                $grade->period,
            ];
        });
    }

    public function studentsExport(Request $request)
    {
        $students = Student::with('classroom')
            ->when($request->classroom_id, fn($q) => $q->where('classroom_id', $request->classroom_id))
            ->orderBy('last_name')
            ->get();

        if ($request->format === 'pdf') {
            $pdf = Pdf::loadView('exports.students-pdf', compact('students'));
            return $pdf->download('eleves.pdf');
        }

        return $this->exportCsv($students, 'eleves.csv', [
            'Prénom', 'Nom', 'Genre', 'Classe', 'Statut'
        ], function ($student) {
            return [
                $student->first_name,
                $student->last_name,
                $student->gender,
                $student->classroom->name ?? 'N/A',
                $student->status,
            ];
        });
    }

    private function exportCsv($data, $filename, array $headers, callable $rowMapper)
    {
        $callback = function () use ($data, $headers, $rowMapper) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, $headers, ';');

            foreach ($data as $item) {
                fputcsv($file, $rowMapper($item), ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }
}

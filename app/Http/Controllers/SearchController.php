<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json(['results' => []]);
        }

        $students = Student::where(function ($q) use ($query) {
            $q->where('first_name', 'like', "%{$query}%")
              ->orWhere('last_name', 'like', "%{$query}%");
        })->with('classroom')->limit(5)->get()->map(function ($student) {
            return [
                'type' => 'student',
                'label' => $student->full_name,
                'detail' => $student->classroom->name ?? '',
                'url' => route('students.show', $student),
            ];
        });

        $payments = Payment::whereHas('student', function ($q) use ($query) {
            $q->where('first_name', 'like', "%{$query}%")
              ->orWhere('last_name', 'like', "%{$query}%");
        })->with('student')->limit(5)->get()->map(function ($payment) {
            return [
                'type' => 'payment',
                'label' => ($payment->student->full_name ?? 'N/A') . ' — ' . number_format($payment->amount, 0, ',', ' ') . ' FCFA',
                'detail' => $payment->status,
                'url' => route('payments.index', ['student' => $payment->student_id]),
            ];
        });

        $results = $students->concat($payments);

        return response()->json(['results' => $results]);
    }
}

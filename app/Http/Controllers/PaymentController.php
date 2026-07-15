<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Payment;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with('student.classroom');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->filled('classroom_id')) {
            $studentIds = Student::where('classroom_id', $request->classroom_id)->pluck('id');
            $query->whereIn('student_id', $studentIds);
        }

        $payments = $query->latest()->paginate(25)->withQueryString();
        $students = Student::all();
        $classrooms = Classroom::all();

        $totalPaye = Payment::where('status', 'paye')->sum('amount');
        $totalEnAttente = Payment::where('status', 'en_attente')->sum('amount');
        $totalEnRetard = Payment::where('status', 'en_retard')->sum('amount');

        return view('payments.index', compact('payments', 'students', 'classrooms', 'totalPaye', 'totalEnAttente', 'totalEnRetard'));
    }

    public function create()
    {
        $students = Student::all();

        return view('payments.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|integer|min:1',
            'type' => 'required|in:inscription,mensualite,frais_examen,autre',
            'payment_method' => 'required|in:especes,orange_money,wave,virement',
            'status' => 'required|in:paye,en_attente,en_retard',
            'due_date' => 'nullable|date',
            'paid_at' => 'nullable|date',
            'note' => 'nullable|string|max:500',
        ]);

        if ($validated['status'] === 'paye' && empty($validated['paid_at'])) {
            $validated['paid_at'] = now();
        }

        Payment::create($validated);

        return redirect()->route('payments.index')
            ->with('success', 'Paiement enregistré avec succès.');
    }

    public function show(Payment $payment)
    {
        $payment->load('student');

        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $students = Student::all();

        return view('payments.edit', compact('payment', 'students'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|integer|min:1',
            'type' => 'required|in:inscription,mensualite,frais_examen,autre',
            'payment_method' => 'required|in:especes,orange_money,wave,virement',
            'status' => 'required|in:paye,en_attente,en_retard',
            'due_date' => 'nullable|date',
            'paid_at' => 'nullable|date',
            'note' => 'nullable|string|max:500',
        ]);

        if ($validated['status'] === 'paye' && empty($validated['paid_at'])) {
            $validated['paid_at'] = now();
        }

        $payment->update($validated);

        return redirect()->route('payments.index')
            ->with('success', 'Paiement modifié avec succès.');
    }

    public function receipt(Payment $payment)
    {
        $payment->load('student.classroom');
        $school = app('current_school');

        $pdf = Pdf::loadView('exports.receipt-pdf', compact('payment', 'school'));
        return $pdf->inline("recu-{$payment->id}.pdf");
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('payments.index')
            ->with('success', 'Paiement supprimé.');
    }
}

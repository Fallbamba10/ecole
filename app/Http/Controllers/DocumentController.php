<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;

class DocumentController extends Controller
{
    public function attestation(Student $student)
    {
        $school = app('current_school');

        $pdf = Pdf::loadView('documents.attestation', [
            'student' => $student->load('classroom'),
            'school' => $school,
        ]);

        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream("attestation_{$student->last_name}_{$student->first_name}.pdf");
    }

    public function scolarite(Student $student)
    {
        $school = app('current_school');

        $pdf = Pdf::loadView('documents.scolarite', [
            'student' => $student->load('classroom'),
            'school' => $school,
        ]);

        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream("certificat_scolarite_{$student->last_name}_{$student->first_name}.pdf");
    }
}

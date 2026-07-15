<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class BulletinController extends Controller
{
    public function show(Request $request, Student $student)
    {
        $period = $request->get('period', 'Trimestre 1');
        $data = $this->computeBulletinData($student, $period);

        return view('bulletins.show', $data);
    }

    public function pdf(Request $request, Student $student)
    {
        $period = $request->get('period', 'Trimestre 1');
        $data = $this->computeBulletinData($student, $period);

        $pdf = Pdf::loadView('bulletins.pdf', $data);

        $filename = 'bulletin_' . str_replace(' ', '_', $student->full_name) . '_' . str_replace(' ', '_', $period) . '.pdf';

        return $pdf->download($filename);
    }

    private function computeBulletinData(Student $student, string $period): array
    {
        $student->load('classroom');
        $subjects = Subject::where('classroom_id', $student->classroom_id)->get();

        $results = [];
        $totalCoefficients = 0;
        $totalWeighted = 0;

        foreach ($subjects as $subject) {
            $grades = Grade::where('student_id', $student->id)
                ->where('subject_id', $subject->id)
                ->where('period', $period)
                ->get();

            $average = $grades->count() > 0
                ? round($grades->avg('value'), 2)
                : null;

            $results[] = [
                'subject' => $subject,
                'grades' => $grades,
                'average' => $average,
            ];

            if ($average !== null) {
                $totalCoefficients += $subject->coefficient;
                $totalWeighted += $average * $subject->coefficient;
            }
        }

        $generalAverage = $totalCoefficients > 0
            ? round($totalWeighted / $totalCoefficients, 2)
            : null;

        return compact('student', 'period', 'results', 'generalAverage', 'totalCoefficients');
    }
}

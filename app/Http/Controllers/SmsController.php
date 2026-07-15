<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Student;
use App\Services\SmsService;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::withCount('students')->get();
        return view('sms.index', compact('classrooms'));
    }

    public function send(Request $request, SmsService $smsService)
    {
        $request->validate([
            'message' => 'required|string|max:160',
            'target' => 'required|in:all,classroom,individual',
            'classroom_id' => 'required_if:target,classroom|nullable|exists:classrooms,id',
            'student_id' => 'required_if:target,individual|nullable|exists:students,id',
        ]);

        $students = match ($request->target) {
            'all' => Student::where('status', 'actif')->whereNotNull('parent_phone')->get(),
            'classroom' => Student::where('classroom_id', $request->classroom_id)
                ->where('status', 'actif')
                ->whereNotNull('parent_phone')
                ->get(),
            'individual' => Student::where('id', $request->student_id)
                ->whereNotNull('parent_phone')
                ->get(),
        };

        $sent = 0;
        $failed = 0;

        foreach ($students as $student) {
            $personalMessage = str_replace(
                ['{eleve}', '{classe}', '{parent}'],
                [$student->full_name, $student->classroom?->name ?? '', $student->parent_name ?? 'Parent'],
                $request->message
            );

            if ($smsService->send($student->parent_phone, $personalMessage)) {
                $sent++;
            } else {
                $failed++;
            }
        }

        return redirect()->route('sms.index')
            ->with('success', "{$sent} SMS envoyé(s) avec succès." . ($failed > 0 ? " {$failed} échec(s)." : ''));
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentApiController extends Controller
{
    /**
     * Paginated list of students for the authenticated user's school.
     */
    public function index(Request $request): JsonResponse
    {
        $this->bindCurrentSchool($request);

        $query = Student::with('classroom');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        if ($request->has('classroom_id')) {
            $query->where('classroom_id', $request->input('classroom_id'));
        }

        $students = $query->orderBy('last_name')->paginate($request->input('per_page', 20));

        return response()->json([
            'data' => StudentResource::collection($students),
            'meta' => [
                'current_page' => $students->currentPage(),
                'last_page' => $students->lastPage(),
                'per_page' => $students->perPage(),
                'total' => $students->total(),
            ],
            'message' => 'Liste des eleves recuperee.',
        ]);
    }

    /**
     * Student detail with classroom and grades summary.
     */
    public function show(Request $request, Student $student): JsonResponse
    {
        $this->bindCurrentSchool($request);

        // Ensure the student belongs to the user's school
        if ($student->school_id !== $request->user()->school_id) {
            return response()->json([
                'data' => null,
                'message' => 'Eleve non trouve.',
            ], 404);
        }

        $student->load(['classroom', 'grades.subject', 'attendances', 'payments']);

        $gradesAverage = $student->grades->count() > 0
            ? round($student->grades->avg('value'), 2)
            : null;

        return response()->json([
            'data' => [
                'student' => new StudentResource($student),
                'grades_average' => $gradesAverage,
                'total_paid' => $student->total_paid,
                'absences_count' => $student->attendances->where('status', 'absent')->count(),
            ],
            'message' => 'Detail de l\'eleve recupere.',
        ]);
    }

    /**
     * Bind the current school in the container for global scopes.
     */
    private function bindCurrentSchool(Request $request): void
    {
        if ($request->user() && $request->user()->school_id) {
            app()->instance('current_school', $request->user()->school);
        }
    }
}

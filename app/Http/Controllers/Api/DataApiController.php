<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendanceResource;
use App\Http\Resources\ClassroomResource;
use App\Http\Resources\GradeResource;
use App\Http\Resources\PaymentResource;
use App\Models\Announcement;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Grade;
use App\Models\Student;
use App\Models\TimetableSlot;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DataApiController extends Controller
{
    /**
     * List classrooms for the user's school.
     */
    public function classrooms(Request $request): JsonResponse
    {
        $this->bindCurrentSchool($request);

        $classrooms = Classroom::withCount('students')->orderBy('name')->get();

        return response()->json([
            'data' => ClassroomResource::collection($classrooms),
            'message' => 'Liste des classes recuperee.',
        ]);
    }

    /**
     * Student grades with subjects.
     */
    public function grades(Request $request, Student $student): JsonResponse
    {
        $this->bindCurrentSchool($request);

        if ($student->school_id !== $request->user()->school_id) {
            return response()->json([
                'data' => null,
                'message' => 'Eleve non trouve.',
            ], 404);
        }

        $grades = $student->grades()->with('subject')->orderByDesc('created_at')->get();

        return response()->json([
            'data' => GradeResource::collection($grades),
            'message' => 'Notes de l\'eleve recuperees.',
        ]);
    }

    /**
     * Student attendance history.
     */
    public function attendances(Request $request, Student $student): JsonResponse
    {
        $this->bindCurrentSchool($request);

        if ($student->school_id !== $request->user()->school_id) {
            return response()->json([
                'data' => null,
                'message' => 'Eleve non trouve.',
            ], 404);
        }

        $attendances = $student->attendances()->orderByDesc('date')->get();

        return response()->json([
            'data' => AttendanceResource::collection($attendances),
            'message' => 'Presences de l\'eleve recuperees.',
        ]);
    }

    /**
     * Student payments.
     */
    public function payments(Request $request, Student $student): JsonResponse
    {
        $this->bindCurrentSchool($request);

        if ($student->school_id !== $request->user()->school_id) {
            return response()->json([
                'data' => null,
                'message' => 'Eleve non trouve.',
            ], 404);
        }

        $payments = $student->payments()->orderByDesc('created_at')->get();

        return response()->json([
            'data' => PaymentResource::collection($payments),
            'message' => 'Paiements de l\'eleve recuperes.',
        ]);
    }

    /**
     * Batch mark attendance for multiple students.
     */
    public function storeAttendance(Request $request): JsonResponse
    {
        $this->bindCurrentSchool($request);

        $request->validate([
            'date' => ['required', 'date'],
            'classroom_id' => ['required', 'exists:classrooms,id'],
            'attendances' => ['required', 'array', 'min:1'],
            'attendances.*.student_id' => ['required', 'exists:students,id'],
            'attendances.*.status' => ['required', 'in:present,absent,retard,excuse'],
            'attendances.*.comment' => ['nullable', 'string', 'max:255'],
        ]);

        $schoolId = $request->user()->school_id;
        $created = [];

        foreach ($request->input('attendances') as $entry) {
            $created[] = Attendance::create([
                'student_id' => $entry['student_id'],
                'classroom_id' => $request->input('classroom_id'),
                'school_id' => $schoolId,
                'date' => $request->input('date'),
                'status' => $entry['status'],
                'comment' => $entry['comment'] ?? null,
            ]);
        }

        return response()->json([
            'data' => AttendanceResource::collection($created),
            'message' => 'Presences enregistrees avec succes.',
        ], 201);
    }

    /**
     * Add a grade for a student.
     */
    public function storeGrade(Request $request): JsonResponse
    {
        $this->bindCurrentSchool($request);

        $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'period' => ['required', 'string', 'max:50'],
            'type' => ['required', 'string', 'max:50'],
            'value' => ['required', 'numeric', 'min:0'],
            'max_value' => ['required', 'numeric', 'min:0'],
            'comment' => ['nullable', 'string', 'max:255'],
        ]);

        $grade = Grade::create([
            'student_id' => $request->input('student_id'),
            'subject_id' => $request->input('subject_id'),
            'school_id' => $request->user()->school_id,
            'period' => $request->input('period'),
            'type' => $request->input('type'),
            'value' => $request->input('value'),
            'max_value' => $request->input('max_value'),
            'comment' => $request->input('comment'),
        ]);

        $grade->load('subject');

        return response()->json([
            'data' => new GradeResource($grade),
            'message' => 'Note ajoutee avec succes.',
        ], 201);
    }

    /**
     * List announcements for the user's school.
     */
    public function announcements(Request $request): JsonResponse
    {
        $this->bindCurrentSchool($request);

        $announcements = Announcement::with('author')
            ->orderByDesc('created_at')
            ->paginate($request->input('per_page', 20));

        return response()->json([
            'data' => $announcements->map(function ($announcement) {
                return [
                    'id' => $announcement->id,
                    'title' => $announcement->title,
                    'content' => $announcement->content,
                    'target' => $announcement->target,
                    'author' => $announcement->author?->name,
                    'classroom_id' => $announcement->classroom_id,
                    'created_at' => $announcement->created_at->toIso8601String(),
                ];
            }),
            'meta' => [
                'current_page' => $announcements->currentPage(),
                'last_page' => $announcements->lastPage(),
                'per_page' => $announcements->perPage(),
                'total' => $announcements->total(),
            ],
            'message' => 'Annonces recuperees.',
        ]);
    }

    /**
     * Get timetable for the authenticated user's classrooms.
     */
    public function timetable(Request $request): JsonResponse
    {
        $this->bindCurrentSchool($request);

        $user = $request->user();

        // Get classrooms the user is associated with
        $classroomIds = $user->classrooms()->pluck('classrooms.id');

        $slots = TimetableSlot::with(['classroom', 'subject'])
            ->whereIn('classroom_id', $classroomIds)
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get()
            ->map(function ($slot) {
                return [
                    'id' => $slot->id,
                    'day_of_week' => $slot->day_of_week,
                    'start_time' => $slot->start_time,
                    'end_time' => $slot->end_time,
                    'room' => $slot->room,
                    'teacher_name' => $slot->teacher_name,
                    'subject' => $slot->subject?->name,
                    'classroom' => $slot->classroom?->name,
                ];
            });

        return response()->json([
            'data' => $slots,
            'message' => 'Emploi du temps recupere.',
        ]);
    }

    /**
     * User notifications.
     */
    public function notifications(Request $request): JsonResponse
    {
        $notifications = $request->user()
            ->notifications()
            ->orderByDesc('created_at')
            ->paginate($request->input('per_page', 20));

        return response()->json([
            'data' => $notifications->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'type' => $notification->type,
                    'data' => $notification->data,
                    'read_at' => $notification->read_at?->toIso8601String(),
                    'created_at' => $notification->created_at->toIso8601String(),
                ];
            }),
            'meta' => [
                'current_page' => $notifications->currentPage(),
                'last_page' => $notifications->lastPage(),
                'per_page' => $notifications->perPage(),
                'total' => $notifications->total(),
                'unread_count' => $request->user()->unreadNotifications()->count(),
            ],
            'message' => 'Notifications recuperees.',
        ]);
    }

    /**
     * Mark a notification as read.
     */
    public function markNotificationRead(Request $request, string $id): JsonResponse
    {
        $notification = $request->user()
            ->notifications()
            ->where('id', $id)
            ->first();

        if (! $notification) {
            return response()->json([
                'data' => null,
                'message' => 'Notification non trouvee.',
            ], 404);
        }

        $notification->markAsRead();

        return response()->json([
            'data' => [
                'id' => $notification->id,
                'read_at' => $notification->read_at->toIso8601String(),
            ],
            'message' => 'Notification marquee comme lue.',
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

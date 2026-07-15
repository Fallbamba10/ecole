<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnseignantRestriction
{
    private array $allowedRoutes = [
        'dashboard',
        'logout',
        'classrooms.index',
        'classrooms.show',
        'students.index',
        'students.show',
        'grades.*',
        'grades.batch',
        'grades.batch.store',
        'attendances.*',
        'subjects.index',
        'timetable.index',
        'bulletins.*',
        'announcements.index',
        'announcements.create',
        'announcements.store',
        'profile.*',
        'notifications.*',
        'messages.*',
        'search',
        'subscription.*',
    ];

    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user || !$user->hasRole('enseignant')) {
            return $next($request);
        }

        $currentRoute = $request->route()?->getName();

        if (!$currentRoute) {
            return $next($request);
        }

        foreach ($this->allowedRoutes as $pattern) {
            if ($currentRoute === $pattern || fnmatch($pattern, $currentRoute)) {
                return $next($request);
            }
        }

        abort(403, 'Accès non autorisé pour ce rôle.');
    }
}

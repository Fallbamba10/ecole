<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecretaireRestriction
{
    private array $allowedRoutes = [
        'dashboard',
        'logout',
        'payments.*',
        'students.index',
        'students.show',
        'fees.*',
        'documents.*',
        'profile.*',
        'notifications.*',
        'messages.*',
        'search',
        'school.settings',
        'subscription.*',
    ];

    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user || !$user->hasRole('secretaire')) {
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

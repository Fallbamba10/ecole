<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ParentRestriction
{
    private array $allowedRoutes = [
        'dashboard',
        'logout',
        'parent.*',
        'profile.*',
        'notifications.*',
        'messages.*',
        'subscription.*',
        'language.switch',
    ];

    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user || !$user->hasRole('parent')) {
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

        return redirect()->route('parent.index');
    }
}

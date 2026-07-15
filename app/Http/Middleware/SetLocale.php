<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Supported locales.
     */
    protected array $supportedLocales = ['fr', 'en'];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $this->resolveLocale($request);

        app()->setLocale($locale);

        return $next($request);
    }

    /**
     * Resolve the locale from session, user preference, or config fallback.
     */
    protected function resolveLocale(Request $request): string
    {
        // 1. Check session
        if ($sessionLocale = session('locale')) {
            if (in_array($sessionLocale, $this->supportedLocales)) {
                return $sessionLocale;
            }
        }

        // 2. Check authenticated user's preference
        if (Auth::check() && Auth::user()->locale) {
            $userLocale = Auth::user()->locale;
            if (in_array($userLocale, $this->supportedLocales)) {
                return $userLocale;
            }
        }

        // 3. Fall back to config
        return config('app.locale', 'fr');
    }
}

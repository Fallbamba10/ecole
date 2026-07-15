<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LanguageController extends Controller
{
    /**
     * Allowed locales.
     */
    protected array $allowedLocales = ['fr', 'en'];

    /**
     * Switch the application locale.
     */
    public function switch(Request $request, string $locale): RedirectResponse
    {
        if (!in_array($locale, $this->allowedLocales)) {
            abort(400, 'Locale not supported.');
        }

        // Store in session
        session(['locale' => $locale]);

        // Update user preference if authenticated
        if (Auth::check()) {
            Auth::user()->update(['locale' => $locale]);
        }

        return redirect()->back();
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || $user->hasRole('super_admin')) {
            return $next($request);
        }

        $school = $user->school;

        if (!$school) {
            return $next($request);
        }

        if (!$school->is_active) {
            return redirect()->route('subscription.expired');
        }

        // Récupérer l'abonnement actif
        $subscription = $school->subscriptions()
            ->where('status', 'active')
            ->latest()
            ->first();

        // Si pas d'abonnement dans la table subscriptions, vérifier l'ancien système
        if (!$subscription) {
            // Vérifier si l'essai gratuit est expiré et pas d'abonnement payant
            if ($school->subscription_plan === 'trial' && $school->trial_ends_at && $school->trial_ends_at->isPast()) {
                return redirect()->route('subscription.expired');
            }

            // Plan gratuit par défaut - on laisse passer mais on applique les limites
            $currentPlan = $school->subscription_plan === 'trial' ? 'free' : $school->subscription_plan;
        } else {
            // Vérifier si l'abonnement est expiré
            if ($subscription->ends_at && $subscription->ends_at->isPast()) {
                $subscription->update(['status' => 'expired']);
                return redirect()->route('subscription.expired');
            }

            $currentPlan = $subscription->plan;
        }

        // Vérifier les limites pour les routes de création
        $routeName = $request->route()?->getName();

        if ($routeName && $this->shouldCheckLimits($routeName, $request)) {
            $limits = config("plans.{$currentPlan}.limits", []);
            $limitExceeded = $this->checkLimits($school, $limits, $routeName);

            if ($limitExceeded) {
                return back()->with('error', $limitExceeded);
            }
        }

        return $next($request);
    }

    /**
     * Détermine si les limites doivent être vérifiées pour cette route.
     */
    private function shouldCheckLimits(string $routeName, Request $request): bool
    {
        // Vérifier uniquement les routes de création (POST)
        if (!$request->isMethod('POST') && !$request->isMethod('PUT')) {
            return false;
        }

        $limitedRoutes = [
            'students.store',
            'students.import.store',
            'classrooms.store',
            'sms.send',
        ];

        return in_array($routeName, $limitedRoutes);
    }

    /**
     * Vérifie si les limites du plan sont atteintes.
     * Retourne un message d'erreur si une limite est dépassée, null sinon.
     */
    private function checkLimits($school, array $limits, string $routeName): ?string
    {
        // Limite d'élèves
        if (in_array($routeName, ['students.store', 'students.import.store'])) {
            $maxStudents = $limits['students'] ?? null;
            if ($maxStudents !== null) {
                $currentCount = $school->students()->count();
                if ($currentCount >= $maxStudents) {
                    return "Limite atteinte : votre plan autorise {$maxStudents} élèves maximum. Passez à un plan supérieur pour en ajouter davantage.";
                }
            }
        }

        // Limite de classes
        if ($routeName === 'classrooms.store') {
            $maxClassrooms = $limits['classrooms'] ?? null;
            if ($maxClassrooms !== null) {
                $currentCount = $school->classrooms()->count();
                if ($currentCount >= $maxClassrooms) {
                    return "Limite atteinte : votre plan autorise {$maxClassrooms} classes maximum. Passez à un plan supérieur pour en ajouter davantage.";
                }
            }
        }

        // Limite de SMS
        if ($routeName === 'sms.send') {
            $maxSms = $limits['sms_per_month'] ?? null;
            if ($maxSms !== null && $maxSms === 0) {
                return "Votre plan ne comprend pas l'envoi de SMS. Passez à un plan supérieur pour activer cette fonctionnalité.";
            }
            // Note: pour un suivi précis des SMS envoyés ce mois-ci,
            // il faudrait un compteur dans la base de données.
        }

        return null;
    }
}

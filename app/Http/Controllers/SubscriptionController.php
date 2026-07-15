<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Affiche la page d'abonnement avec les plans disponibles.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $school = $user->school;
        $plans = config('plans');

        $currentSubscription = $school->subscriptions()
            ->where('status', 'active')
            ->latest()
            ->first();

        $currentPlan = $currentSubscription?->plan ?? 'free';

        return view('subscription.index', compact('plans', 'currentPlan', 'currentSubscription', 'school'));
    }

    /**
     * Changer de plan (upgrade/downgrade).
     * Seuls les admins peuvent effectuer cette action.
     */
    public function changePlan(Request $request)
    {
        $user = $request->user();

        // Vérifier que l'utilisateur est admin
        if (!$user->hasRole('admin') && !$user->hasRole('super_admin')) {
            abort(403, 'Seul un administrateur peut changer de plan.');
        }

        $request->validate([
            'plan' => 'required|in:free,starter,pro,enterprise',
        ]);

        $school = $user->school;
        $newPlan = $request->input('plan');
        $planConfig = config("plans.{$newPlan}");

        if (!$planConfig) {
            return back()->with('error', 'Plan invalide.');
        }

        // Désactiver l'abonnement actuel
        $school->subscriptions()
            ->where('status', 'active')
            ->update(['status' => 'expired', 'ends_at' => now()]);

        // Créer le nouvel abonnement
        $subscription = Subscription::create([
            'school_id' => $school->id,
            'plan' => $newPlan,
            'status' => 'active',
            'starts_at' => now(),
            'ends_at' => now()->addMonth(),
            'amount' => $planConfig['price'],
            'payment_method' => $newPlan === 'free' ? 'none' : 'pending',
        ]);

        // Mettre à jour le plan sur la table schools
        $school->update(['subscription_plan' => $newPlan]);

        return redirect()->route('subscription.index')
            ->with('success', "Plan changé avec succès vers {$planConfig['name']}.");
    }

    /**
     * Affiche l'historique de facturation.
     */
    public function billingHistory(Request $request)
    {
        $user = $request->user();
        $school = $user->school;

        $subscriptions = $school->subscriptions()
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('subscription.billing', compact('subscriptions', 'school'));
    }
}

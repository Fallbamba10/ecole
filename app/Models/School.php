<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'address',
        'logo',
        'subscription_plan',
        'trial_ends_at',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'trial_ends_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Retourne l'abonnement actif de l'école.
     */
    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)
            ->where('status', 'active')
            ->latest();
    }

    /**
     * Retourne le plan actuel (depuis la table subscriptions ou le champ legacy).
     */
    public function getCurrentPlan(): string
    {
        $subscription = $this->subscriptions()
            ->where('status', 'active')
            ->latest()
            ->first();

        if ($subscription) {
            return $subscription->plan;
        }

        return $this->subscription_plan === 'trial' ? 'free' : ($this->subscription_plan ?? 'free');
    }
}

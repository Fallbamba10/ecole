<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'school_id',
        'plan',
        'status',
        'trial_ends_at',
        'starts_at',
        'ends_at',
        'amount',
        'payment_method',
    ];

    protected function casts(): array
    {
        return [
            'trial_ends_at' => 'datetime',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'amount' => 'integer',
        ];
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Vérifie si l'abonnement est actif.
     */
    public function isActive(): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        // Si une date de fin est définie, vérifier qu'elle n'est pas dépassée
        if ($this->ends_at && $this->ends_at->isPast()) {
            return false;
        }

        return true;
    }

    /**
     * Vérifie si l'abonnement est en période d'essai.
     */
    public function onTrial(): bool
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    /**
     * Retourne les limites du plan actuel.
     */
    public function getPlanLimits(): array
    {
        return config("plans.{$this->plan}.limits", []);
    }

    /**
     * Retourne les infos du plan actuel.
     */
    public function getPlanDetails(): array
    {
        return config("plans.{$this->plan}", []);
    }
}

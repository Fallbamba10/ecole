<?php

namespace App\Traits;

use App\Models\School;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToSchool
{
    protected static function bootBelongsToSchool(): void
    {
        static::creating(function ($model) {
            if (app()->bound('current_school')) {
                $model->school_id = app('current_school')->id;
            }
        });

        static::addGlobalScope('school', function (Builder $builder) {
            if (app()->bound('current_school')) {
                $builder->where($builder->getModel()->getTable() . '.school_id', app('current_school')->id);
            }
        });
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Level extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'order',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the courses for this level.
     */
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class)->orderBy('order');
    }

    /**
     * Get only active courses for this level.
     */
    public function activeCourses(): HasMany
    {
        return $this->hasMany(Course::class)->where('is_active', true)->orderBy('order');
    }

    /**
     * Scope a query to only include active levels.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order levels by their order field.
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order');
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get formatted level name accessor.
     */
    public function getFormattedNameAttribute(): string
    {
        return ucwords(str_replace('-', ' ', $this->name));
    }

    /**
     * Get total courses count for this level.
     */
    public function getCoursesCountAttribute(): int
    {
        return $this->courses()->count();
    }

    /**
     * Get total active courses count for this level.
     */
    public function getActiveCoursesCountAttribute(): int
    {
        return $this->activeCourses()->count();
    }
}

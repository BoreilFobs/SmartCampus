<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'level_id',
        'title',
        'slug',
        'description',
        'thumbnail_path',
        'order',
        'is_active',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'level_id' => 'integer',
        'created_by' => 'integer',
    ];

    /**
     * Get the level that this course belongs to.
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    /**
     * Get the videos for this course.
     */
    public function videos(): HasMany
    {
        return $this->hasMany(Video::class)->orderBy('order');
    }

    /**
     * Get only active videos for this course.
     */
    public function activeVideos(): HasMany
    {
        return $this->hasMany(Video::class)->where('is_active', true)->orderBy('order');
    }

    /**
     * Get the admin who created this course.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope a query to only include active courses.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter courses by level.
     */
    public function scopeByLevel(Builder $query, int $levelId): Builder
    {
        return $query->where('level_id', $levelId);
    }

    /**
     * Scope a query to order courses by their order field.
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order');
    }

    /**
     * Scope a query to search courses by title or description.
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get thumbnail URL accessor.
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        if ($this->thumbnail_path) {
            return Storage::url($this->thumbnail_path);
        }
        return null;
    }

    /**
     * Get total videos count for this course.
     */
    public function getVideosCountAttribute(): int
    {
        return $this->videos()->count();
    }

    /**
     * Get total active videos count for this course.
     */
    public function getActiveVideosCountAttribute(): int
    {
        return $this->activeVideos()->count();
    }

    /**
     * Get total duration of all videos in seconds.
     */
    public function getTotalDurationAttribute(): int
    {
        return $this->videos()->sum('duration') ?? 0;
    }

    /**
     * Get formatted total duration (HH:MM:SS).
     */
    public function getFormattedTotalDurationAttribute(): string
    {
        $seconds = $this->total_duration;
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;

        if ($hours > 0) {
            return sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
        }
        return sprintf('%02d:%02d', $minutes, $secs);
    }
}

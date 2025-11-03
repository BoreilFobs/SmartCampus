<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class Video extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'title',
        'description',
        'video_path',
        'thumbnail_path',
        'file_size',
        'duration',
        'order',
        'is_active',
        'uploaded_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'course_id' => 'integer',
        'file_size' => 'integer',
        'duration' => 'integer',
        'uploaded_by' => 'integer',
    ];

    /**
     * Get the course that this video belongs to.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the notes for this video.
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    /**
     * Get the admin who uploaded this video.
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Scope a query to only include active videos.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order videos by their order field.
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order');
    }

    /**
     * Scope a query to filter videos by course.
     */
    public function scopeByCourse(Builder $query, int $courseId): Builder
    {
        return $query->where('course_id', $courseId);
    }

    /**
     * Get video URL accessor.
     */
    public function getVideoUrlAttribute(): string
    {
        return Storage::url($this->video_path);
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
     * Get formatted duration (HH:MM:SS or MM:SS).
     */
    public function getFormattedDurationAttribute(): string
    {
        $seconds = $this->duration ?? 0;
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;

        if ($hours > 0) {
            return sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
        }
        return sprintf('%02d:%02d', $minutes, $secs);
    }

    /**
     * Get formatted file size (KB, MB, GB).
     */
    public function getFormattedFileSizeAttribute(): string
    {
        $bytes = $this->file_size ?? 0;
        
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        
        return $bytes . ' bytes';
    }

    /**
     * Get the next video in the course.
     */
    public function getNextVideoAttribute(): ?Video
    {
        return static::where('course_id', $this->course_id)
            ->where('order', '>', $this->order)
            ->where('is_active', true)
            ->orderBy('order')
            ->first();
    }

    /**
     * Get the previous video in the course.
     */
    public function getPreviousVideoAttribute(): ?Video
    {
        return static::where('course_id', $this->course_id)
            ->where('order', '<', $this->order)
            ->where('is_active', true)
            ->orderBy('order', 'desc')
            ->first();
    }

    /**
     * Check if video has any notes.
     */
    public function hasNotes(): bool
    {
        return $this->notes()->exists();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Note extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'video_id',
        'content',
        'pdf_path',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'video_id' => 'integer',
        'created_by' => 'integer',
    ];

    /**
     * Get the video that this note belongs to.
     */
    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class);
    }

    /**
     * Get the admin who created this note.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get PDF URL accessor.
     */
    public function getPdfUrlAttribute(): ?string
    {
        if ($this->pdf_path) {
            return Storage::url($this->pdf_path);
        }
        return null;
    }

    /**
     * Get PDF download URL accessor.
     */
    public function getPdfDownloadUrlAttribute(): ?string
    {
        if ($this->pdf_path) {
            return Storage::download($this->pdf_path);
        }
        return null;
    }

    /**
     * Check if note has PDF attachment.
     */
    public function hasPdf(): bool
    {
        return !empty($this->pdf_path) && Storage::exists($this->pdf_path);
    }

    /**
     * Check if note has content.
     */
    public function hasContent(): bool
    {
        return !empty($this->content);
    }

    /**
     * Get formatted content with HTML stripped for preview.
     */
    public function getContentPreviewAttribute(): string
    {
        return strip_tags($this->content ?? '');
    }
}

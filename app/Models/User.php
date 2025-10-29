<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Get the courses created by this admin.
     */
    public function createdCourses(): HasMany
    {
        return $this->hasMany(Course::class, 'created_by');
    }

    /**
     * Get the videos uploaded by this admin.
     */
    public function uploadedVideos(): HasMany
    {
        return $this->hasMany(Video::class, 'uploaded_by');
    }

    /**
     * Get the notes created by this admin.
     */
    public function createdNotes(): HasMany
    {
        return $this->hasMany(Note::class, 'created_by');
    }

    /**
     * Check if user is an administrator.
     */
    public function isAdmin(): bool
    {
        return $this->is_admin === true;
    }

    /**
     * Scope a query to only include admin users.
     */
    public function scopeAdmins(Builder $query): Builder
    {
        return $query->where('is_admin', true);
    }

    /**
     * Scope a query to only include regular users.
     */
    public function scopeRegularUsers(Builder $query): Builder
    {
        return $query->where('is_admin', false);
    }

    /**
     * Get total courses created by this admin.
     */
    public function getCreatedCoursesCountAttribute(): int
    {
        return $this->createdCourses()->count();
    }

    /**
     * Get total videos uploaded by this admin.
     */
    public function getUploadedVideosCountAttribute(): int
    {
        return $this->uploadedVideos()->count();
    }

    /**
     * Get total notes created by this admin.
     */
    public function getCreatedNotesCountAttribute(): int
    {
        return $this->createdNotes()->count();
    }
}

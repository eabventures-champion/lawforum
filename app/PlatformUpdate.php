<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlatformUpdate extends Model
{
    protected $table = 'platform_updates';

    protected $fillable = [
        'title',
        'slug',
        'badge_text',
        'target_role',
        'summary',
        'content',
        'tour_steps',
        'is_active',
    ];

    protected $casts = [
        'tour_steps' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Scope for active updates
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for updates matching a user role (general 'all' or specific role)
     */
    public function scopeForUserRole($query, $role = null)
    {
        return $query->where(function ($q) use ($role) {
            $q->where('target_role', 'all');
            if (!empty($role) && $role !== 'all') {
                $q->orWhere('target_role', $role);
            }
        });
    }

    /**
     * Users who have interacted with this update
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_platform_updates', 'update_id', 'user_id')
            ->withPivot('read_at', 'tour_completed_at')
            ->withTimestamps();
    }

    /**
     * Check if a specific user has read this update
     */
    public function isReadByUser($userId)
    {
        return \DB::table('user_platform_updates')
            ->where('update_id', $this->id)
            ->where('user_id', $userId)
            ->whereNotNull('read_at')
            ->exists();
    }
}

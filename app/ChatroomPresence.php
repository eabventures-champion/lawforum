<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatroomPresence extends Model
{
    protected $fillable = [
        'session_id', 'user_id', 'category', 'last_seen_at'
    ];

    protected $casts = [
        'last_seen_at' => 'datetime',
    ];

    /**
     * Heartbeat to record current user presence in a category
     */
    public static function touchPresence($category, $sessionId, $userId = null)
    {
        return static::updateOrCreate(
            ['session_id' => $sessionId, 'category' => $category],
            ['user_id' => $userId, 'last_seen_at' => now()]
        );
    }

    /**
     * Get active count of users in a category (seen in last 5 minutes)
     */
    public static function getOnlineCount($category = 'all')
    {
        $cutoff = now()->subMinutes(5);
        $query = static::where('last_seen_at', '>=', $cutoff);

        if ($category && $category !== 'all') {
            $query->where('category', $category);
        }

        $count = $query->distinct('session_id')->count('session_id');
        
        // Base minimum realistic active representation (at least 1 if active)
        return max(1, $count);
    }

    /**
     * Alias for getOnlineCount
     */
    public static function getActiveCount($category)
    {
        return static::getOnlineCount($category);
    }

    /**
     * Clean up stale presences older than 30 minutes
     */
    public static function pruneStale()
    {
        return static::where('last_seen_at', '<', now()->subMinutes(30))->delete();
    }
}

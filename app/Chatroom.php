<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Chatroom extends Model
{
    protected $fillable = [
        'user_id', 'guest_name', 'guest_email', 'guest_contact', 'category', 'title', 'slug', 'description',
        'is_premium', 'access_type', 'security_code', 'creator_whatsapp', 'creator_email', 'access_fee',
        'is_pinned', 'is_locked', 'views_count', 'replies_count', 'last_activity_at', 'expires_at'
    ];

    protected $casts = [
        'is_premium' => 'boolean',
        'is_pinned' => 'boolean',
        'is_locked' => 'boolean',
        'last_activity_at' => 'datetime',
        'expires_at' => 'datetime',
        'access_fee' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($room) {
            if (empty($room->slug)) {
                $room->slug = static::generateUniqueSlug($room->title);
            }
            if (empty($room->last_activity_at)) {
                $room->last_activity_at = now();
            }
            if ($room->is_premium && empty($room->expires_at)) {
                // Default 1-month validity duration for premium rooms
                $room->expires_at = now()->addDays(30);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function accesses()
    {
        return $this->hasMany(ChatroomAccess::class);
    }

    public function joinRequests()
    {
        return $this->hasMany(ChatroomJoinRequest::class)->orderBy('created_at', 'desc');
    }

    public function getAuthorNameAttribute()
    {
        if ($this->user) {
            return $this->user->name;
        }
        return $this->guest_name ?: 'Guest Member';
    }

    public function getAuthorRoleAttribute()
    {
        if ($this->user) {
            if ($this->user->isAdmin()) return 'Admin';
            return ucfirst($this->user->user_type ?: 'Member');
        }
        return 'Guest User';
    }

    public function messages()
    {
        return $this->hasMany(ChatroomMessage::class)->orderBy('created_at', 'asc');
    }

    public function latestMessage()
    {
        return $this->hasOne(ChatroomMessage::class)->latest();
    }

    /**
     * Check whether this premium discussion has exceeded its 1-month validity.
     */
    public function isExpired()
    {
        return $this->is_premium && !empty($this->expires_at) && now()->gt($this->expires_at);
    }

    /**
     * Remaining days before expiration.
     */
    public function daysRemaining()
    {
        if (!$this->expires_at) return null;
        if (now()->gt($this->expires_at)) return 0;
        return max(1, (int) now()->diffInDays($this->expires_at, false) + 1);
    }

    /**
     * Check if the room is unlocked for a given user or session.
     * The creator (researcher/author) and Admins ALWAYS have full access.
     */
    public function isUnlockedBy(?User $user = null, ?string $sessionId = null)
    {
        // Public non-premium room is open to all
        if (!$this->is_premium) {
            return true;
        }

        // Admins always have access
        if ($user && $user->isAdmin()) {
            return true;
        }

        // Creator of the discussion always has full permanent access
        if ($user && $this->user_id && $this->user_id === $user->id) {
            return true;
        }

        // If not security pass protected, fallback
        if ($this->access_type !== 'security_pass' && empty($this->security_code)) {
            return true;
        }

        // Check session unlock
        if ($sessionId && session("chatroom_unlocked_{$this->id}")) {
            return true;
        }

        // Check database access record
        $accessQuery = $this->accesses();
        if ($user) {
            $hasUserAccess = (clone $accessQuery)->where('user_id', $user->id)->exists();
            if ($hasUserAccess) return true;
        }
        if ($sessionId) {
            $hasSessionAccess = (clone $accessQuery)->where('session_id', $sessionId)->exists();
            if ($hasSessionAccess) return true;
        }

        return false;
    }

    /**
     * Determine if a user can post a reply.
     * Note: If room expired, regular members cannot post, but creator or Admin can.
     */
    public function canPostReply(?User $user = null)
    {
        $isCreatorOrAdmin = $user && ($user->isAdmin() || ($this->user_id && $this->user_id === $user->id));

        if ($this->is_locked && !$isCreatorOrAdmin) {
            return false;
        }

        if ($this->isExpired() && !$isCreatorOrAdmin) {
            return false;
        }

        return true;
    }

    /**
     * Clean phone number for WhatsApp link
     */
    public function getCleanWhatsAppPhoneAttribute()
    {
        $phone = $this->creator_whatsapp ?: ($this->user ? $this->user->phone : null);
        if (!$phone) return null;

        $clean = preg_replace('/[^0-9]/', '', $phone);
        // If 10 digits starting with 0 (Ghana standard e.g. 0501234567), change leading 0 to 233
        if (strlen($clean) === 10 && strpos($clean, '0') === 0) {
            $clean = '233' . substr($clean, 1);
        }
        return $clean;
    }

    /**
     * Pre-formatted WhatsApp share link for participants to request code
     */
    public function getWhatsAppRequestUrlAttribute()
    {
        $cleanPhone = $this->clean_whats_app_phone;
        if (!$cleanPhone) return null;

        $requesterName = auth()->check() ? auth()->user()->name : 'A member';
        $text = "Hello, I would like to request the security code to join your premium discussion: \"" . $this->title . "\" on Legals Forum. My name is " . $requesterName . ".";

        return "https://wa.me/{$cleanPhone}?text=" . rawurlencode($text);
    }

    /**
     * Pre-formatted Mailto link to request code
     */
    public function getEmailRequestUrlAttribute()
    {
        $email = $this->creator_email ?: ($this->user ? $this->user->email : null);
        if (!$email) return null;

        $requesterName = auth()->check() ? auth()->user()->name : 'A member';
        $subject = "Request for Security Pass: " . $this->title;
        $body = "Hello,\n\nI would like to request the security code to join your premium discussion room: \"" . $this->title . "\" on Legals Forum.\n\nRequester: " . $requesterName . "\nEmail: " . (auth()->check() ? auth()->user()->email : '') . "\n\nThank you.";

        return "mailto:{$email}?subject=" . rawurlencode($subject) . "&body=" . rawurlencode($body);
    }

    public static function generateUniqueSlug($title)
    {
        $base = Str::slug($title);
        if (empty($base)) {
            $base = 'discussion-' . Str::random(6);
        }
        $slug = $base;
        $count = 1;
        while (static::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$count}";
            $count++;
        }
        return $slug;
    }

    public function getCategoryLabelAttribute()
    {
        return static::categoryLabels()[$this->category] ?? ucfirst($this->category);
    }

    public function getCategoryNameAttribute()
    {
        return $this->category_label;
    }

    public static function categoryLabels()
    {
        return [
            'general'    => 'General Room',
            'student'    => 'Student Room',
            'lawyer'     => 'Lawyer Room',
            'researcher' => 'Researcher Room',
        ];
    }

    public static function categoryIcons()
    {
        return [
            'general'    => 'fa-comments',
            'student'    => 'fa-graduation-cap',
            'lawyer'     => 'fa-scale-balanced',
            'researcher' => 'fa-microscope',
        ];
    }

    public static function categoryColors()
    {
        return [
            'general'    => ['color' => '#60a5fa', 'bg' => 'rgba(59, 130, 246, 0.12)', 'border' => 'rgba(59, 130, 246, 0.3)'],
            'student'    => ['color' => '#34d399', 'bg' => 'rgba(16, 185, 129, 0.12)', 'border' => 'rgba(16, 185, 129, 0.3)'],
            'lawyer'     => ['color' => '#fbbf24', 'bg' => 'rgba(245, 158, 11, 0.12)', 'border' => 'rgba(245, 158, 11, 0.3)'],
            'researcher' => ['color' => '#a78bfa', 'bg' => 'rgba(139, 92, 246, 0.12)', 'border' => 'rgba(139, 92, 246, 0.3)'],
        ];
    }
}

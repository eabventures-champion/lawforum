<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Chatroom extends Model
{
    protected $fillable = [
        'user_id', 'guest_name', 'guest_email', 'guest_contact', 'category', 'title', 'slug', 'description',
        'is_premium', 'is_pinned', 'is_locked', 'views_count',
        'replies_count', 'last_activity_at'
    ];

    protected $casts = [
        'is_premium' => 'boolean',
        'is_pinned' => 'boolean',
        'is_locked' => 'boolean',
        'last_activity_at' => 'datetime',
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
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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

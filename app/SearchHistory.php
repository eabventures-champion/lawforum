<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SearchHistory extends Model
{
    protected $table = 'search_histories';

    protected $fillable = [
        'user_id',
        'session_id',
        'search_text',
        'results_count',
        'category',
        'ip_address',
        'searched_at',
    ];

    protected $dates = ['searched_at'];

    /**
     * Relationship to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: get searches for the current user (authenticated or guest via session/IP)
     */
    public function scopeForCurrentUser($query)
    {
        if (auth()->check()) {
            return $query->where('user_id', auth()->id());
        }

        $sessionId = session()->getId();
        $ip = request()->ip();

        return $query->where(function ($q) use ($sessionId, $ip) {
            if (!empty($sessionId)) {
                $q->where('session_id', $sessionId);
            }
            if (!empty($ip)) {
                $q->orWhere(function ($sub) use ($ip) {
                    $sub->whereNull('user_id')->where('ip_address', $ip);
                });
            }
        });
    }
}

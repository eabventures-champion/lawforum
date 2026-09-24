<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionTeamMember extends Model
{
    protected $table = 'subscription_team_members';

    protected $fillable = [
        'owner_id',
        'member_id',
        'email',
        'invite_token',
        'status',
        'accepted_at',
        'can_manage_billing',
        'billing_request_plan_id',
        'billing_request_note',
        'billing_request_status',
        'billing_requested_at',
    ];

    protected $casts = [
        'accepted_at' => 'datetime',
        'can_manage_billing' => 'boolean',
        'billing_requested_at' => 'datetime',
    ];

    /**
     * Target subscription requested by this collaborator.
     */
    public function requestedPlan()
    {
        return $this->belongsTo(Subscription::class, 'billing_request_plan_id');
    }

    /**
     * Primary subscriber who owns the team plan.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * The registered user who accepted the membership.
     */
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    /**
     * Scope for accepted members.
     */
    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    /**
     * Scope for pending invitations.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}

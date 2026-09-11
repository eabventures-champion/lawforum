<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\DemoSetting;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'country', 'lname', 'check_subscription', 'subscription_id', 'subscription_expiry', 'role_id', 'user_type',
        'researcher_type', 'researcher_type_other', 'is_demo_mode', 'demo_started_at', 'demo_extended', 'demo_used'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_demo_mode' => 'boolean',
        'demo_started_at' => 'datetime',
        'demo_extended' => 'boolean',
        'demo_used' => 'boolean',
    ];

    public function setExpiry(){
        if ($this->subscription_expiry < Carbon::today()) {
            return true;
        }
        return false;
    }

    public function isAdmin()
    {
        return $this->role_id == 1 || $this->email === 'admin@admin.com';
    }

    /**
     * Check if user currently has an active, valid paid subscription.
     */
    public function hasActiveSubscription()
    {
        if ($this->isAdmin()) {
            return true;
        }
        return $this->check_subscription && $this->subscription_expiry && Carbon::parse($this->subscription_expiry)->isFuture();
    }

    /**
     * Check if user has full platform access (Admin, Active Paid Subscription, or Active Demo).
     */
    public function hasFullAccess()
    {
        if ($this->isAdmin()) {
            return true;
        }
        if ($this->hasActiveSubscription()) {
            return true;
        }
        return $this->isDemoActive() || $this->isDemoExtensionActive();
    }

    /**
     * Check if the user's main demo period is still active.
     */
    public function isDemoActive()
    {
        if (!$this->is_demo_mode || !$this->demo_started_at) {
            return false;
        }
        $demoDays = (int) DemoSetting::get('demo_duration_days', 60);
        return $this->demo_started_at->copy()->addDays($demoDays)->isFuture();
    }

    /**
     * Check if the user is in the extension period (main demo expired, extension active).
     */
    public function isDemoExtensionActive()
    {
        if (!$this->is_demo_mode || !$this->demo_started_at || !$this->demo_extended) {
            return false;
        }
        $demoDays = (int) DemoSetting::get('demo_duration_days', 60);
        $extensionDays = (int) DemoSetting::get('demo_extension_days', 15);
        $extensionEnd = $this->demo_started_at->copy()->addDays($demoDays + $extensionDays);
        return $extensionEnd->isFuture() && !$this->isDemoActive();
    }

    /**
     * Check if both the demo and extension periods have expired.
     */
    public function isDemoExpired()
    {
        if (!$this->is_demo_mode || !$this->demo_started_at) {
            return false;
        }
        $demoDays = (int) DemoSetting::get('demo_duration_days', 60);
        $extensionDays = $this->demo_extended ? (int) DemoSetting::get('demo_extension_days', 15) : 0;
        return $this->demo_started_at->copy()->addDays($demoDays + $extensionDays)->isPast();
    }

    /**
     * Get the number of remaining days in the demo (including extension).
     */
    public function demoRemainingDays()
    {
        if (!$this->is_demo_mode || !$this->demo_started_at) {
            return 0;
        }
        $demoDays = (int) DemoSetting::get('demo_duration_days', 60);
        $extensionDays = $this->demo_extended ? (int) DemoSetting::get('demo_extension_days', 15) : 0;
        $endDate = $this->demo_started_at->copy()->addDays($demoDays + $extensionDays);
        return max(0, (int) now()->diffInDays($endDate, false));
    }

    /**
     * Activate demo mode for this user.
     */
    public function startDemo()
    {
        $this->update([
            'is_demo_mode' => true,
            'demo_started_at' => now(),
            'demo_used' => true,
        ]);
    }

    /**
     * Expire demo and downgrade user to guest access.
     */
    public function expireDemoToGuest()
    {
        $this->update([
            'is_demo_mode' => false,
            'user_type' => null,
        ]);
    }

    /**
     * Get demo duration stats: days done, total days, status, and formatted label.
     */
    public function getDemoDurationInfo()
    {
        if ($this->isAdmin()) {
            return null;
        }

        $baseDays = (int) DemoSetting::get('demo_duration_days', 60);
        $extDays = (int) DemoSetting::get('demo_extension_days', 15);
        $totalDays = $baseDays + ($this->demo_extended ? $extDays : 0);

        if (!$this->demo_started_at) {
            return [
                'days_done' => 0,
                'total_days' => $baseDays,
                'remaining' => 0,
                'is_active' => false,
                'is_expired' => false,
                'is_not_started' => true,
                'status' => 'not_started',
                'label' => "0/{$baseDays} days",
                'extended' => false,
            ];
        }

        $endDate = $this->demo_started_at->copy()->addDays($totalDays);
        $remaining = max(0, (int) now()->diffInDays($endDate, false));
        
        $isExpired = ($remaining <= 0) || !$this->is_demo_mode || $this->isDemoExpired();
        $isActive = !$isExpired && $this->is_demo_mode && ($remaining > 0);

        if ($isExpired) {
            $daysDone = $totalDays;
        } else {
            $daysDone = max(0, min($totalDays, $totalDays - $remaining));
        }

        return [
            'days_done' => $daysDone,
            'total_days' => $totalDays,
            'remaining' => $remaining,
            'is_active' => $isActive,
            'is_expired' => $isExpired,
            'is_not_started' => false,
            'status' => $isActive ? ($this->demo_extended ? 'extended' : 'active') : 'expired',
            'label' => "{$daysDone}/{$totalDays} days",
            'extended' => (bool) $this->demo_extended,
        ];
    }
}

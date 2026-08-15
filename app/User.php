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
     * Check if the user's main demo period is still active.
     */
    public function isDemoActive()
    {
        if (!$this->is_demo_mode || !$this->demo_started_at) {
            return false;
        }
        $demoDays = (int) DemoSetting::get('demo_duration_days', 60);
        return $this->demo_started_at->addDays($demoDays)->isFuture();
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
}

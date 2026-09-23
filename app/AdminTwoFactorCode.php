<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AdminTwoFactorCode extends Model
{
    protected $table = 'admin_two_factor_codes';

    protected $fillable = [
        'user_id',
        'code',
        'expires_at',
        'attempts',
        'used',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used'       => 'boolean',
        'attempts'   => 'integer',
    ];

    /**
     * Relationship with User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate a new 6-digit OTP for an administrator.
     */
    public static function generateForUser(User $user, ?Request $request = null): self
    {
        // Mark any existing active codes for this user as used
        self::where('user_id', $user->id)
            ->where('used', false)
            ->update(['used' => true]);

        // Generate 6-digit numeric code
        $code = sprintf('%06d', random_int(100000, 999999));

        return self::create([
            'user_id'    => $user->id,
            'code'       => $code,
            'expires_at' => now()->addMinutes(10),
            'attempts'   => 0,
            'used'       => false,
            'ip_address' => $request ? $request->ip() : null,
            'user_agent' => $request ? substr($request->userAgent() ?? '', 0, 500) : null,
        ]);
    }

    /**
     * Check if this code is still valid.
     */
    public function isUsable(): bool
    {
        return !$this->used && now()->lt($this->expires_at) && $this->attempts < 5;
    }

    /**
     * Validate an entered code string.
     */
    public function matches(string $inputCode): bool
    {
        return hash_equals(trim((string)$this->code), trim($inputCode));
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    protected $table = 'payment_settings';

    protected $fillable = [
        'key',
        'value',
    ];

    protected static $cachedSettings = [];

    /**
     * Get a setting value by key.
     */
    public static function get($key, $default = null)
    {
        if (isset(static::$cachedSettings[$key])) {
            return static::$cachedSettings[$key];
        }
        $setting = self::where('key', $key)->first();
        $val = ($setting && !is_null($setting->value)) ? $setting->value : $default;
        static::$cachedSettings[$key] = $val;
        return $val;
    }

    /**
     * Set a setting value by key.
     */
    public static function set($key, $value)
    {
        static::$cachedSettings[$key] = $value;
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    /**
     * Get the active mode ('test' or 'live').
     */
    public static function getMode(): string
    {
        $mode = self::get('flutterwave_mode');
        if (!$mode) {
            $mode = env('FLUTTERWAVE_MODE');
        }
        return ($mode === 'live') ? 'live' : 'test';
    }

    /**
     * Check if currently in live production mode.
     */
    public static function isLiveMode(): bool
    {
        return self::getMode() === 'live';
    }

    /**
     * Get the active Public Key based on mode.
     */
    public static function getPublicKey(): string
    {
        $mode = self::getMode();
        if ($mode === 'live') {
            return (string) (self::get('flutterwave_live_public_key') ?: env('FLUTTERWAVE_LIVE_PUBLIC_KEY', env('FLUTTERWAVE_PUBLIC_KEY', '')));
        }
        return (string) (self::get('flutterwave_test_public_key') ?: env('FLUTTERWAVE_TEST_PUBLIC_KEY', env('FLUTTERWAVE_PUBLIC_KEY', '')));
    }

    /**
     * Get the active Secret Key based on mode.
     */
    public static function getSecretKey(): string
    {
        $mode = self::getMode();
        if ($mode === 'live') {
            return (string) (self::get('flutterwave_live_secret_key') ?: env('FLUTTERWAVE_LIVE_SECRET_KEY', env('FLUTTERWAVE_SECRET_KEY', '')));
        }
        return (string) (self::get('flutterwave_test_secret_key') ?: env('FLUTTERWAVE_TEST_SECRET_KEY', env('FLUTTERWAVE_SECRET_KEY', '')));
    }

    /**
     * Get the active Encryption Key based on mode.
     */
    public static function getEncryptionKey(): string
    {
        $mode = self::getMode();
        if ($mode === 'live') {
            return (string) (self::get('flutterwave_live_encryption_key') ?: env('FLUTTERWAVE_LIVE_ENCRYPTION_KEY', env('FLUTTERWAVE_ENCRYPTION_KEY', '')));
        }
        return (string) (self::get('flutterwave_test_encryption_key') ?: env('FLUTTERWAVE_TEST_ENCRYPTION_KEY', env('FLUTTERWAVE_ENCRYPTION_KEY', '')));
    }

    /**
     * Synchronize all keys and the active mode directly into the .env file.
     */
    public static function syncToEnv(): bool
    {
        $mode = self::getMode();
        $testPub = (string) self::get('flutterwave_test_public_key', '');
        $testSec = (string) self::get('flutterwave_test_secret_key', '');
        $testEnc = (string) self::get('flutterwave_test_encryption_key', '');

        $livePub = (string) self::get('flutterwave_live_public_key', '');
        $liveSec = (string) self::get('flutterwave_live_secret_key', '');
        $liveEnc = (string) self::get('flutterwave_live_encryption_key', '');

        $activePub = ($mode === 'live') ? $livePub : $testPub;
        $activeSec = ($mode === 'live') ? $liveSec : $testSec;
        $activeEnc = ($mode === 'live') ? $liveEnc : $testEnc;

        $envUpdates = [
            'FLUTTERWAVE_MODE'            => $mode,
            'FLUTTERWAVE_TEST_PUBLIC_KEY' => $testPub,
            'FLUTTERWAVE_TEST_SECRET_KEY' => $testSec,
            'FLUTTERWAVE_TEST_ENCRYPTION_KEY' => $testEnc,
            'FLUTTERWAVE_LIVE_PUBLIC_KEY' => $livePub,
            'FLUTTERWAVE_LIVE_SECRET_KEY' => $liveSec,
            'FLUTTERWAVE_LIVE_ENCRYPTION_KEY' => $liveEnc,
            'FLUTTERWAVE_PUBLIC_KEY'      => $activePub,
            'FLUTTERWAVE_SECRET_KEY'      => $activeSec,
            'FLUTTERWAVE_ENCRYPTION_KEY'  => $activeEnc,
        ];

        return self::updateEnvFile($envUpdates);
    }

    /**
     * Helper to write key-value pairs into .env file safely.
     */
    public static function updateEnvFile(array $values): bool
    {
        $envPath = base_path('.env');
        if (!file_exists($envPath)) {
            return false;
        }

        $content = file_get_contents($envPath);
        $original = $content;

        foreach ($values as $key => $val) {
            $val = trim((string)$val);
            if (strpos($val, ' ') !== false && !str_starts_with($val, '"')) {
                $val = '"' . addcslashes($val, '"') . '"';
            }

            $pattern = "/^{$key}=[^\r\n]*/m";
            if (preg_match($pattern, $content)) {
                $content = preg_replace($pattern, "{$key}={$val}", $content);
            } else {
                $content = rtrim($content) . "\n{$key}={$val}\n";
            }
        }

        if ($content === $original) {
            return true;
        }

        file_put_contents($envPath, $content);
        return true;
    }
}

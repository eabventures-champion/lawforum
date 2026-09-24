<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\PaymentSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class PaymentSettingController extends Controller
{
    /**
     * Show the Flutterwave payment gateway settings.
     */
    public function index()
    {
        $mode = PaymentSetting::getMode();
        $test_public_key = PaymentSetting::get('flutterwave_test_public_key', env('FLUTTERWAVE_TEST_PUBLIC_KEY', env('FLUTTERWAVE_PUBLIC_KEY', '')));
        $test_secret_key = PaymentSetting::get('flutterwave_test_secret_key', env('FLUTTERWAVE_TEST_SECRET_KEY', env('FLUTTERWAVE_SECRET_KEY', '')));
        $test_encryption_key = PaymentSetting::get('flutterwave_test_encryption_key', env('FLUTTERWAVE_TEST_ENCRYPTION_KEY', env('FLUTTERWAVE_ENCRYPTION_KEY', '')));

        $live_public_key = PaymentSetting::get('flutterwave_live_public_key', env('FLUTTERWAVE_LIVE_PUBLIC_KEY', ''));
        $live_secret_key = PaymentSetting::get('flutterwave_live_secret_key', env('FLUTTERWAVE_LIVE_SECRET_KEY', ''));
        $live_encryption_key = PaymentSetting::get('flutterwave_live_encryption_key', env('FLUTTERWAVE_LIVE_ENCRYPTION_KEY', ''));

        $active_public_key = PaymentSetting::getPublicKey();
        $is_live = PaymentSetting::isLiveMode();

        // Check if .env is currently synced
        $envPublicKey = env('FLUTTERWAVE_PUBLIC_KEY');
        $is_env_synced = ($envPublicKey === $active_public_key);

        return view('admin.payment_settings.index', compact(
            'mode',
            'test_public_key',
            'test_secret_key',
            'test_encryption_key',
            'live_public_key',
            'live_secret_key',
            'live_encryption_key',
            'active_public_key',
            'is_live',
            'is_env_synced'
        ));
    }

    /**
     * Update all Flutterwave keys and active mode, syncing directly to .env.
     */
    public function update(Request $request)
    {
        $request->validate([
            'flutterwave_mode'                => 'required|in:test,live',
            'flutterwave_test_public_key'     => 'nullable|string|max:255',
            'flutterwave_test_secret_key'     => 'nullable|string|max:255',
            'flutterwave_test_encryption_key' => 'nullable|string|max:255',
            'flutterwave_live_public_key'     => 'nullable|string|max:255',
            'flutterwave_live_secret_key'     => 'nullable|string|max:255',
            'flutterwave_live_encryption_key' => 'nullable|string|max:255',
        ]);

        $mode = $request->input('flutterwave_mode');
        PaymentSetting::set('flutterwave_mode', $mode);
        PaymentSetting::set('flutterwave_test_public_key', trim($request->input('flutterwave_test_public_key', '')));
        PaymentSetting::set('flutterwave_test_secret_key', trim($request->input('flutterwave_test_secret_key', '')));
        PaymentSetting::set('flutterwave_test_encryption_key', trim($request->input('flutterwave_test_encryption_key', '')));
        PaymentSetting::set('flutterwave_live_public_key', trim($request->input('flutterwave_live_public_key', '')));
        PaymentSetting::set('flutterwave_live_secret_key', trim($request->input('flutterwave_live_secret_key', '')));
        PaymentSetting::set('flutterwave_live_encryption_key', trim($request->input('flutterwave_live_encryption_key', '')));

        // Write directly into .env
        PaymentSetting::syncToEnv();

        $modeLabel = ($mode === 'live') ? 'LIVE (Production)' : 'TEST (Sandbox)';

        return redirect()->route('admin.payment-settings.index')
            ->with('success', "Payment gateway settings updated and synced to .env successfully! Currently active mode: {$modeLabel}.");
    }

    /**
     * Quick toggle to alternate between Test and Live mode.
     */
    public function toggleMode(Request $request)
    {
        if ($request->isMethod('get')) {
            return redirect()->route('admin.payment-settings.index');
        }

        $currentMode = PaymentSetting::getMode();
        $targetMode = ($currentMode === 'live') ? 'test' : 'live';

        // Check if switching to live and live keys are empty
        if ($targetMode === 'live') {
            $livePub = PaymentSetting::get('flutterwave_live_public_key');
            if (empty($livePub)) {
                $msg = 'Cannot switch to Live mode yet: Please configure your Live Public Key and Secret Key first.';
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => $msg], 422);
                }
                return back()->with('error', $msg);
            }
        }

        PaymentSetting::set('flutterwave_mode', $targetMode);
        PaymentSetting::syncToEnv();

        $label = ($targetMode === 'live') ? 'LIVE (Production)' : 'TEST (Sandbox)';
        $msg = "Flutterwave environment switched to {$label} and synced to .env successfully!";

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $msg,
                'mode' => $targetMode,
                'active_public_key' => PaymentSetting::getPublicKey(),
            ]);
        }

        return back()->with('success', $msg);
    }
}

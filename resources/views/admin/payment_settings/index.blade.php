@extends('layouts.admin')

@section('title', 'Payment Gateway (Flutterwave) Settings')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px; margin-bottom: 24px;">
    <div>
        <h1 class="page-title" style="display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-credit-card" style="color: var(--primary-color); font-size: 24px;"></i>
            Payment Gateway (Flutterwave) Settings
        </h1>
        <p class="page-subtitle">Configure Live and Test Flutterwave credentials and alternate between environments. Changes update the database and sync directly to your <code>.env</code> file.</p>
    </div>
    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
        <!-- Quick Mode Indicator Pill -->
        <span style="display: inline-flex; align-items: center; gap: 7px; padding: 7px 14px; border-radius: 100px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; {{ $mode === 'live' ? 'background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.35);' : 'background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.35);' }}">
            <span style="width: 8px; height: 8px; border-radius: 50%; background: {{ $mode === 'live' ? '#10b981' : '#f59e0b' }}; box-shadow: 0 0 10px {{ $mode === 'live' ? '#10b981' : '#f59e0b' }};"></span>
            {{ $mode === 'live' ? 'Live Mode Active' : 'Test Mode Active' }}
        </span>

        <!-- Quick 1-Click Alternate Mode Button -->
        <form action="{{ route('admin.payment-settings.toggle-mode') }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to alternate to {{ $mode === 'live' ? 'Test (Sandbox)' : 'Live (Production)' }} mode? This will instantly sync your .env file.');">
            @csrf
            <button type="submit" class="btn" style="display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; transition: all 0.2s ease; {{ $mode === 'live' ? 'background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.4); color: #fbbf24;' : 'background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.4); color: #34d399;' }}">
                <i class="fa-solid fa-repeat"></i>
                Switch to {{ $mode === 'live' ? 'Test Mode' : 'Live Mode' }}
            </button>
        </form>

        <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-secondary" style="display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; border-radius: 10px; background: rgba(255, 255, 255, 0.05); border: 1px solid var(--border-color); color: var(--text-primary); text-decoration: none; font-size: 13px; font-weight: 600;">
            <i class="fa-solid fa-list-check"></i> Manage Plans
        </a>
    </div>
</div>

<!-- Active Gateway Status Overview Banner -->
<div class="card-table" style="padding: 20px 24px; margin-bottom: 24px; border-radius: 16px; background: linear-gradient(135deg, rgba(13, 20, 38, 0.7), rgba(8, 12, 28, 0.85)); border: 1px solid {{ $mode === 'live' ? 'rgba(16, 185, 129, 0.3)' : 'rgba(245, 158, 11, 0.3)' }};">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 48px; height: 48px; border-radius: 14px; background: {{ $mode === 'live' ? 'rgba(16, 185, 129, 0.15)' : 'rgba(245, 158, 11, 0.15)' }}; border: 1px solid {{ $mode === 'live' ? 'rgba(16, 185, 129, 0.3)' : 'rgba(245, 158, 11, 0.3)' }}; display: flex; align-items: center; justify-content: center; font-size: 20px; color: {{ $mode === 'live' ? '#34d399' : '#fbbf24' }}; flex-shrink: 0;">
                <i class="fa-solid {{ $mode === 'live' ? 'fa-bolt' : 'fa-flask' }}"></i>
            </div>
            <div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                    <span style="font-size: 15px; font-weight: 700; color: #fff;">
                        Active Environment: {{ $mode === 'live' ? 'Live / Production Mode' : 'Test / Sandbox Mode' }}
                    </span>
                    <span style="font-size: 11px; padding: 2px 8px; border-radius: 6px; font-weight: 700; background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3);">
                        <i class="fa-solid fa-file-code" style="font-size: 10px; margin-right: 4px;"></i> .env Synced
                    </span>
                </div>
                <div style="font-size: 13px; color: var(--text-secondary); display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                    <span>Active Public Key in Platform Checkout:</span>
                    <code style="background: rgba(0, 0, 0, 0.4); color: {{ $mode === 'live' ? '#34d399' : '#fbbf24' }}; padding: 3px 8px; border-radius: 6px; font-size: 12px; font-family: monospace;">
                        {{ $active_public_key ?: 'No public key configured' }}
                    </code>
                    @if($active_public_key)
                    <button type="button" onclick="navigator.clipboard.writeText('{{ $active_public_key }}'); this.innerText='Copied!'; setTimeout(() => this.innerText='Copy', 1500);" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.15); color: #cbd5e1; font-size: 11px; padding: 2px 8px; border-radius: 5px; cursor: pointer;">
                        Copy
                    </button>
                    @endif
                </div>
            </div>
        </div>

        <div style="display: flex; align-items: center; gap: 8px;">
            <span style="font-size: 12px; color: var(--text-secondary);">
                {{ $mode === 'live' ? 'Real payments will be charged' : 'Simulated dummy test payments only' }}
            </span>
        </div>
    </div>
</div>

<form action="{{ route('admin.payment-settings.update') }}" method="POST" id="paymentSettingsForm">
    @csrf

    {{-- SECTION 1: ENVIRONMENT MODE SELECTOR --}}
    <div class="card-table" style="padding: 28px; margin-bottom: 28px; border-radius: 16px;">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 14px;">
            <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(59, 130, 246, 0.15); display: flex; align-items: center; justify-content: center; color: #3b82f6;">
                <i class="fa-solid fa-toggle-on" style="font-size: 16px;"></i>
            </div>
            <div>
                <h3 style="color: #fff; font-size: 16px; font-weight: 700; margin: 0;">Select Active Environment</h3>
                <p style="color: var(--text-secondary); font-size: 12.5px; margin: 2px 0 0;">Alternate between Test and Live credentials. The selected mode's keys will be written to <code>FLUTTERWAVE_PUBLIC_KEY</code>, <code>FLUTTERWAVE_SECRET_KEY</code>, and <code>FLUTTERWAVE_ENCRYPTION_KEY</code> in your <code>.env</code>.</p>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px; margin-bottom: 12px;">
            <!-- Option 1: Test Mode Card -->
            <label class="mode-card {{ $mode === 'test' ? 'selected' : '' }}" style="display: block; position: relative; padding: 22px 24px; border-radius: 14px; background: rgba(255, 255, 255, 0.02); border: 2px solid {{ $mode === 'test' ? '#f59e0b' : 'rgba(255, 255, 255, 0.08)' }}; cursor: pointer; transition: all 0.25s ease;" id="modeCardTest">
                <input type="radio" name="flutterwave_mode" value="test" {{ $mode === 'test' ? 'checked' : '' }} style="position: absolute; opacity: 0; pointer-events: none;" onchange="updateModeSelection('test')">
                <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 12px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(245, 158, 11, 0.15); color: #fbbf24; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                            <i class="fa-solid fa-flask"></i>
                        </div>
                        <div>
                            <div style="font-size: 16px; font-weight: 700; color: #fff;">Test Mode (Sandbox)</div>
                            <span style="font-size: 11.5px; color: #fbbf24; font-weight: 600;">Safe Testing Environment</span>
                        </div>
                    </div>
                    <span class="mode-radio-dot" style="width: 20px; height: 20px; border-radius: 50%; border: 2px solid {{ $mode === 'test' ? '#f59e0b' : '#64748b' }}; display: flex; align-items: center; justify-content: center;">
                        <span style="width: 10px; height: 10px; border-radius: 50%; background: #f59e0b; display: {{ $mode === 'test' ? 'block' : 'none' }};" id="radioDotTest"></span>
                    </span>
                </div>
                <p style="font-size: 13px; color: var(--text-secondary); line-height: 1.5; margin: 0;">
                    Uses Flutterwave Test API credentials. Transactions use test cards and mobile money prompts. No actual money will be debited or deposited.
                </p>
            </label>

            <!-- Option 2: Live Mode Card -->
            <label class="mode-card {{ $mode === 'live' ? 'selected' : '' }}" style="display: block; position: relative; padding: 22px 24px; border-radius: 14px; background: rgba(255, 255, 255, 0.02); border: 2px solid {{ $mode === 'live' ? '#10b981' : 'rgba(255, 255, 255, 0.08)' }}; cursor: pointer; transition: all 0.25s ease;" id="modeCardLive">
                <input type="radio" name="flutterwave_mode" value="live" {{ $mode === 'live' ? 'checked' : '' }} style="position: absolute; opacity: 0; pointer-events: none;" onchange="updateModeSelection('live')">
                <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 12px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(16, 185, 129, 0.15); color: #34d399; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                            <i class="fa-solid fa-bolt"></i>
                        </div>
                        <div>
                            <div style="font-size: 16px; font-weight: 700; color: #fff;">Live Mode (Production)</div>
                            <span style="font-size: 11.5px; color: #34d399; font-weight: 600;">Real Payment Gateway</span>
                        </div>
                    </div>
                    <span class="mode-radio-dot" style="width: 20px; height: 20px; border-radius: 50%; border: 2px solid {{ $mode === 'live' ? '#10b981' : '#64748b' }}; display: flex; align-items: center; justify-content: center;">
                        <span style="width: 10px; height: 10px; border-radius: 50%; background: #10b981; display: {{ $mode === 'live' ? 'block' : 'none' }};" id="radioDotLive"></span>
                    </span>
                </div>
                <p style="font-size: 13px; color: var(--text-secondary); line-height: 1.5; margin: 0;">
                    Uses Flutterwave Live API credentials. Processes real customer payments for subscriptions via Bank Card, Mobile Money (MTN, Vodafone, AirtelTigo), and USSD.
                </p>
            </label>
        </div>
    </div>

    {{-- SECTION 2: TEST CREDENTIALS (SANDBOX) --}}
    <div class="card-table" style="padding: 28px; margin-bottom: 28px; border-radius: 16px; border-left: 4px solid #f59e0b;">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 14px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(245, 158, 11, 0.15); display: flex; align-items: center; justify-content: center; color: #fbbf24;">
                    <i class="fa-solid fa-flask" style="font-size: 16px;"></i>
                </div>
                <div>
                    <h3 style="color: #fff; font-size: 16px; font-weight: 700; margin: 0;">Test Credentials (Sandbox Keys)</h3>
                    <p style="color: var(--text-secondary); font-size: 12.5px; margin: 2px 0 0;">Obtained from your Flutterwave Dashboard under <strong>Settings &rarr; API Keys</strong> while in Test Mode.</p>
                </div>
            </div>
            <span style="font-size: 11px; padding: 4px 10px; border-radius: 6px; background: rgba(245, 158, 11, 0.12); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3); font-weight: 700;">
                Prefix: FLWPUBK_TEST / FLWSECK_TEST
            </span>
        </div>

        <div style="display: flex; flex-direction: column; gap: 18px;">
            <!-- Test Public Key -->
            <div>
                <label style="display: block; font-size: 13.5px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                    <i class="fa-solid fa-key" style="color: #f59e0b; margin-right: 6px;"></i>
                    Test Public Key (FLUTTERWAVE_TEST_PUBLIC_KEY)
                </label>
                <div style="position: relative;">
                    <input type="text" name="flutterwave_test_public_key" value="{{ old('flutterwave_test_public_key', $test_public_key) }}" placeholder="FLWPUBK_TEST-xxxxxxxxxxxxxxxxxxxx-X" style="width: 100%; padding: 12px 16px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 10px; color: var(--text-primary); font-size: 13.5px; font-family: monospace; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#f59e0b'" onblur="this.style.borderColor='var(--border-color)'">
                </div>
            </div>

            <!-- Test Secret Key -->
            <div>
                <label style="display: block; font-size: 13.5px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                    <i class="fa-solid fa-lock" style="color: #f59e0b; margin-right: 6px;"></i>
                    Test Secret Key (FLUTTERWAVE_TEST_SECRET_KEY)
                </label>
                <div style="position: relative;">
                    <input type="password" id="field_test_secret" name="flutterwave_test_secret_key" value="{{ old('flutterwave_test_secret_key', $test_secret_key) }}" placeholder="FLWSECK_TEST-xxxxxxxxxxxxxxxxxxxx-X" style="width: 100%; padding: 12px 48px 12px 16px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 10px; color: var(--text-primary); font-size: 13.5px; font-family: monospace; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#f59e0b'" onblur="this.style.borderColor='var(--border-color)'">
                    <button type="button" onclick="togglePasswordVisibility('field_test_secret', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #94a3b8; cursor: pointer; padding: 6px;">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>

            <!-- Test Encryption Key -->
            <div>
                <label style="display: block; font-size: 13.5px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                    <i class="fa-solid fa-shield-halved" style="color: #f59e0b; margin-right: 6px;"></i>
                    Test Encryption Key (FLUTTERWAVE_TEST_ENCRYPTION_KEY)
                </label>
                <div style="position: relative;">
                    <input type="password" id="field_test_encryption" name="flutterwave_test_encryption_key" value="{{ old('flutterwave_test_encryption_key', $test_encryption_key) }}" placeholder="FLWSECK_TESTxxxxxxxxxxxx" style="width: 100%; padding: 12px 48px 12px 16px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 10px; color: var(--text-primary); font-size: 13.5px; font-family: monospace; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#f59e0b'" onblur="this.style.borderColor='var(--border-color)'">
                    <button type="button" onclick="togglePasswordVisibility('field_test_encryption', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #94a3b8; cursor: pointer; padding: 6px;">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- SECTION 3: LIVE CREDENTIALS (PRODUCTION) --}}
    <div class="card-table" style="padding: 28px; margin-bottom: 28px; border-radius: 16px; border-left: 4px solid #10b981;">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 14px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(16, 185, 129, 0.15); display: flex; align-items: center; justify-content: center; color: #34d399;">
                    <i class="fa-solid fa-bolt" style="font-size: 16px;"></i>
                </div>
                <div>
                    <h3 style="color: #fff; font-size: 16px; font-weight: 700; margin: 0;">Live Credentials (Production Keys)</h3>
                    <p style="color: var(--text-secondary); font-size: 12.5px; margin: 2px 0 0;">Obtained from your live verified Flutterwave merchant account under <strong>Settings &rarr; API Keys</strong>.</p>
                </div>
            </div>
            <span style="font-size: 11px; padding: 4px 10px; border-radius: 6px; background: rgba(16, 185, 129, 0.12); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); font-weight: 700;">
                Prefix: FLWPUBK / FLWSECK
            </span>
        </div>

        <div style="display: flex; flex-direction: column; gap: 18px;">
            <!-- Live Public Key -->
            <div>
                <label style="display: block; font-size: 13.5px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                    <i class="fa-solid fa-key" style="color: #10b981; margin-right: 6px;"></i>
                    Live Public Key (FLUTTERWAVE_LIVE_PUBLIC_KEY)
                </label>
                <div style="position: relative;">
                    <input type="text" name="flutterwave_live_public_key" value="{{ old('flutterwave_live_public_key', $live_public_key) }}" placeholder="FLWPUBK-xxxxxxxxxxxxxxxxxxxxxxxx-X" style="width: 100%; padding: 12px 16px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 10px; color: var(--text-primary); font-size: 13.5px; font-family: monospace; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#10b981'" onblur="this.style.borderColor='var(--border-color)'">
                </div>
                <small style="display: block; color: var(--text-secondary); margin-top: 6px;">
                    Live public key exposed to the user browser during subscription payment modal checkout.
                </small>
            </div>

            <!-- Live Secret Key -->
            <div>
                <label style="display: block; font-size: 13.5px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                    <i class="fa-solid fa-lock" style="color: #10b981; margin-right: 6px;"></i>
                    Live Secret Key (FLUTTERWAVE_LIVE_SECRET_KEY)
                </label>
                <div style="position: relative;">
                    <input type="password" id="field_live_secret" name="flutterwave_live_secret_key" value="{{ old('flutterwave_live_secret_key', $live_secret_key) }}" placeholder="FLWSECK-xxxxxxxxxxxxxxxxxxxxxxxx-X" style="width: 100%; padding: 12px 48px 12px 16px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 10px; color: var(--text-primary); font-size: 13.5px; font-family: monospace; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#10b981'" onblur="this.style.borderColor='var(--border-color)'">
                    <button type="button" onclick="togglePasswordVisibility('field_live_secret', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #94a3b8; cursor: pointer; padding: 6px;">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
                <small style="display: block; color: var(--text-secondary); margin-top: 6px;">
                    Secret key used by the backend server to verify payment callbacks and transactions.
                </small>
            </div>

            <!-- Live Encryption Key -->
            <div>
                <label style="display: block; font-size: 13.5px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                    <i class="fa-solid fa-shield-halved" style="color: #10b981; margin-right: 6px;"></i>
                    Live Encryption Key (FLUTTERWAVE_LIVE_ENCRYPTION_KEY)
                </label>
                <div style="position: relative;">
                    <input type="password" id="field_live_encryption" name="flutterwave_live_encryption_key" value="{{ old('flutterwave_live_encryption_key', $live_encryption_key) }}" placeholder="FLWSECKxxxxxxxxxxxx" style="width: 100%; padding: 12px 48px 12px 16px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 10px; color: var(--text-primary); font-size: 13.5px; font-family: monospace; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#10b981'" onblur="this.style.borderColor='var(--border-color)'">
                    <button type="button" onclick="togglePasswordVisibility('field_live_encryption', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #94a3b8; cursor: pointer; padding: 6px;">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Webhook URL & Integration Information -->
    <div class="card-table" style="padding: 24px 28px; margin-bottom: 28px; border-radius: 16px; background: rgba(59, 130, 246, 0.04); border: 1px solid rgba(59, 130, 246, 0.18);">
        <div style="display: flex; gap: 14px; align-items: flex-start;">
            <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(59, 130, 246, 0.15); color: #3b82f6; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0;">
                <i class="fa-solid fa-circle-nodes"></i>
            </div>
            <div style="flex: 1;">
                <h4 style="color: #fff; font-size: 14.5px; font-weight: 700; margin: 0 0 6px;">How Key Alternation Works:</h4>
                <ul style="color: var(--text-secondary); font-size: 13px; line-height: 1.7; margin: 0; padding-left: 20px;">
                    <li>Both <strong>Test</strong> and <strong>Live</strong> keys are permanently saved in the database, so switching modes never wipes your existing keys.</li>
                    <li>When you alternate the environment, the active key is immediately injected into <code>FLUTTERWAVE_PUBLIC_KEY</code>, <code>FLUTTERWAVE_SECRET_KEY</code>, and <code>FLUTTERWAVE_ENCRYPTION_KEY</code> inside <code>.env</code>.</li>
                    <li>Subscription checkout on the platform will automatically switch between sandbox test charges and real live billing.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Save Button Floating Action Bar -->
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; padding: 18px 24px; background: rgba(8, 12, 28, 0.95); border: 1px solid var(--border-color); border-radius: 16px; position: sticky; bottom: 20px; z-index: 50; backdrop-filter: blur(12px);">
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-circle-check" style="color: #10b981; font-size: 15px;"></i>
            <span style="font-size: 13px; color: var(--text-secondary);">Saving will automatically update the database and write the active keys into <code>.env</code>.</span>
        </div>
        <button type="submit" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 28px; border-radius: 10px; background: var(--primary-color); color: #fff; font-size: 14px; font-weight: 700; border: none; cursor: pointer; box-shadow: 0 4px 14px rgba(59, 130, 246, 0.35); transition: all 0.2s ease;">
            <i class="fa-solid fa-floppy-disk"></i>
            <span>Save &amp; Sync to .env</span>
        </button>
    </div>
</form>

<script>
    function updateModeSelection(mode) {
        const cardTest = document.getElementById('modeCardTest');
        const cardLive = document.getElementById('modeCardLive');
        const dotTest = document.getElementById('radioDotTest');
        const dotLive = document.getElementById('radioDotLive');

        if (mode === 'test') {
            cardTest.style.borderColor = '#f59e0b';
            cardLive.style.borderColor = 'rgba(255, 255, 255, 0.08)';
            dotTest.style.display = 'block';
            dotLive.style.display = 'none';
        } else {
            cardLive.style.borderColor = '#10b981';
            cardTest.style.borderColor = 'rgba(255, 255, 255, 0.08)';
            dotLive.style.display = 'block';
            dotTest.style.display = 'none';
        }
    }

    function togglePasswordVisibility(fieldId, btn) {
        const input = document.getElementById(fieldId);
        if (!input) return;
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection

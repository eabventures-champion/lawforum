@extends('layouts.admin')

@section('title', 'Guided Tour Content Management')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard Guided Tour Content</h1>
        <p class="page-subtitle">Fully customize and manage the welcome onboarding prompt and every walkthrough step displayed to users on the dashboard.</p>
    </div>
    <div style="display: flex; gap: 10px;">
        <button type="button" class="btn btn-secondary btn-action" onclick="document.getElementById('addStepModal').style.display='flex'">
            <i class="fa-solid fa-plus"></i> Add New Step
        </button>
        <form action="{{ route('admin.onboarding-tour.reset_defaults') }}" method="POST" onsubmit="return confirm('Are you sure you want to reset all tour steps to system defaults?')">
            @csrf
            <button type="submit" class="btn btn-action" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); padding: 8px 14px; border-radius: 8px; font-weight: 600; cursor: pointer;">
                <i class="fa-solid fa-rotate-left"></i> Reset Defaults
            </button>
        </form>
    </div>
</div>

@if(session('success'))
    <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #34d399; padding: 12px 18px; border-radius: 10px; margin-bottom: 24px; font-size: 13.5px; display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-circle-check"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

<!-- Section 1: Welcome Prompt Settings -->
<div class="card" style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-color); border-radius: 16px; padding: 24px; margin-bottom: 28px;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 12px;">
        <div>
            <h2 style="font-size: 16px; font-weight: 700; color: #fff; margin-bottom: 2px;">
                <i class="fa-solid fa-hand-wave mr-1" style="color: #f59e0b;"></i> First-Time Welcome Prompt Settings
            </h2>
            <p style="font-size: 12.5px; color: var(--text-secondary); margin: 0;">Configure the greeting dialog presented to newly registered or first-time users.</p>
        </div>
    </div>

    <form action="{{ route('admin.onboarding-tour.settings') }}" method="POST">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: #cbd5e1; margin-bottom: 6px;">Welcome Modal Heading *</label>
                <input type="text" name="welcome_title" class="form-control" value="{{ old('welcome_title', $settings->welcome_title) }}" required style="width: 100%; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--border-color); color: #fff; padding: 10px 14px; border-radius: 10px;">
            </div>
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: #cbd5e1; margin-bottom: 6px;">Primary Button Label *</label>
                <input type="text" name="welcome_btn_primary" class="form-control" value="{{ old('welcome_btn_primary', $settings->welcome_btn_primary) }}" required style="width: 100%; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--border-color); color: #fff; padding: 10px 14px; border-radius: 10px;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 16px; margin-bottom: 18px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: #cbd5e1; margin-bottom: 6px;">
                    Welcome Message Body (Use <code>:name</code> for user first name) *
                </label>
                <textarea name="welcome_description" rows="2" class="form-control" required style="width: 100%; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--border-color); color: #fff; padding: 10px 14px; border-radius: 10px; font-family: inherit;">{{ old('welcome_description', $settings->welcome_description) }}</textarea>
            </div>
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: #cbd5e1; margin-bottom: 6px;">Secondary Button Label *</label>
                <input type="text" name="welcome_btn_secondary" class="form-control" value="{{ old('welcome_btn_secondary', $settings->welcome_btn_secondary) }}" required style="width: 100%; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--border-color); color: #fff; padding: 10px 14px; border-radius: 10px;">
            </div>
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between;">
            <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer; color: #cbd5e1; font-size: 13px; font-weight: 600;">
                <input type="checkbox" name="auto_prompt_new_users" value="1" {{ $settings->auto_prompt_new_users ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #3b82f6;">
                <span>Automatically prompt new users upon first login</span>
            </label>
            <button type="submit" class="btn btn-primary btn-action" style="padding: 8px 18px;">
                <i class="fa-solid fa-floppy-disk mr-1"></i> Save Welcome Settings
            </button>
        </div>
    </form>
</div>

<!-- Section 2: Walkthrough Tour Steps List -->
<div style="margin-bottom: 16px;">
    <h2 style="font-size: 18px; font-weight: 800; color: #fff; margin-bottom: 4px;">
        <i class="fa-solid fa-list-check mr-1" style="color: #60a5fa;"></i> Walkthrough Tour Steps ({{ $steps->count() }})
    </h2>
    <p style="font-size: 13px; color: var(--text-secondary); margin: 0;">Edit text content, FontAwesome icons, and highlight tips for each step in real time.</p>
</div>

<div style="display: flex; flex-direction: column; gap: 18px;">
    @foreach($steps as $step)
        <div class="card" style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-color); border-radius: 16px; padding: 22px;">
            <form action="{{ route('admin.onboarding-tour.update_step', $step->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 10px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="background: rgba(59, 130, 246, 0.2); color: #93c5fd; border: 1px solid rgba(59, 130, 246, 0.35); font-size: 12px; font-weight: 800; padding: 3px 10px; border-radius: 20px;">
                            Step #{{ $step->step_number }}
                        </span>
                        <span style="font-size: 14px; font-weight: 700; color: #fff;">{{ $step->title }}</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <label style="display: inline-flex; align-items: center; gap: 6px; cursor: pointer; color: #94a3b8; font-size: 12.5px;">
                            <input type="checkbox" name="is_active" value="1" {{ $step->is_active ? 'checked' : '' }} style="accent-color: #10b981;">
                            <span>Active</span>
                        </label>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 80px 1fr 140px 140px; gap: 14px; margin-bottom: 14px;">
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 700; color: #94a3b8; margin-bottom: 4px;">Order #</label>
                        <input type="number" name="step_number" value="{{ $step->step_number }}" class="form-control" style="width: 100%; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--border-color); color: #fff; padding: 8px 10px; border-radius: 8px; text-align: center;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 700; color: #94a3b8; margin-bottom: 4px;">Step Title *</label>
                        <input type="text" name="title" value="{{ $step->title }}" required class="form-control" style="width: 100%; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--border-color); color: #fff; padding: 8px 12px; border-radius: 8px;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 700; color: #94a3b8; margin-bottom: 4px;">Icon Class *</label>
                        <input type="text" name="icon" value="{{ $step->icon }}" required class="form-control" style="width: 100%; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--border-color); color: #60a5fa; padding: 8px 12px; border-radius: 8px; font-family: monospace; font-size: 12px;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 700; color: #94a3b8; margin-bottom: 4px;">Badge Label</label>
                        <input type="text" name="badge_label" value="{{ $step->badge_label }}" placeholder="Step X of Y" class="form-control" style="width: 100%; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--border-color); color: #fff; padding: 8px 12px; border-radius: 8px; font-size: 12px;">
                    </div>
                </div>

                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #94a3b8; margin-bottom: 4px;">Main Description / Instructions *</label>
                    <textarea name="description" rows="2" required class="form-control" style="width: 100%; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--border-color); color: #fff; padding: 8px 12px; border-radius: 8px; font-family: inherit; font-size: 13px;">{{ $step->description }}</textarea>
                </div>

                <div style="display: grid; grid-template-columns: 240px 1fr; gap: 14px; margin-bottom: 16px;">
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 700; color: #fbbf24; margin-bottom: 4px;">Feature Highlight Title</label>
                        <input type="text" name="highlight_title" value="{{ $step->highlight_title }}" class="form-control" style="width: 100%; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--border-color); color: #fbbf24; padding: 8px 12px; border-radius: 8px; font-size: 12.5px;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 700; color: #94a3b8; margin-bottom: 4px;">Feature Highlight Text / Tip</label>
                        <input type="text" name="highlight_text" value="{{ $step->highlight_text }}" class="form-control" style="width: 100%; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--border-color); color: #cbd5e1; padding: 8px 12px; border-radius: 8px; font-size: 12.5px;">
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 10px; border-top: 1px solid rgba(255,255,255,0.05);">
                    <button type="submit" class="btn btn-primary btn-action" style="padding: 6px 16px; font-size: 12.5px;">
                        <i class="fa-solid fa-floppy-disk mr-1"></i> Save Changes to Step #{{ $step->step_number }}
                    </button>
            </form>
                    <form action="{{ route('admin.onboarding-tour.destroy_step', $step->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete Step #{{ $step->step_number }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-action" style="padding: 6px 12px; font-size: 12px; background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); border-radius: 8px; cursor: pointer;">
                            <i class="fa-solid fa-trash mr-1"></i> Delete Step
                        </button>
                    </form>
                </div>
        </div>
    @endforeach
</div>

<!-- Add Step Modal -->
<div id="addStepModal" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.85); backdrop-filter: blur(8px); z-index: 2000; align-items: center; justify-content: center; padding: 20px; box-sizing: border-box;">
    <div style="background: #0f172a; border: 1px solid var(--border-color); border-radius: 16px; max-width: 600px; width: 100%; padding: 26px; box-shadow: 0 20px 50px rgba(0,0,0,0.9); position: relative;">
        <button type="button" onclick="document.getElementById('addStepModal').style.display='none'" style="position: absolute; top: 16px; right: 16px; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #94a3b8; width: 30px; height: 30px; border-radius: 50%; cursor: pointer;">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h3 style="font-size: 17px; font-weight: 800; color: #fff; margin-bottom: 16px;">Add New Walkthrough Step</h3>

        <form action="{{ route('admin.onboarding-tour.store_step') }}" method="POST">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 140px; gap: 14px; margin-bottom: 14px;">
                <div>
                    <label style="display: block; font-size: 12.5px; font-weight: 700; color: #cbd5e1; margin-bottom: 4px;">Step Title *</label>
                    <input type="text" name="title" required placeholder="e.g. Legal Research & Citation" style="width: 100%; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--border-color); color: #fff; padding: 9px 12px; border-radius: 8px;">
                </div>
                <div>
                    <label style="display: block; font-size: 12.5px; font-weight: 700; color: #cbd5e1; margin-bottom: 4px;">Icon Class *</label>
                    <input type="text" name="icon" required placeholder="fa-book" value="fa-compass" style="width: 100%; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--border-color); color: #60a5fa; padding: 9px 12px; border-radius: 8px;">
                </div>
            </div>

            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: #cbd5e1; margin-bottom: 4px;">Description *</label>
                <textarea name="description" rows="3" required placeholder="Describe what the user can do in this step..." style="width: 100%; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--border-color); color: #fff; padding: 9px 12px; border-radius: 8px; font-family: inherit; font-size: 13px;"></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 18px;">
                <div>
                    <label style="display: block; font-size: 12.5px; font-weight: 700; color: #fbbf24; margin-bottom: 4px;">Highlight Title</label>
                    <input type="text" name="highlight_title" placeholder="Quick Tip" style="width: 100%; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--border-color); color: #fbbf24; padding: 9px 12px; border-radius: 8px;">
                </div>
                <div>
                    <label style="display: block; font-size: 12.5px; font-weight: 700; color: #cbd5e1; margin-bottom: 4px;">Highlight Text</label>
                    <input type="text" name="highlight_text" placeholder="Short tip text..." style="width: 100%; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--border-color); color: #cbd5e1; padding: 9px 12px; border-radius: 8px;">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer; color: #fff; font-size: 13px;">
                    <input type="checkbox" name="is_active" value="1" checked style="accent-color: #3b82f6;">
                    <span>Active in tour sequence</span>
                </label>
            </div>

            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" onclick="document.getElementById('addStepModal').style.display='none'" class="btn btn-secondary btn-action" style="padding: 8px 16px;">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary btn-action" style="padding: 8px 20px;">
                    <i class="fa-solid fa-plus mr-1"></i> Add Step
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

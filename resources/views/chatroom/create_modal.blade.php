<!-- Modal to Create Discussion / Chatroom -->
<div id="createChatroomModal" 
     onclick="if(event.target === this) this.style.display='none'"
     style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.8); z-index: 250000; align-items: center; justify-content: center; padding: 20px 16px; backdrop-filter: blur(8px); overflow-y: auto;">
    
    <div style="background: #0f172a; border: 1px solid var(--border-color); border-radius: 20px; width: 100%; max-width: 580px; max-height: calc(100vh - 40px); display: flex; flex-direction: column; box-shadow: 0 25px 60px rgba(0,0,0,0.6); overflow: hidden; margin: auto; animation: modalSlideUp 0.25s ease;">
        
        <!-- Modal Pinned Header -->
        <div style="padding: 18px 22px; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; background: #0f172a;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(59, 130, 246, 0.15); display: flex; align-items: center; justify-content: center; color: #60a5fa; flex-shrink: 0;">
                    <i class="fa-solid fa-plus"></i>
                </div>
                <div>
                    <h3 style="font-size: 17px; font-weight: 700; color: #fff; margin: 0;">Start a Discussion</h3>
                    <p style="color: var(--text-secondary); font-size: 12px; margin: 2px 0 0 0;">Create a new thread or room for the community.</p>
                </div>
            </div>
            <button type="button" onclick="document.getElementById('createChatroomModal').style.display='none'" 
                    style="background: rgba(255,255,255,0.06); border: 1px solid var(--border-color); color: var(--text-secondary); width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; font-size: 15px; cursor: pointer; transition: all 0.2s;"
                    onmouseover="this.style.color='#fff'; this.style.background='rgba(255,255,255,0.12)'"
                    onmouseout="this.style.color='var(--text-secondary)'; this.style.background='rgba(255,255,255,0.06)'">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Scrollable Modal Body -->
        <div style="overflow-y: auto; -webkit-overflow-scrolling: touch; flex: 1; padding: 20px 22px;">
            @auth
                <form action="{{ route('chatroom.store') }}" method="POST">
                    @csrf

                    <!-- Title -->
                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Discussion Topic Title *</label>
                        <input type="text" name="title" required placeholder="e.g. Landmark Ruling on Land Tenure in High Court" 
                               style="width: 100%; background: #070d19; border: 1px solid var(--border-color); border-radius: 10px; padding: 10px 14px; color: #fff; font-size: 13.5px; outline: none;">
                    </div>

                    <!-- Category -->
                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Select Chatroom Category *</label>
                        <select name="category" required style="width: 100%; background: #070d19; border: 1px solid var(--border-color); border-radius: 10px; padding: 10px 14px; color: #fff; font-size: 13.5px; outline: none;">
                            <option value="general">💬 General Room (Public Legal Discussions)</option>
                            @if(auth()->user()->isAdmin() || auth()->user()->user_type === 'student')
                                <option value="student" {{ (isset($category) && $category === 'student') ? 'selected' : '' }}>🎓 Student Room (Law Students & Academics)</option>
                            @endif
                            @if(auth()->user()->isAdmin() || auth()->user()->user_type === 'lawyer')
                                <option value="lawyer" {{ (isset($category) && $category === 'lawyer') ? 'selected' : '' }}>⚖️ Lawyer Room (Practicing Advocates & Counsel)</option>
                            @endif
                            @if(auth()->user()->isAdmin() || auth()->user()->user_type === 'researcher')
                                <option value="researcher" {{ (isset($category) && $category === 'researcher') ? 'selected' : '' }}>🔬 Researcher Room (Scholars & Judicial Research)</option>
                            @endif
                        </select>
                    </div>

                    <!-- Initial Topic Message / Description -->
                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Discussion Opening / Prompt *</label>
                        <textarea name="description" rows="3" required placeholder="Share your legal insights, questions, or context for the community..." 
                                  style="width: 100%; background: #070d19; border: 1px solid var(--border-color); border-radius: 10px; padding: 10px 14px; color: #fff; font-size: 13.5px; outline: none; resize: vertical;"></textarea>
                    </div>

                    <!-- Premium Toggle (for Researchers, Lawyers, Subscribers, Admins) -->
                    @php
                        $userRole = strtolower(auth()->user()->user_type ?? '');
                        $canPublishPremium = auth()->user()->hasFullAccess() 
                            || auth()->user()->isAdmin() 
                            || in_array($userRole, ['researcher', 'lawyer']);
                        $initialCode = 'SEC-' . strtoupper(Str::random(6));
                    @endphp

                    @if($canPublishPremium)
                        <div style="background: rgba(245, 158, 11, 0.08); border: 1px solid rgba(245, 158, 11, 0.25); border-radius: 12px; padding: 12px 14px; margin-bottom: 12px; transition: all 0.25s ease;">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <div style="font-weight: 700; color: #f59e0b; font-size: 12.5px; display: flex; align-items: center; gap: 6px;">
                                        <i class="fa-solid fa-crown"></i> Publish as Premium Forum Room
                                    </div>
                                    <small style="color: var(--text-secondary); font-size: 11px;">Features your room with VIP badge, access controls, and highlighted ranking.</small>
                                </div>
                                <input type="checkbox" name="is_premium" id="toggleIsPremium" value="1" onchange="togglePremiumSettings(this.checked)" style="width: 18px; height: 18px; cursor: pointer; accent-color: #f59e0b;">
                            </div>

                            <!-- Expandable Premium Configuration Settings -->
                            <div id="premiumSettingsContainer" style="display: none; margin-top: 14px; padding-top: 14px; border-top: 1px dashed rgba(245, 158, 11, 0.3);">
                                
                                <!-- Access Method Heading -->
                                <label style="display: block; font-size: 11.5px; font-weight: 700; color: #fbbf24; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">
                                    <i class="fa-solid fa-shield-halved mr-1"></i> Choose Access Method to Join Thread:
                                </label>

                                <!-- Access Methods Grid -->
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 14px;">
                                    <!-- Option 1: Security Pass (Active) -->
                                    <label style="background: rgba(15, 23, 42, 0.7); border: 1.5px solid #f59e0b; border-radius: 10px; padding: 10px 12px; cursor: pointer; display: flex; align-items: flex-start; gap: 8px;">
                                        <input type="radio" name="access_type" value="security_pass" checked style="accent-color: #f59e0b; margin-top: 3px;">
                                        <div>
                                            <div style="font-size: 12px; font-weight: 700; color: #fff; display: flex; align-items: center; gap: 5px;">
                                                <i class="fa-solid fa-key" style="color: #f59e0b;"></i> Security Pass
                                            </div>
                                            <div style="font-size: 10.5px; color: var(--text-secondary); line-height: 1.35; margin-top: 2px;">
                                                Creator generates a security code. Participants request code to join.
                                            </div>
                                        </div>
                                    </label>

                                    <!-- Option 2: Pay an Entry Fee (In Development) -->
                                    <label style="background: rgba(15, 23, 42, 0.35); border: 1px dashed rgba(255, 255, 255, 0.15); border-radius: 10px; padding: 10px 12px; cursor: not-allowed; opacity: 0.65; display: flex; align-items: flex-start; gap: 8px;" title="This payment feature is currently under active development">
                                        <input type="radio" name="access_type" value="fee" disabled style="margin-top: 3px;">
                                        <div>
                                            <div style="font-size: 12px; font-weight: 700; color: #94a3b8; display: flex; align-items: center; gap: 5px;">
                                                <i class="fa-solid fa-credit-card"></i> Pay Entry Fee
                                                <span style="background: rgba(239, 68, 68, 0.2); color: #f87171; font-size: 9px; font-weight: 700; padding: 1px 5px; border-radius: 4px; text-transform: uppercase;">Coming Soon</span>
                                            </div>
                                            <div style="font-size: 10.5px; color: #64748b; line-height: 1.35; margin-top: 2px;">
                                                Monetized participation. (Under active development)
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <!-- Security Code Generator Block -->
                                <div style="background: rgba(0, 0, 0, 0.25); border: 1px solid rgba(245, 158, 11, 0.2); border-radius: 10px; padding: 12px; margin-bottom: 12px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
                                        <label style="font-size: 11.5px; font-weight: 600; color: #e2e8f0;">Discussion Security Code *</label>
                                        <button type="button" onclick="generateNewSecurityCode()" style="background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.3); color: #fbbf24; font-size: 10.5px; font-weight: 600; padding: 3px 8px; border-radius: 6px; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                                            <i class="fa-solid fa-arrows-rotate"></i> Regenerate Code
                                        </button>
                                    </div>
                                    <input type="text" name="security_code" id="inputSecurityCode" value="{{ $initialCode }}" 
                                           style="width: 100%; background: #070d19; border: 1px solid rgba(245, 158, 11, 0.4); border-radius: 8px; padding: 8px 12px; color: #fbbf24; font-family: monospace; font-size: 14px; font-weight: 700; letter-spacing: 1.5px; outline: none;">
                                    <small style="display: block; color: var(--text-secondary); font-size: 10.5px; margin-top: 4px;">
                                        Share this code with participants who request to join your thread.
                                    </small>
                                </div>

                                <!-- Researcher Contact Channels to Demand Code -->
                                <div style="margin-bottom: 12px;">
                                    <label style="display: block; font-size: 11.5px; font-weight: 600; color: #e2e8f0; margin-bottom: 6px;">
                                        Your Channels for Code Requests (Where members can demand pass):
                                    </label>
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                                        <div>
                                            <div style="display: flex; align-items: center; gap: 5px; font-size: 11px; color: #34d399; margin-bottom: 3px; font-weight: 600;">
                                                <i class="fa-brands fa-whatsapp"></i> WhatsApp Number
                                            </div>
                                            <input type="text" name="creator_whatsapp" value="{{ auth()->user()->phone ?? '' }}" placeholder="e.g. 0501234567" 
                                                   style="width: 100%; background: #070d19; border: 1px solid var(--border-color); border-radius: 8px; padding: 7px 10px; color: #fff; font-size: 12.5px; outline: none;">
                                        </div>
                                        <div>
                                            <div style="display: flex; align-items: center; gap: 5px; font-size: 11px; color: #60a5fa; margin-bottom: 3px; font-weight: 600;">
                                                <i class="fa-solid fa-envelope"></i> Request Email
                                            </div>
                                            <input type="email" name="creator_email" value="{{ auth()->user()->email ?? '' }}" placeholder="name@example.com" 
                                                   style="width: 100%; background: #070d19; border: 1px solid var(--border-color); border-radius: 8px; padding: 7px 10px; color: #fff; font-size: 12.5px; outline: none;">
                                        </div>
                                    </div>
                                </div>

                                <!-- 1-Month Validity Notice -->
                                <div style="background: rgba(59, 130, 246, 0.08); border: 1px solid rgba(59, 130, 246, 0.25); border-radius: 8px; padding: 9px 12px; display: flex; align-items: flex-start; gap: 8px;">
                                    <i class="fa-solid fa-clock-rotate-left" style="color: #60a5fa; font-size: 13px; margin-top: 2px;"></i>
                                    <div style="font-size: 11px; color: #94a3b8; line-height: 1.4;">
                                        <strong style="color: #93c5fd;">Validity Duration:</strong> At most <strong>1 month (30 days)</strong>. After 1 month, public discussion locks, but you (as the creator) retain continuous access to all content.
                                    </div>
                                </div>

                            </div>
                        </div>

                        <script>
                            function togglePremiumSettings(isChecked) {
                                const container = document.getElementById('premiumSettingsContainer');
                                if (container) {
                                    container.style.display = isChecked ? 'block' : 'none';
                                }
                            }

                            function generateNewSecurityCode() {
                                const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
                                let code = 'SEC-';
                                for (let i = 0; i < 6; i++) {
                                    code += chars.charAt(Math.floor(Math.random() * chars.length));
                                }
                                const input = document.getElementById('inputSecurityCode');
                                if (input) {
                                    input.value = code;
                                }
                            }
                        </script>
                    @endif

                    <!-- Pin to Top Toggle (Admins) -->
                    @if(auth()->user()->isAdmin())
                        <div style="background: rgba(59, 130, 246, 0.08); border: 1px solid rgba(59, 130, 246, 0.25); border-radius: 12px; padding: 12px 14px; margin-bottom: 18px; display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <div style="font-weight: 700; color: #60a5fa; font-size: 12.5px; display: flex; align-items: center; gap: 6px;">
                                    <i class="fa-solid fa-thumbtack"></i> Pin Discussion to Top (Admin)
                                </div>
                                <small style="color: var(--text-secondary); font-size: 11px;">Pins this discussion at the top of category listings.</small>
                            </div>
                            <input type="checkbox" name="is_pinned" value="1" style="width: 18px; height: 18px; cursor: pointer; accent-color: #3b82f6;">
                        </div>
                    @endif

                    <div style="display: flex; justify-content: flex-end; gap: 12px; padding-top: 6px;">
                        <button type="button" onclick="document.getElementById('createChatroomModal').style.display='none'" 
                                style="background: transparent; border: 1px solid var(--border-color); color: var(--text-secondary); padding: 9px 18px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer;">
                            Cancel
                        </button>
                        <button type="submit" 
                                style="background: var(--accent-gradient); border: none; color: #fff; padding: 9px 22px; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 14px var(--accent-glow);">
                            <i class="fa-solid fa-paper-plane mr-1"></i> Start Room
                        </button>
                    </div>
                </form>
            @else
                @php
                    $savedGuestName    = session('guest_chat_name') ?? request()->cookie('guest_chat_name');
                    $savedGuestEmail   = session('guest_chat_email') ?? request()->cookie('guest_chat_email');
                    $savedGuestContact = session('guest_chat_contact') ?? request()->cookie('guest_chat_contact');
                    $isReturningGuest  = !empty($savedGuestEmail);
                @endphp

                <!-- Guest Discussion Form (General Room Only) -->
                <form action="{{ route('chatroom.store') }}" method="POST" id="guestDiscussionForm">
                    @csrf
                    <input type="hidden" name="category" value="general">

                    @if($isReturningGuest)
                        <!-- Returning Guest: Name, Email & Contact Already Satisfied -->
                        <div style="background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.25); border-radius: 12px; padding: 12px 14px; margin-bottom: 14px; display: flex; align-items: center; justify-content: space-between; gap: 10px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 32px; height: 32px; border-radius: 50%; background: rgba(16, 185, 129, 0.2); color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0;">
                                    <i class="fa-solid fa-user-check"></i>
                                </div>
                                <div>
                                    <div style="font-size: 13px; font-weight: 700; color: #fff;">
                                        Posting as <span style="color: #10b981;">{{ $savedGuestName }}</span>
                                    </div>
                                    <div style="font-size: 11.5px; color: var(--text-secondary);">
                                        {{ $savedGuestEmail }}@if(!empty($savedGuestContact)) • {{ $savedGuestContact }}@endif
                                    </div>
                                </div>
                            </div>
                            <button type="button" onclick="toggleGuestDetailsEdit()" id="btnToggleGuestEdit" 
                                    style="background: rgba(255,255,255,0.06); border: 1px solid var(--border-color); color: #94a3b8; padding: 5px 12px; border-radius: 6px; font-size: 11.5px; font-weight: 600; cursor: pointer;">
                                Edit Info
                            </button>
                        </div>

                        <!-- Hidden Fields for Saved Guest Details -->
                        <div id="returningGuestHiddenFields">
                            <input type="hidden" name="guest_name" value="{{ $savedGuestName }}">
                            <input type="hidden" name="guest_email" value="{{ $savedGuestEmail }}">
                            <input type="hidden" name="guest_contact" value="{{ $savedGuestContact }}">
                        </div>

                        <!-- Optional Edit Box -->
                        <div id="returningGuestEditBox" style="display: none; background: rgba(0,0,0,0.3); border: 1px dashed var(--border-color); border-radius: 12px; padding: 14px; margin-bottom: 14px;">
                            <div style="margin-bottom: 10px;">
                                <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); margin-bottom: 4px;">Update Name / Pseudonym</label>
                                <input type="text" id="inputEditName" value="{{ $savedGuestName }}" 
                                       oninput="document.querySelector('#returningGuestHiddenFields input[name=guest_name]').value=this.value"
                                       style="width: 100%; background: #070d19; border: 1px solid var(--border-color); border-radius: 8px; padding: 8px 12px; color: #fff; font-size: 13px; outline: none;">
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                                <div>
                                    <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); margin-bottom: 4px;">Update Email</label>
                                    <input type="email" id="inputEditEmail" value="{{ $savedGuestEmail }}" 
                                           oninput="document.querySelector('#returningGuestHiddenFields input[name=guest_email]').value=this.value"
                                           style="width: 100%; background: #070d19; border: 1px solid var(--border-color); border-radius: 8px; padding: 8px 12px; color: #fff; font-size: 13px; outline: none;">
                                </div>
                                <div>
                                    <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); margin-bottom: 4px;">Update Contact</label>
                                    <input type="text" id="inputEditContact" value="{{ $savedGuestContact }}" 
                                           oninput="document.querySelector('#returningGuestHiddenFields input[name=guest_contact]').value=this.value"
                                           style="width: 100%; background: #070d19; border: 1px solid var(--border-color); border-radius: 8px; padding: 8px 12px; color: #fff; font-size: 13px; outline: none;">
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- First Time Guest Setup Banner -->
                        <div style="background: rgba(59, 130, 246, 0.08); border: 1px solid rgba(59, 130, 246, 0.25); border-radius: 12px; padding: 12px 14px; margin-bottom: 14px; display: flex; align-items: flex-start; gap: 10px;">
                            <i class="fa-solid fa-circle-info" style="color: #60a5fa; font-size: 15px; margin-top: 2px;"></i>
                            <div style="font-size: 12px; color: #cbd5e1; line-height: 1.45;">
                                <strong style="color: #fff;">Initial Guest Verification:</strong> Please provide your details for your first discussion. These will not be requested again for future discussions.
                                <div style="margin-top: 3px; font-size: 11px; color: var(--text-secondary);">
                                    Have an account?
                                    <a href="javascript:void(0)" onclick="document.getElementById('createChatroomModal').style.display='none'; openLoginModal();" style="color: #93c5fd; text-decoration: underline; font-weight: 600;">Sign in / Register</a>
                                </div>
                            </div>
                        </div>

                        <!-- Full Name / Pseudonym -->
                        <div style="margin-bottom: 12px;">
                            <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); margin-bottom: 4px;">Full Name / Pseudonym *</label>
                            <input type="text" name="guest_name" required placeholder="e.g. Legal Scholar / Advocate" 
                                   style="width: 100%; background: #070d19; border: 1px solid var(--border-color); border-radius: 10px; padding: 9px 13px; color: #fff; font-size: 13px; outline: none;">
                        </div>

                        <!-- Email & Contact Number (2 columns) -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 12px;">
                            <div>
                                <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); margin-bottom: 4px;">Email Address *</label>
                                <input type="email" name="guest_email" required placeholder="name@example.com" 
                                       style="width: 100%; background: #070d19; border: 1px solid var(--border-color); border-radius: 10px; padding: 9px 13px; color: #fff; font-size: 13px; outline: none;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); margin-bottom: 4px;">Contact / Phone</label>
                                <input type="tel" name="guest_contact" placeholder="e.g. 0501234567" 
                                       style="width: 100%; background: #070d19; border: 1px solid var(--border-color); border-radius: 10px; padding: 9px 13px; color: #fff; font-size: 13px; outline: none;">
                            </div>
                        </div>
                    @endif

                    <!-- Title -->
                    <div style="margin-bottom: 12px;">
                        <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); margin-bottom: 4px;">Discussion Topic Title *</label>
                        <input type="text" name="title" required placeholder="e.g. Landmark Ruling on Land Tenure in High Court" 
                               style="width: 100%; background: #070d19; border: 1px solid var(--border-color); border-radius: 10px; padding: 9px 13px; color: #fff; font-size: 13px; outline: none;">
                    </div>

                    <!-- Category Display (Locked to General Room) -->
                    <div style="margin-bottom: 12px;">
                        <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); margin-bottom: 4px;">Room Category</label>
                        <div style="background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border-color); border-radius: 10px; padding: 9px 13px; color: #fff; font-size: 12.5px; display: flex; align-items: center; justify-content: space-between;">
                            <span style="display: flex; align-items: center; gap: 8px;">
                                <i class="fa-solid fa-comments" style="color: #60a5fa;"></i>
                                <strong>General Room</strong> (Public Legal Discussions)
                            </span>
                            <span style="background: rgba(59, 130, 246, 0.15); color: #60a5fa; font-size: 10.5px; padding: 2px 7px; border-radius: 6px; font-weight: 700;">
                                Open to Guests
                            </span>
                        </div>
                    </div>

                    <!-- Initial Topic Message / Description -->
                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); margin-bottom: 4px;">Discussion Opening / Prompt *</label>
                        <textarea name="description" rows="3" required placeholder="Share your legal insights, questions, or context for the community..." 
                                  style="width: 100%; background: #070d19; border: 1px solid var(--border-color); border-radius: 10px; padding: 9px 13px; color: #fff; font-size: 13px; outline: none; resize: vertical;"></textarea>
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 12px; padding-top: 4px;">
                        <button type="button" onclick="document.getElementById('createChatroomModal').style.display='none'" 
                                style="background: transparent; border: 1px solid var(--border-color); color: var(--text-secondary); padding: 8px 18px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer;">
                            Cancel
                        </button>
                        <button type="submit" 
                                style="background: var(--accent-gradient); border: none; color: #fff; padding: 8px 22px; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 14px var(--accent-glow);">
                            <i class="fa-solid fa-paper-plane mr-1"></i> Start Discussion
                        </button>
                    </div>
                </form>

                <script>
                    function toggleGuestDetailsEdit() {
                        const box = document.getElementById('returningGuestEditBox');
                        const btn = document.getElementById('btnToggleGuestEdit');
                        if (box.style.display === 'none' || !box.style.display) {
                            box.style.display = 'block';
                            btn.textContent = 'Hide';
                        } else {
                            box.style.display = 'none';
                            btn.textContent = 'Edit Info';
                        }
                    }
                </script>
            @endauth
        </div>
    </div>
</div>

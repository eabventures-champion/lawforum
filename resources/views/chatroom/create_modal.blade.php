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

                    <!-- Premium Toggle (for Subscribers/Admins) -->
                    @if(auth()->user()->hasFullAccess() || auth()->user()->isAdmin())
                        <div style="background: rgba(245, 158, 11, 0.08); border: 1px solid rgba(245, 158, 11, 0.25); border-radius: 12px; padding: 12px 14px; margin-bottom: 18px; display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <div style="font-weight: 700; color: #f59e0b; font-size: 12.5px; display: flex; align-items: center; gap: 6px;">
                                    <i class="fa-solid fa-crown"></i> Publish as Premium Forum Room
                                </div>
                                <small style="color: var(--text-secondary); font-size: 11px;">Features your room with VIP badge and highlighted ranking.</small>
                            </div>
                            <input type="checkbox" name="is_premium" value="1" style="width: 18px; height: 18px; cursor: pointer; accent-color: #f59e0b;">
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

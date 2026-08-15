<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Select Your Role | Legals Forum</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-primary: #040814;
            --bg-glow: radial-gradient(circle at 50% 30%, rgba(59, 130, 246, 0.12) 0%, transparent 70%);
            --card-bg: rgba(13, 20, 38, 0.7);
            --border-color: rgba(255, 255, 255, 0.08);
            --accent-color: #3b82f6;
            --text-primary: #f3f4f6;
            --text-secondary: #94a3b8;
            --transition-smooth: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        body {
            background-color: var(--bg-primary);
            background-image: var(--bg-glow);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
            position: relative;
            overflow-x: hidden;
        }

        .upgrade-container {
            width: 100%;
            max-width: 680px;
            background: var(--card-bg);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 44px 38px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.5), 0 0 40px rgba(59, 130, 246, 0.08);
            position: relative;
            z-index: 10;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            background: rgba(59, 130, 246, 0.12);
            border: 1px solid rgba(59, 130, 246, 0.25);
            border-radius: 20px;
            color: #93c5fd;
            font-size: 12.5px;
            font-weight: 700;
            margin-bottom: 20px;
            letter-spacing: 0.3px;
        }

        .upgrade-title {
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #fff;
            margin-bottom: 10px;
            line-height: 1.25;
        }

        .upgrade-description {
            font-size: 14.5px;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 30px;
        }

        /* Role Cards Grid */
        .roles-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .role-card {
            background: rgba(255, 255, 255, 0.03);
            border: 2px solid rgba(255, 255, 255, 0.08);
            border-radius: 18px;
            padding: 22px 18px;
            text-align: center;
            cursor: pointer;
            transition: var(--transition-smooth);
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            user-select: none;
        }

        .role-card:hover {
            background: rgba(255, 255, 255, 0.06);
            transform: translateY(-3px);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .role-card.selected {
            background: rgba(59, 130, 246, 0.12);
            border-color: #3b82f6;
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.25);
        }

        .role-card.selected.lawyer {
            background: rgba(245, 158, 11, 0.12);
            border-color: #f59e0b;
            box-shadow: 0 10px 25px rgba(245, 158, 11, 0.25);
        }

        .role-card.selected.researcher {
            background: rgba(139, 92, 246, 0.12);
            border-color: #a855f7;
            box-shadow: 0 10px 25px rgba(168, 85, 247, 0.25);
        }

        .role-icon-wrapper {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 14px;
            transition: var(--transition-smooth);
        }

        .student .role-icon-wrapper {
            background: rgba(59, 130, 246, 0.15);
            color: #60a5fa;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .lawyer .role-icon-wrapper {
            background: rgba(245, 158, 11, 0.15);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .researcher .role-icon-wrapper {
            background: rgba(139, 92, 246, 0.15);
            color: #c084fc;
            border: 1px solid rgba(139, 92, 246, 0.3);
        }

        .role-card-title {
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 6px;
        }

        .role-card-desc {
            font-size: 12px;
            color: var(--text-secondary);
            line-height: 1.4;
        }

        .role-check-indicator {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #3b82f6;
            color: #fff;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 11px;
        }

        .role-card.selected .role-check-indicator {
            display: flex;
        }

        .role-card.selected.lawyer .role-check-indicator {
            background: #f59e0b;
        }

        .role-card.selected.researcher .role-check-indicator {
            background: #a855f7;
        }

        /* Researcher Subtype Field */
        .researcher-subfields {
            display: none;
            background: rgba(139, 92, 246, 0.08);
            border: 1px solid rgba(139, 92, 246, 0.25);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 24px;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #e2e8f0;
            margin-bottom: 8px;
        }

        .form-select, .form-input {
            width: 100%;
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            color: #fff;
            padding: 11px 14px;
            font-size: 13.5px;
            outline: none;
            transition: var(--transition-smooth);
        }

        .form-select:focus, .form-input:focus {
            border-color: #a855f7;
            box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.2);
        }

        .btn-upgrade-submit {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 8px 24px rgba(59, 130, 246, 0.35);
            transition: var(--transition-smooth);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-upgrade-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(59, 130, 246, 0.5);
        }

        .logout-footer {
            margin-top: 24px;
            text-align: center;
        }

        .logout-link {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: var(--transition-smooth);
        }

        .logout-link:hover {
            color: #ef4444;
        }

        @media (max-width: 640px) {
            .roles-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }
            .upgrade-container {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>

    <div class="upgrade-container">
        <div class="brand-badge">
            <i class="fa-solid fa-sparkles"></i>
            <span>Platform Upgrade</span>
        </div>

        <h1 class="upgrade-title">Welcome Back, {{ $user->name }}!</h1>
        <p class="upgrade-description">
            Legals Forum now provides role-tailored workspaces for <strong>Students</strong>, <strong>Lawyers</strong>, and <strong>Researchers</strong>. Please select your role to configure your workspace and activate your dashboard.
        </p>

        @if ($errors->any())
            <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #fca5a5; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-size: 13.5px;">
                <ul style="margin: 0; padding-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('account.upgrade.role.store') }}" method="POST" id="roleUpgradeForm">
            @csrf
            <input type="hidden" name="user_type" id="selectedUserType" value="{{ old('user_type', 'student') }}" required>

            <div class="roles-grid">
                <!-- Student Card -->
                <div class="role-card student {{ old('user_type', 'student') === 'student' ? 'selected' : '' }}" onclick="selectRole('student', this)">
                    <div class="role-check-indicator"><i class="fa-solid fa-check"></i></div>
                    <div class="role-icon-wrapper">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div class="role-card-title">Student</div>
                    <div class="role-card-desc">LLB, LLM & Law School students for academic studies</div>
                </div>

                <!-- Lawyer Card -->
                <div class="role-card lawyer {{ old('user_type') === 'lawyer' ? 'selected' : '' }}" onclick="selectRole('lawyer', this)">
                    <div class="role-check-indicator"><i class="fa-solid fa-check"></i></div>
                    <div class="role-icon-wrapper">
                        <i class="fa-solid fa-gavel"></i>
                    </div>
                    <div class="role-card-title">Lawyer</div>
                    <div class="role-card-desc">Practicing Advocates, Barristers & Legal Counsels</div>
                </div>

                <!-- Researcher Card -->
                <div class="role-card researcher {{ old('user_type') === 'researcher' ? 'selected' : '' }}" onclick="selectRole('researcher', this)">
                    <div class="role-check-indicator"><i class="fa-solid fa-check"></i></div>
                    <div class="role-icon-wrapper">
                        <i class="fa-solid fa-microscope"></i>
                    </div>
                    <div class="role-card-title">Researcher</div>
                    <div class="role-card-desc">Legal Academics, Policy Analysts & Jurists</div>
                </div>
            </div>

            <!-- Researcher Subfields -->
            <div class="researcher-subfields" id="researcherSubfields" style="{{ old('user_type') === 'researcher' ? 'display: block;' : '' }}">
                <label class="form-label" for="researcherTypeSelect">Specify Your Researcher Specialization *</label>
                <select name="researcher_type" id="researcherTypeSelect" class="form-select" onchange="toggleResearcherOther(this.value)">
                    <option value="">-- Select Specialization --</option>
                    @foreach($researcherTypes as $rt)
                        <option value="{{ $rt->name }}" {{ old('researcher_type') === $rt->name ? 'selected' : '' }}>{{ $rt->name }}</option>
                    @endforeach
                    <option value="Other" {{ old('researcher_type') === 'Other' ? 'selected' : '' }}>Other (Specify below)</option>
                </select>

                <div id="researcherOtherBox" style="margin-top: 12px; {{ old('researcher_type') === 'Other' ? 'display: block;' : 'display: none;' }}">
                    <label class="form-label" for="researcherOtherInput">Enter Specialization Title</label>
                    <input type="text" name="researcher_type_other" id="researcherOtherInput" class="form-input" value="{{ old('researcher_type_other') }}" placeholder="e.g. Constitutional Law Scholar">
                </div>
            </div>

            <button type="submit" class="btn-upgrade-submit">
                <span>Save Role & Activate Dashboard</span>
                <i class="fa-solid fa-arrow-right"></i>
            </button>
        </form>

        <div class="logout-footer">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <a href="#" class="logout-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-right-from-bracket"></i> Sign out to login with different credentials
            </a>
        </div>
    </div>

    <script>
        function selectRole(role, cardElement) {
            document.querySelectorAll('.role-card').forEach(c => c.classList.remove('selected'));
            cardElement.classList.add('selected');
            document.getElementById('selectedUserType').value = role;

            const subfields = document.getElementById('researcherSubfields');
            const submitBtn = document.querySelector('.btn-upgrade-submit');

            if (role === 'researcher') {
                subfields.style.display = 'block';
                submitBtn.style.background = 'linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%)';
            } else if (role === 'lawyer') {
                subfields.style.display = 'none';
                submitBtn.style.background = 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)';
            } else {
                subfields.style.display = 'none';
                submitBtn.style.background = 'linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%)';
            }
        }

        function toggleResearcherOther(val) {
            const box = document.getElementById('researcherOtherBox');
            if (box) {
                box.style.display = (val === 'Other') ? 'block' : 'none';
            }
        }
    </script>
</body>
</html>

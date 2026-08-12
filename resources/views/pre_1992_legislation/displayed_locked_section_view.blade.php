<div class="locked-section-container" style="padding: 40px 20px; text-align: center; background: rgba(12, 18, 32, 0.6); border: 1px dashed rgba(245, 158, 11, 0.3); border-radius: 16px; margin: 20px 0;">
    <div style="width: 56px; height: 56px; border-radius: 16px; background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.3); color: #f59e0b; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
        <i class="fa-solid fa-lock"></i>
    </div>
    <h4 style="color: #fff; font-weight: 700; margin-bottom: 8px;">
        {{ !empty($allPre1992Article['section']) ? $allPre1992Article['section'] . ' is Locked for Guest Users' : 'Section Locked for Guest Users' }}
    </h4>
    <p style="color: #94a3b8; font-size: 14px; max-width: 480px; margin: 0 auto 24px; line-height: 1.6;">
        You are currently browsing as a guest. Guest access is limited to the first 3 sections of Existing Laws. Please sign up as a Student, Lawyer, or Researcher to view <span style="color: #f59e0b; font-weight: 600;">{{ $allPre1992Article['section'] ?? 'this section' }}</span> and access full legal databases.
    </p>
    <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
        <a href="/register?role=student" style="background: rgba(59,130,246,0.2); color: #60a5fa; border: 1px solid rgba(59,130,246,0.4); padding: 8px 16px; border-radius: 8px; font-weight: 600; text-decoration: none;">Sign Up as Student</a>
        <a href="/register?role=lawyer" style="background: rgba(245,158,11,0.2); color: #f59e0b; border: 1px solid rgba(245,158,11,0.4); padding: 8px 16px; border-radius: 8px; font-weight: 600; text-decoration: none;">Sign Up as Lawyer</a>
        <a href="/register?role=researcher" style="background: rgba(139,92,246,0.2); color: #a78bfa; border: 1px solid rgba(139,92,246,0.4); padding: 8px 16px; border-radius: 8px; font-weight: 600; text-decoration: none;">Sign Up as Researcher</a>
    </div>
</div>

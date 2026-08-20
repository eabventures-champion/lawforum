{{-- 
    Partial view for locked section content loaded via AJAX in the reader view.
    Contains only the lock gate card — NO doctype, html, head, nav.
    Used when Pre1992Controller detects an AJAX request for a locked section.
--}}

@php
    $searchText = $searchText ?? request()->get('search_text', '');
    $actTitle = $allPre1992Article['pre_1992_act'] ?? $allPre1992Article['title'] ?? 'Legal Document';
    $sectionTitle = $allPre1992Article['section'] ?? 'Section Locked';
    $groupName = $allPre1992Article['pre_1992_group'] ?? 'Existing Laws';
@endphp

<style>
    .gate-card-partial {
        width: 100%;
        max-width: 740px;
        margin: 40px auto;
        background: rgba(15, 23, 42, 0.78);
        border: 1px solid rgba(245, 158, 11, 0.25);
        border-radius: 22px;
        padding: 38px 32px 34px;
        text-align: center;
        box-shadow: 0 25px 70px rgba(0, 0, 0, 0.85), 0 0 0 1px rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        position: relative;
        overflow: hidden;
    }

    .gate-card-partial::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #3b82f6, #f59e0b, #8b5cf6);
    }

    .lock-icon-wrap-partial {
        width: 68px;
        height: 68px;
        border-radius: 20px;
        background: radial-gradient(circle at 30% 30%, rgba(245, 158, 11, 0.25), rgba(245, 158, 11, 0.08));
        border: 1.5px solid rgba(245, 158, 11, 0.45);
        color: #fbbf24;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin-bottom: 18px;
        box-shadow: 0 0 30px rgba(245, 158, 11, 0.25);
    }

    .gate-badge-partial {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        background: rgba(245, 158, 11, 0.12);
        color: #fbbf24;
        border: 1px solid rgba(245, 158, 11, 0.28);
        margin-bottom: 14px;
    }

    .gate-title-partial {
        font-size: 22px;
        font-weight: 800;
        color: #fff;
        letter-spacing: -0.4px;
        margin-bottom: 10px;
        line-height: 1.3;
    }

    .gate-act-meta-partial {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 14px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 10px;
        font-size: 13px;
        font-weight: 500;
        color: #cbd5e1;
        margin-bottom: 18px;
        max-width: 100%;
        word-break: break-word;
    }
    .gate-act-meta-partial i { color: #60a5fa; flex-shrink: 0; }

    .gate-desc-partial {
        font-size: 14px;
        color: #94a3b8;
        line-height: 1.6;
        max-width: 580px;
        margin: 0 auto 28px;
    }
    .gate-desc-partial strong {
        color: #fff;
        font-weight: 600;
    }

    .roles-grid-partial {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 28px;
        text-align: left;
    }

    .role-card-partial {
        background: rgba(17, 24, 39, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        padding: 18px 16px 18px 16px;
        text-decoration: none !important;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden;
        color: inherit;
        min-height: 130px;
    }
    .role-card-partial:hover {
        transform: translateY(-2px);
        border-color: rgba(255, 255, 255, 0.25);
        background: rgba(25, 35, 55, 0.85);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.35);
    }
    .role-card-partial.featured-partial {
        border-color: rgba(245, 158, 11, 0.45);
        background: rgba(245, 158, 11, 0.06);
    }

    .role-icon-partial {
        position: absolute;
        bottom: 14px;
        right: 14px;
        width: 26px;
        height: 26px;
        min-width: 26px;
        max-width: 26px;
        border-radius: 7px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11.5px;
        margin: 0;
        flex-shrink: 0;
        pointer-events: none;
    }
    .role-student-partial .role-icon-partial {
        background: rgba(59, 130, 246, 0.15);
        color: #60a5fa;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }
    .role-lawyer-partial .role-icon-partial {
        background: rgba(245, 158, 11, 0.2);
        color: #f59e0b;
        border: 1px solid rgba(245, 158, 11, 0.4);
    }
    .role-researcher-partial .role-icon-partial {
        background: rgba(139, 92, 246, 0.18);
        color: #a78bfa;
        border: 1px solid rgba(139, 92, 246, 0.35);
    }

    .role-name-partial {
        font-size: 14px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 3px;
        padding-right: 48px;
    }
    .role-subtitle-partial {
        font-size: 11.5px;
        color: #94a3b8;
        line-height: 1.4;
        margin-bottom: 14px;
        padding-right: 32px;
    }
    .role-btn-text-partial {
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.25s ease;
        margin-top: auto;
    }
    .role-student-partial .role-btn-text-partial { color: #60a5fa; }
    .role-lawyer-partial .role-btn-text-partial { color: #fbbf24; }
    .role-researcher-partial .role-btn-text-partial { color: #c4b5fd; }

    .role-featured-tag-partial {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 8.5px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        padding: 2px 7px;
        border-radius: 6px;
        background: rgba(245, 158, 11, 0.25);
        color: #fbbf24;
        border: 1px solid rgba(245, 158, 11, 0.4);
    }

    .gate-footer-partial {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        flex-wrap: wrap;
        padding-top: 18px;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }
    .gate-login-prompt-partial {
        font-size: 13px;
        color: #64748b;
    }
    .gate-login-prompt-partial a {
        color: #60a5fa;
        text-decoration: none;
        font-weight: 600;
        margin-left: 4px;
    }
    .gate-login-prompt-partial a:hover { text-decoration: underline; }

    @media (max-width: 768px) {
        .gate-card-partial {
            padding: 20px 14px;
            margin: 10px auto 20px;
            border-radius: 16px;
        }
        .gate-title-partial {
            font-size: 18px;
        }
        .gate-desc-partial {
            font-size: 12.5px;
            margin-bottom: 18px;
        }
        .roles-grid-partial {
            grid-template-columns: 1fr;
            gap: 10px;
            margin-bottom: 20px;
        }
        .role-card-partial {
            padding: 14px 14px 14px 14px;
            min-height: auto;
        }
        .role-name-partial {
            font-size: 14px;
            margin-bottom: 3px;
            padding-right: 52px;
        }
        .role-subtitle-partial {
            font-size: 11.5px;
            margin-bottom: 12px;
            line-height: 1.35;
            padding-right: 36px;
        }
        .role-btn-text-partial {
            font-size: 12px;
        }
        .role-icon-partial {
            bottom: 12px;
            right: 12px;
            width: 24px;
            height: 24px;
            min-width: 24px;
            max-width: 24px;
            font-size: 10.5px;
            border-radius: 6px;
        }
        .role-featured-tag-partial {
            top: 8px;
            right: 8px;
            padding: 1px 6px;
            font-size: 8px;
        }
    }
</style>

<div class="gate-card-partial">
    
    <div class="lock-icon-wrap-partial">
        <i class="fa-solid fa-lock"></i>
    </div>

    <div class="gate-badge-partial">
        <i class="fa-solid fa-crown"></i>
        <span>Guest Preview Limit Reached</span>
    </div>

    <h1 class="gate-title-partial">
        {{ !empty($sectionTitle) ? $sectionTitle . ' is Locked' : 'Section Locked for Guest Users' }}
    </h1>

    <div class="gate-act-meta-partial">
        <i class="fa-solid fa-file-shield"></i>
        <span>{{ $actTitle }}</span>
    </div>

    <p class="gate-desc-partial">
        Guest access includes the first <strong>{{ \App\ReadingLimitSetting::get('free_preview_sections_count', 3) }} preview sections</strong> of every enactment. To unlock <strong>{{ $sectionTitle }}</strong> and explore the full legal library, create an account below.
    </p>

    {{-- ROLE SIGNUP CARDS --}}
    <div class="roles-grid-partial">
        {{-- Student --}}
        <a href="/register?role=student" class="role-card-partial role-student-partial">
            <div class="role-icon-partial">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div class="role-info-partial">
                <div class="role-name-partial">Student Account</div>
                <div class="role-subtitle-partial">Academic research, course readings & case studies</div>
            </div>
            <div class="role-btn-text-partial">
                <span>Sign Up Free</span>
                <i class="fa-solid fa-arrow-right"></i>
            </div>
        </a>

        {{-- Lawyer / Practitioner (Featured) --}}
        <a href="/register?role=lawyer" class="role-card-partial role-lawyer-partial featured-partial">
            <span class="role-featured-tag-partial">Popular</span>
            <div class="role-icon-partial">
                <i class="fa-solid fa-scale-balanced"></i>
            </div>
            <div class="role-info-partial">
                <div class="role-name-partial">Legal Practitioner</div>
                <div class="role-subtitle-partial">Full law library, judgment citations & advanced research</div>
            </div>
            <div class="role-btn-text-partial">
                <span>Join as Lawyer</span>
                <i class="fa-solid fa-arrow-right"></i>
            </div>
        </a>

        {{-- Researcher --}}
        <a href="/register?role=researcher" class="role-card-partial role-researcher-partial">
            <div class="role-icon-partial">
                <i class="fa-solid fa-microscope"></i>
            </div>
            <div class="role-info-partial">
                <div class="role-name-partial">Researcher</div>
                <div class="role-subtitle-partial">Historical Acts, amendments & legal publications</div>
            </div>
            <div class="role-btn-text-partial">
                <span>Sign Up</span>
                <i class="fa-solid fa-arrow-right"></i>
            </div>
        </a>
    </div>

    {{-- FOOTER --}}
    <div class="gate-footer-partial">
        <div class="gate-login-prompt-partial">
            Already have an account? <a href="/login">Log in here</a>
        </div>
    </div>

</div>

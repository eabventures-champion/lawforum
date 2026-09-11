<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ResearcherType;
use Illuminate\Support\Facades\Auth;

class AccountUpgradeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the role selection screen for users without a role
     */
    public function show()
    {
        $user = Auth::user();

        // If user already has a valid role and has verified email, redirect to dashboard
        if (!empty($user->user_type) && $user->hasVerifiedEmail()) {
            return redirect('/home');
        }

        // If user already chose a role but email is unverified, redirect to verify
        if (!empty($user->user_type) && !$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        $researcherTypes = ResearcherType::active()->get();
        $studentRegEnabled = \App\RegistrationSetting::get('student_registration_enabled', '1') === '1';
        $lawyerRegEnabled = \App\RegistrationSetting::get('lawyer_registration_enabled', '1') === '1';
        $researcherRegEnabled = \App\RegistrationSetting::get('researcher_registration_enabled', '1') === '1';

        return view('auth.upgrade-role', compact(
            'user',
            'researcherTypes',
            'studentRegEnabled',
            'lawyerRegEnabled',
            'researcherRegEnabled'
        ));
    }

    /**
     * Save the chosen role and send email verification if needed
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $studentRegEnabled = \App\RegistrationSetting::get('student_registration_enabled', '1') === '1';
        $lawyerRegEnabled = \App\RegistrationSetting::get('lawyer_registration_enabled', '1') === '1';
        $researcherRegEnabled = \App\RegistrationSetting::get('researcher_registration_enabled', '1') === '1';

        $allowedRoles = [];
        if ($studentRegEnabled) $allowedRoles[] = 'student';
        if ($lawyerRegEnabled) $allowedRoles[] = 'lawyer';
        if ($researcherRegEnabled) $allowedRoles[] = 'researcher';

        $inList = !empty($allowedRoles) ? implode(',', $allowedRoles) : 'student,lawyer,researcher';

        $rules = [
            'user_type' => ['required', 'string', 'in:' . $inList],
        ];

        if ($request->user_type === 'researcher') {
            $rules['researcher_type'] = ['required', 'string', 'max:255'];
            if ($request->researcher_type === 'Other') {
                $rules['researcher_type_other'] = ['required', 'string', 'max:255'];
            }
        }

        $messages = [
            'user_type.in' => 'The selected role is currently not available for selection.',
        ];

        $request->validate($rules, $messages);

        $user->user_type = $request->user_type;
        $user->researcher_type = $request->user_type === 'researcher' ? $request->researcher_type : null;
        $user->researcher_type_other = ($request->user_type === 'researcher' && $request->researcher_type === 'Other') ? $request->researcher_type_other : null;

        // Auto start demo if not already started
        if (!$user->is_demo_mode && !$user->demo_used && !$user->demo_started_at) {
            $user->startDemo();
        }

        $user->save();

        // Send email verification notification if email is unverified
        if (!$user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
            session()->flash('role_upgraded', true);
            return redirect()->route('verification.notice');
        }

        return redirect('/home')->with('success', 'Your profile and role have been updated successfully.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\RegistrationSetting;
use Illuminate\Http\Request;

class RegistrationSettingController extends Controller
{
    public function index()
    {
        $student_registration_enabled = RegistrationSetting::get('student_registration_enabled', '1');
        $lawyer_registration_enabled = RegistrationSetting::get('lawyer_registration_enabled', '1');
        $researcher_registration_enabled = RegistrationSetting::get('researcher_registration_enabled', '1');

        return view('admin.registration_settings.index', compact(
            'student_registration_enabled',
            'lawyer_registration_enabled',
            'researcher_registration_enabled'
        ));
    }

    public function update(Request $request)
    {
        RegistrationSetting::set('student_registration_enabled', $request->has('student_registration_enabled') ? '1' : '0');
        RegistrationSetting::set('lawyer_registration_enabled', $request->has('lawyer_registration_enabled') ? '1' : '0');
        RegistrationSetting::set('researcher_registration_enabled', $request->has('researcher_registration_enabled') ? '1' : '0');

        return redirect()->route('admin.registration-settings.index')
            ->with('success', 'Registration settings updated successfully.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class ProfileController extends Controller
{
    /**
     * Show the admin profile management page.
     */
    public function index()
    {
        $admin = Auth::user();
        return view('admin.profile.index', compact('admin'));
    }

    /**
     * Update the admin's personal profile information.
     */
    public function updateProfile(Request $request)
    {
        $admin = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'lname' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $admin->id,
            'phone' => 'nullable|string|max:40',
            'country' => 'nullable|string|max:100',
        ]);

        $admin->name = $request->name;
        $admin->lname = $request->lname;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        $admin->country = $request->country;
        $admin->save();

        return redirect()->route('admin.profile.index')
            ->with('success', 'Admin profile information updated successfully.');
    }

    /**
     * Update the admin's security password.
     */
    public function updatePassword(Request $request)
    {
        $admin = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, $admin->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'The provided current password does not match our records.'])
                ->withInput();
        }

        $admin->password = Hash::make($request->password);
        $admin->save();

        return redirect()->route('admin.profile.index')
            ->with('success', 'Security password changed successfully.');
    }
}

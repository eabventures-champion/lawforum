<?php

namespace App\Http\Controllers;

use App\Complaint;
use App\AdminNotification;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'type' => 'required|in:complaint,suggestion',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        $complaint = Complaint::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'type' => $request->input('type'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
        ]);

        AdminNotification::create([
            'type' => 'complaint',
            'data' => [
                'complaint_id' => $complaint->id,
                'name' => $complaint->name,
                'email' => $complaint->email,
                'type' => $complaint->type,
                'subject' => $complaint->subject,
                'message' => $complaint->message,
            ]
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Your feedback has been submitted successfully!'
            ]);
        }

        return redirect()->back()->with('complaint_success', 'Your feedback has been submitted successfully! The administration team will review and reply to you via email shortly.');
    }
}

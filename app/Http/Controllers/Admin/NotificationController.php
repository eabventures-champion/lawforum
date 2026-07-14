<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Complaint;
use App\ComplaintReply;
use App\AdminNotification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('filter', 'all');

        $query = AdminNotification::orderBy('created_at', 'desc');

        if ($filter === 'unread') {
            $query->whereNull('read_at');
        }

        $notifications = $query->paginate(15)->withQueryString();

        // Calculate statistics
        $totalAlerts = AdminNotification::count();
        $unreadAlerts = AdminNotification::whereNull('read_at')->count();
        $totalSignups = AdminNotification::where('type', 'signup')->count();
        $totalComplaints = AdminNotification::where('type', 'complaint')->count();

        // Prefetch replies for modal logs
        foreach ($notifications as $notification) {
            if ($notification->type === 'complaint') {
                $cId = $notification->data['complaint_id'] ?? null;
                if ($cId) {
                    $notification->replies = ComplaintReply::where('complaint_id', $cId)->orderBy('created_at', 'asc')->get();
                } else {
                    $notification->replies = collect();
                }
            }
        }

        return view('admin.notifications.index', compact(
            'notifications',
            'totalAlerts',
            'unreadAlerts',
            'totalSignups',
            'totalComplaints',
            'filter'
        ));
    }

    public function markRead($id)
    {
        $notification = AdminNotification::findOrFail($id);
        $notification->update(['read_at' => now()]);

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    public function markAllRead()
    {
        AdminNotification::whereNull('read_at')->update(['read_at' => now()]);

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

    public function destroy($id)
    {
        $notification = AdminNotification::findOrFail($id);
        $notification->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Notification deleted successfully.');
    }

    public function destroyAll()
    {
        AdminNotification::truncate();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'All notifications cleared.');
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|min:5'
        ]);

        $complaint = Complaint::findOrFail($id);
        $replyText = $request->input('message');

        // 1. Save reply to database
        $reply = ComplaintReply::create([
            'complaint_id' => $complaint->id,
            'message' => $replyText
        ]);

        // 2. Mark corresponding notification as read if it is unread
        $notification = AdminNotification::where('type', 'complaint')
            ->where('data->complaint_id', $complaint->id)
            ->first();
        if ($notification) {
            $notification->update(['read_at' => now()]);
        }

        // 3. Send email reply
        $recipientEmail = $complaint->email;
        $subject = 'Response to your ' . ucwords($complaint->type) . ': ' . $complaint->subject;
        
        $originalMessage = e($complaint->message);
        $replyMessage = nl2br(e($replyText));
        $typeLabel = ucwords($complaint->type);

        $emailHtml = "
        <div style=\"font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e5e7eb; border-radius: 8px; color: #1f2937;\">
            <div style=\"text-align: center; margin-bottom: 20px; border-bottom: 2px solid #3b82f6; padding-bottom: 15px;\">
                <h2 style=\"color: #3b82f6; margin: 0;\">Lawsforum Administration Response</h2>
            </div>
            <p>Dear Submitter,</p>
            <p>Thank you for contacting Lawsforum. We have received your <strong>{$typeLabel}</strong> and here is our response:</p>
            
            <div style=\"background-color: #f3f4f6; padding: 15px; border-radius: 6px; margin: 15px 0; font-style: italic; font-size: 14px; color: #4b5563;\">
                <strong>Your Original Submission:</strong><br>
                \"{$originalMessage}\"
            </div>
            
            <p><strong>Response from Administrator:</strong></p>
            <div style=\"background-color: #eff6ff; border-left: 4px solid #3b82f6; padding: 15px; border-radius: 4px; margin: 15px 0; color: #1e3a8a; line-height: 1.5;\">
                {$replyMessage}
            </div>
            
            <p style=\"margin-top: 25px; border-top: 1px solid #e5e7eb; padding-top: 15px; font-size: 12px; color: #9ca3af; text-align: center;\">
                This is an automated email response regarding your suggestion or complaint. Please do not reply to this email.
            </p>
        </div>
        ";

        try {
            Mail::send([], [], function ($message) use ($recipientEmail, $subject, $emailHtml) {
                $message->to($recipientEmail)
                        ->subject($subject)
                        ->setBody($emailHtml, 'text/html');
            });
        } catch (\Exception $e) {
            // Log email failure but proceed so database storage completes
            logger()->error('Failed to send complaint reply email: ' . $e->getMessage());
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'reply' => [
                    'message' => $reply->message,
                    'created_at' => $reply->created_at->diffForHumans()
                ]
            ]);
        }

        return redirect()->back()->with('success', 'Reply sent successfully to ' . $recipientEmail);
    }
}

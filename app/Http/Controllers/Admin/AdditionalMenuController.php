<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AdditionalMenuSetting;
use App\Chatroom;

class AdditionalMenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $settings = [
            'chatroom_enabled'            => AdditionalMenuSetting::isEnabled('chatroom_enabled', true),
            'marketplace_enabled'         => AdditionalMenuSetting::isEnabled('marketplace_enabled', true),
            'jobs_enabled'                => AdditionalMenuSetting::isEnabled('jobs_enabled', true),
            'navbar_researcher_enabled'   => AdditionalMenuSetting::isEnabled('navbar_researcher_enabled', false),
            'chatroom_general_enabled'    => AdditionalMenuSetting::isEnabled('chatroom_general_enabled', true),
            'chatroom_student_enabled'    => AdditionalMenuSetting::isEnabled('chatroom_student_enabled', true),
            'chatroom_lawyer_enabled'     => AdditionalMenuSetting::isEnabled('chatroom_lawyer_enabled', true),
            'chatroom_researcher_enabled' => AdditionalMenuSetting::isEnabled('chatroom_researcher_enabled', true),
        ];

        $chatrooms = Chatroom::with('user')
            ->withCount('messages')
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.additional-menus.index', compact('settings', 'chatrooms'));
    }

    public function updateSettings(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $keys = [
            'chatroom_enabled',
            'marketplace_enabled',
            'jobs_enabled',
            'navbar_researcher_enabled',
            'chatroom_general_enabled',
            'chatroom_student_enabled',
            'chatroom_lawyer_enabled',
            'chatroom_researcher_enabled',
        ];

        foreach ($keys as $key) {
            $value = $request->has($key) ? '1' : '0';
            AdditionalMenuSetting::set($key, $value);
        }

        return redirect()->route('admin.additional-menus.index')
            ->with('success', 'Additional navigation menu settings updated successfully.');
    }

    public function toggleRoomPin($id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $room = Chatroom::findOrFail($id);
        $room->is_pinned = !$room->is_pinned;
        $room->save();

        return back()->with('success', 'Chatroom pin status updated.');
    }

    public function toggleRoomPremium($id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $room = Chatroom::findOrFail($id);
        $room->is_premium = !$room->is_premium;
        if ($room->is_premium) {
            if (empty($room->access_type)) {
                $room->access_type = 'security_pass';
            }
            if (empty($room->security_code)) {
                $room->security_code = 'SEC-' . strtoupper(\Illuminate\Support\Str::random(6));
            }
            if (empty($room->expires_at)) {
                $room->expires_at = now()->addDays(30);
            }
        }
        $room->save();

        return back()->with('success', 'Chatroom premium status updated.');
    }

    public function toggleRoomLock($id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $room = Chatroom::findOrFail($id);
        $room->is_locked = !$room->is_locked;
        $room->save();

        $statusText = $room->is_locked ? 'locked from replies' : 'unlocked for replies';
        return back()->with('success', "Chatroom discussion is now {$statusText}.");
    }

    public function deleteRoom($id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $room = Chatroom::findOrFail($id);
        $room->delete();

        return back()->with('success', 'Chatroom deleted successfully.');
    }
}

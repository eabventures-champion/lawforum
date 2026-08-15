<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PlatformUpdate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserPlatformUpdateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get active updates for the logged in user's role and unread count
     */
    public function getUpdates()
    {
        $user = Auth::user();
        $userRole = $user->user_type ?? 'all';

        $updates = PlatformUpdate::active()
            ->forUserRole($userRole)
            ->orderBy('created_at', 'desc')
            ->get();

        // Get read update IDs for this user
        $readUpdateIds = DB::table('user_platform_updates')
            ->where('user_id', $user->id)
            ->whereNotNull('read_at')
            ->pluck('update_id')
            ->toArray();

        $unreadCount = 0;
        $updatesData = $updates->map(function ($update) use ($readUpdateIds, &$unreadCount) {
            $isRead = in_array($update->id, $readUpdateIds);
            if (!$isRead) {
                $unreadCount++;
            }

            return [
                'id' => $update->id,
                'title' => $update->title,
                'slug' => $update->slug,
                'badge_text' => $update->badge_text,
                'target_role' => $update->target_role,
                'summary' => $update->summary,
                'content' => $update->content,
                'tour_steps' => $update->tour_steps,
                'is_read' => $isRead,
                'time_ago' => $update->created_at->diffForHumans(),
            ];
        });

        // Fetch active onboarding tour steps from DB
        $tourSteps = \App\OnboardingTourStep::active()->get();
        $totalSteps = $tourSteps->count();
        $tourStepsData = $tourSteps->map(function ($step, $index) use ($totalSteps) {
            return [
                'badge' => $step->badge_label ?: ('Step ' . ($index + 1) . ' of ' . $totalSteps),
                'title' => $step->title,
                'description' => $step->description,
                'icon' => $step->icon ?: 'fa-compass',
                'highlightTitle' => $step->highlight_title,
                'highlightText' => $step->highlight_text ?: $step->description,
            ];
        });

        $tourSettings = \App\OnboardingTourSetting::getSettings();
        $welcomeDescription = str_replace(':name', $user->name, $tourSettings->welcome_description);

        return response()->json([
            'success' => true,
            'unread_count' => $unreadCount,
            'has_completed_onboarding_tour' => (bool) $user->has_completed_onboarding_tour,
            'updates' => $updatesData,
            'onboarding_tour_steps' => $tourStepsData,
            'onboarding_tour_settings' => [
                'welcome_title' => $tourSettings->welcome_title,
                'welcome_description' => $welcomeDescription,
                'welcome_btn_primary' => $tourSettings->welcome_btn_primary,
                'welcome_btn_secondary' => $tourSettings->welcome_btn_secondary,
                'auto_prompt_new_users' => (bool) $tourSettings->auto_prompt_new_users,
            ]
        ]);
    }

    /**
     * Mark a single update as read
     */
    public function markAsRead($id)
    {
        $user = Auth::user();
        $update = PlatformUpdate::findOrFail($id);

        DB::table('user_platform_updates')->updateOrInsert(
            ['user_id' => $user->id, 'update_id' => $update->id],
            ['read_at' => now(), 'updated_at' => now()]
        );

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read',
        ]);
    }

    /**
     * Mark all active updates as read for this user
     */
    public function markAllAsRead()
    {
        $user = Auth::user();
        $userRole = $user->user_type ?? 'all';

        $updates = PlatformUpdate::active()
            ->forUserRole($userRole)
            ->get();

        foreach ($updates as $update) {
            DB::table('user_platform_updates')->updateOrInsert(
                ['user_id' => $user->id, 'update_id' => $update->id],
                ['read_at' => now(), 'updated_at' => now()]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read',
        ]);
    }

    /**
     * Mark onboarding tour as completed for this user
     */
    public function completeOnboardingTour(Request $request)
    {
        $user = Auth::user();
        $user->has_completed_onboarding_tour = true;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Onboarding tour completed',
        ]);
    }
}

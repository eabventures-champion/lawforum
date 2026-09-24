<?php

namespace App\Http\Controllers;

use App\Subscription;
use App\SubscriptionTeamMember;
use App\User;
use App\UserBookmark;
use App\UserNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['acceptInvite']);
    }

    /**
     * Team Management & Collaboration Workspace.
     */
    public function index()
    {
        $user = Auth::user();
        $isOwner = $user->isTeamOwner();
        $isMember = $user->isTeamMember();
        $subscription = $user->getTeamSubscription();

        // If user is neither owner of multi-seat plan nor member of a team
        if (!$isOwner && !$isMember) {
            $multiSeatPlans = Subscription::where('is_active', true)
                ->where('max_users', '>', 1)
                ->orderBy('price', 'asc')
                ->get();

            return view('user_dashboard.team', [
                'hasTeam' => false,
                'isOwner' => false,
                'isMember' => false,
                'subscription' => $subscription,
                'multiSeatPlans' => $multiSeatPlans,
            ]);
        }

        $owner = $user->getTeamOwner();
        $maxUsers = $subscription ? (int) $subscription->max_users : 1;

        // Fetch team members
        $acceptedMembers = SubscriptionTeamMember::where('owner_id', $owner->id)
            ->where('status', 'accepted')
            ->with(['member', 'requestedPlan'])
            ->orderBy('accepted_at', 'desc')
            ->get();

        $pendingInvites = SubscriptionTeamMember::where('owner_id', $owner->id)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        // 1 (owner) + count of accepted members
        $usedSeats = 1 + $acceptedMembers->count();
        $availableSeats = max(0, $maxUsers - ($usedSeats + $pendingInvites->count()));

        // Team research activity log
        $teamUserIds = $user->getTeamUserIds();
        $recentNotes = UserNote::whereIn('user_id', $teamUserIds)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        $recentBookmarks = UserBookmark::whereIn('user_id', $teamUserIds)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        return view('user_dashboard.team', [
            'hasTeam' => true,
            'isOwner' => $isOwner,
            'isMember' => $isMember,
            'owner' => $owner,
            'subscription' => $subscription,
            'maxUsers' => $maxUsers,
            'usedSeats' => $usedSeats,
            'availableSeats' => $availableSeats,
            'acceptedMembers' => $acceptedMembers,
            'pendingInvites' => $pendingInvites,
            'recentNotes' => $recentNotes,
            'recentBookmarks' => $recentBookmarks,
        ]);
    }

    /**
     * Invite a new team member by email.
     */
    public function invite(Request $request)
    {
        $user = Auth::user();

        if (!$user->isTeamOwner()) {
            return redirect()->back()->with('error', 'Only the primary subscription owner can invite team members.');
        }

        $request->validate([
            'email' => 'required|email|max:191',
        ]);

        $email = strtolower(trim($request->email));

        // Cannot invite self
        if ($email === strtolower($user->email)) {
            return redirect()->back()->with('error', 'You cannot invite yourself to your own team.');
        }

        $subscription = $user->getTeamSubscription();
        $maxUsers = $subscription ? (int) $subscription->max_users : 1;

        // Count current team seats in use
        $currentUsed = 1 + $user->teamMembers()->whereIn('status', ['accepted', 'pending'])->count();
        if ($currentUsed >= $maxUsers) {
            return redirect()->back()->with('error', "You have reached the maximum seat limit ({$maxUsers} users) for your {$subscription->type} plan. Upgrade or remove an existing member to free up a seat.");
        }

        // Check if this email is already invited or active in this team
        $existingInvite = $user->teamMembers()
            ->where('email', $email)
            ->whereIn('status', ['accepted', 'pending'])
            ->first();

        if ($existingInvite) {
            return redirect()->back()->with('error', "{$email} is already in your team or has a pending invitation.");
        }

        $token = Str::random(40);
        $registeredUser = User::where('email', $email)->first();

        // If user already exists in system, immediately activate their seat!
        if ($registeredUser) {
            $member = SubscriptionTeamMember::create([
                'owner_id' => $user->id,
                'member_id' => $registeredUser->id,
                'email' => $email,
                'invite_token' => $token,
                'status' => 'accepted',
                'accepted_at' => now(),
            ]);

            // Dispatch notification email
            $this->sendInviteEmail($email, $user, $token, true);

            return redirect()->back()->with('status', "{$email} already has an account and has been immediately added to your {$subscription->type} team workspace!");
        }

        // Otherwise create pending invite
        SubscriptionTeamMember::create([
            'owner_id' => $user->id,
            'member_id' => null,
            'email' => $email,
            'invite_token' => $token,
            'status' => 'pending',
        ]);

        $this->sendInviteEmail($email, $user, $token, false);

        return redirect()->back()->with('status', "Invitation sent to {$email}. They will have full access once they accept or create their account.");
    }

    /**
     * Resend team invitation email.
     */
    public function resendInvite($id)
    {
        $user = Auth::user();
        $invite = $user->teamMembers()->findOrFail($id);

        if ($invite->status !== 'pending') {
            return redirect()->back()->with('error', 'Invitation has already been accepted.');
        }

        $this->sendInviteEmail($invite->email, $user, $invite->invite_token, false);

        return redirect()->back()->with('status', "Invitation email re-sent to {$invite->email}.");
    }

    /**
     * Remove a member or cancel an invite.
     */
    public function removeMember($id)
    {
        $user = Auth::user();
        $member = $user->teamMembers()->findOrFail($id);
        $email = $member->email;

        $member->delete();

        return redirect()->back()->with('status', "{$email} has been removed from your team. A seat is now available.");
    }

    /**
     * Direct link invitation acceptance.
     */
    public function acceptInvite($token)
    {
        $invite = SubscriptionTeamMember::where('invite_token', $token)
            ->where('status', 'pending')
            ->firstOrFail();

        if (Auth::check()) {
            $currentUser = Auth::user();

            // Link to the logged-in user
            $invite->update([
                'member_id' => $currentUser->id,
                'status' => 'accepted',
                'accepted_at' => now(),
            ]);

            return redirect()->route('team.index')->with('status', 'Congratulations! You have joined the collaborative research team workspace.');
        }

        // If guest, remember token & email in session and prompt registration/login
        session([
            'pending_team_invite_token' => $token,
            'pending_team_invite_email' => $invite->email,
        ]);

        $ownerName = $invite->owner ? trim($invite->owner->name . ' ' . $invite->owner->lname) : 'a team administrator';

        return redirect()->route('register', ['email' => $invite->email])
            ->with('status', "You have been invited to join {$ownerName}'s collaborative research team! Complete your registration below to activate access.");
    }

    /**
     * Send email invitation with styled notification.
     */
    protected function sendInviteEmail(string $recipientEmail, User $owner, string $token, bool $isAlreadyRegistered)
    {
        $joinUrl = url("/team/join/{$token}");
        $planName = $owner->getTeamSubscription()->type ?? 'Premium';
        $ownerName = trim($owner->name . ' ' . $owner->lname) ?: 'A team administrator';

        $subject = "Invitation to collaborate on Legals Forum: {$planName} Team Plan";

        $html = '
        <!DOCTYPE html>
        <html>
        <head><meta charset="utf-8"></head>
        <body style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, sans-serif; background-color: #0b1120; color: #f1f5f9; padding: 30px 15px; margin: 0;">
            <div style="max-width: 600px; margin: 0 auto; background: #0f172a; border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.5);">
                <div style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); padding: 32px 28px; text-align: center;">
                    <h1 style="color: #ffffff; font-size: 24px; margin: 0 0 8px; font-weight: 800;">Legals Forum Research Team</h1>
                    <p style="color: #bfdbfe; font-size: 14px; margin: 0;">Collaborative Legal Intelligence & Document Access</p>
                </div>
                <div style="padding: 32px 28px;">
                    <p style="font-size: 15px; line-height: 1.6; color: #cbd5e1; margin-top: 0;">
                        Hello,
                    </p>
                    <p style="font-size: 15px; line-height: 1.6; color: #cbd5e1;">
                        <strong style="color: #60a5fa;">' . e($ownerName) . '</strong> has invited you to share their <strong>' . e($planName) . ' Subscription</strong> on Legals Forum.
                    </p>
                    <div style="background: rgba(59, 130, 246, 0.08); border: 1px solid rgba(59, 130, 246, 0.25); border-radius: 12px; padding: 18px 20px; margin: 24px 0;">
                        <h4 style="margin: 0 0 10px; color: #93c5fd; font-size: 14px; font-weight: 700;">Included Collaborative Privileges:</h4>
                        <ul style="margin: 0; padding-left: 20px; color: #cbd5e1; font-size: 13.5px; line-height: 1.8;">
                            <li>Full access to 4th Republic Laws, Acts, & Supreme Court Judgments</li>
                            <li><strong>Shared Team Bookmarks</strong> with instant live sync</li>
                            <li><strong>Collaborative Notes & Annotations</strong> across team research</li>
                            <li>Document PDF Downloads included under the team quota</li>
                        </ul>
                    </div>
                    <div style="text-align: center; margin: 32px 0 24px;">
                        <a href="' . e($joinUrl) . '" style="display: inline-block; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: #ffffff; padding: 14px 32px; border-radius: 10px; text-decoration: none; font-weight: 700; font-size: 15px; box-shadow: 0 4px 14px rgba(59, 130, 246, 0.4);">
                            ' . ($isAlreadyRegistered ? 'Open Team Workspace' : 'Accept Invitation & Join Team') . '
                        </a>
                    </div>
                    <p style="font-size: 12.5px; color: #94a3b8; text-align: center; margin: 0;">
                        Or copy and paste this link in your browser:<br>
                        <a href="' . e($joinUrl) . '" style="color: #60a5fa; word-break: break-all;">' . e($joinUrl) . '</a>
                    </p>
                </div>
                <div style="background: rgba(255,255,255,0.02); padding: 18px 28px; text-align: center; border-top: 1px solid rgba(255,255,255,0.06); font-size: 12px; color: #64748b;">
                    Legals Forum &bull; Ghana\'s Leading Legal Research & Analytics Platform
                </div>
            </div>
        </body>
        </html>';

        try {
            Mail::html($html, function ($message) use ($recipientEmail, $subject) {
                $message->to($recipientEmail)
                    ->subject($subject);
            });
        } catch (\Throwable $e) {
            \Log::warning("Could not dispatch team invite email to {$recipientEmail}: " . $e->getMessage());
        }
    }

    /**
     * Collaborator requests subscription plan upgrade or billing permission from Account Holder.
     */
    public function requestBillingPlan(Request $request)
    {
        $user = Auth::user();

        if (!$user->isTeamMember()) {
            return response()->json([
                'success' => false,
                'message' => 'Only team collaborators can request plan changes from an account holder.'
            ], 403);
        }

        $request->validate([
            'plan_id' => 'required|exists:subscriptions,id',
            'note' => 'nullable|string|max:500',
        ]);

        $membership = $user->teamMembership;
        if (!$membership) {
            return response()->json(['success' => false, 'message' => 'Team membership not found.'], 404);
        }

        $targetPlan = Subscription::findOrFail($request->plan_id);

        $membership->update([
            'billing_request_plan_id' => $targetPlan->id,
            'billing_request_note' => trim($request->note),
            'billing_request_status' => 'pending',
            'billing_requested_at' => now(),
        ]);

        $owner = $user->getTeamOwner();
        $ownerName = $owner ? trim($owner->name . ' ' . $owner->lname) : 'Account Holder';

        return response()->json([
            'success' => true,
            'message' => "Upgrade request for {$targetPlan->type} sent to {$ownerName}! You will be notified when granted.",
            'plan_type' => $targetPlan->type,
        ]);
    }

    /**
     * Account Holder grants or revokes billing permission for a team member.
     */
    public function toggleBillingPermission(Request $request, $id)
    {
        $owner = Auth::user();
        if (!$owner->isTeamOwner()) {
            return redirect()->back()->with('error', 'Only the primary Account Holder can manage team billing permissions.');
        }

        $member = $owner->teamMembers()->findOrFail($id);
        $newPermission = !$member->can_manage_billing;

        $member->update([
            'can_manage_billing' => $newPermission,
        ]);

        $memberName = $member->member ? trim($member->member->name . ' ' . $member->member->lname) : $member->email;
        $statusText = $newPermission ? 'granted' : 'revoked';

        return redirect()->back()->with('status', "Billing permission successfully {$statusText} for {$memberName}.");
    }

    /**
     * Account Holder dismisses or approves a collaborator's plan request.
     */
    public function respondBillingRequest(Request $request, $id)
    {
        $owner = Auth::user();
        if (!$owner->isTeamOwner()) {
            return redirect()->back()->with('error', 'Only the primary Account Holder can respond to plan requests.');
        }

        $member = $owner->teamMembers()->findOrFail($id);
        $action = $request->input('action', 'dismiss');

        if ($action === 'grant_and_approve') {
            $member->update([
                'can_manage_billing' => true,
                'billing_request_status' => 'approved',
            ]);
            $memberName = $member->member ? trim($member->member->name . ' ' . $member->member->lname) : $member->email;
            return redirect()->back()->with('status', "Billing permission granted to {$memberName}. They can now complete the subscription upgrade.");
        } else {
            $member->update([
                'billing_request_status' => 'rejected',
            ]);
            return redirect()->back()->with('status', 'Plan upgrade request dismissed.');
        }
    }
}

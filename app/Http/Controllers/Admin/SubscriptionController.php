<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of subscriptions with management actions.
     */
    public function index()
    {
        $subscriptions = Subscription::orderBy('price', 'asc')->get();
        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    /**
     * Show the form for creating a new subscription plan.
     */
    public function create()
    {
        return view('admin.subscriptions.create');
    }

    /**
     * Store a newly created subscription plan.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:191',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'no_downloads' => 'required|integer|min:0',
            'general_notes' => 'nullable|string',
            'specific_notes' => 'nullable|string',
            'badge' => 'nullable|string|max:50',
            'is_popular' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'is_button_disabled' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['is_popular'] = $request->has('is_popular');
        $validated['is_button_disabled'] = $request->has('is_button_disabled');

        // If this plan is marked as popular, clear is_popular on other plans
        if ($validated['is_popular']) {
            Subscription::where('is_popular', true)->update(['is_popular' => false]);
        }

        Subscription::create($validated);

        return redirect()->route('admin.subscriptions.index')
            ->with('success', 'Subscription plan created successfully.');
    }

    /**
     * Show the form for editing the specified subscription plan.
     */
    public function edit(Subscription $subscription)
    {
        return view('admin.subscriptions.edit', compact('subscription'));
    }

    /**
     * Update the specified subscription plan.
     */
    public function update(Request $request, Subscription $subscription)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:191',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'no_downloads' => 'required|integer|min:0',
            'general_notes' => 'nullable|string',
            'specific_notes' => 'nullable|string',
            'badge' => 'nullable|string|max:50',
            'is_popular' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'is_button_disabled' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['is_popular'] = $request->has('is_popular');
        $validated['is_button_disabled'] = $request->has('is_button_disabled');

        if ($validated['is_popular']) {
            Subscription::where('id', '!=', $subscription->id)
                ->where('is_popular', true)
                ->update(['is_popular' => false]);
        }

        $subscription->update($validated);

        return redirect()->route('admin.subscriptions.index')
            ->with('success', 'Subscription plan updated successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus(Subscription $subscription)
    {
        $subscription->is_active = !$subscription->is_active;
        $subscription->save();

        return redirect()->back()
            ->with('success', 'Plan status updated to ' . ($subscription->is_active ? 'Active' : 'Inactive') . '.');
    }

    /**
     * Toggle individual Subscribe Now button disabled status.
     */
    public function toggleButton(Subscription $subscription)
    {
        $subscription->is_button_disabled = !$subscription->is_button_disabled;
        $subscription->save();

        return redirect()->back()
            ->with('success', 'Subscribe button for "' . $subscription->type . '" is now ' . ($subscription->is_button_disabled ? 'Disabled' : 'Enabled') . '.');
    }

    /**
     * Batch toggle all Subscribe Now buttons.
     */
    public function toggleAllButtons(Request $request)
    {
        $disable = $request->input('action') === 'disable';
        Subscription::query()->update(['is_button_disabled' => $disable]);

        return redirect()->back()
            ->with('success', $disable ? 'All "Subscribe Now" buttons have been disabled.' : 'All "Subscribe Now" buttons have been enabled.');
    }

    /**
     * Remove the specified subscription plan.
     */
    public function destroy(Subscription $subscription)
    {
        $subscription->delete();

        return redirect()->route('admin.subscriptions.index')
            ->with('success', 'Subscription plan deleted successfully.');
    }
}

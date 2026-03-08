<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $currentSubscription = $user->subscriptions()->where('status', 'active')->latest()->first();
        $plans = Subscription::plans();
        return view('subscription.index', compact('user', 'currentSubscription', 'plans'));
    }

    public function changePlan(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate(['plan' => ['required', 'in:free,starter,pro,business']]);

        $user = $request->user();
        $plans = Subscription::plans();
        $planLimit = $plans[$request->plan]['listings'] ?? 1;

        if ($planLimit !== -1 && $user->listings()->count() > $planLimit) {
            return back()->with('error', "You have more listings than the {$request->plan} plan allows. Remove some listings first.");
        }

        $user->update(['plan' => $request->plan]);

        Subscription::updateOrCreate(
            ['user_id' => $user->id, 'status' => 'active'],
            [
                'plan' => $request->plan,
                'status' => 'active',
                'renewal_date' => $request->plan === 'free' ? null : now()->addMonth(),
            ]
        );

        return back()->with('success', 'Plan updated. Payment integration (PayMongo/Maya) can be added for paid plans.');
    }
}

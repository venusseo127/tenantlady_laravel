<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Listing;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function dashboard(): View
    {
        $totalUsers = User::count();
        $activePaid = User::whereIn('plan', ['starter', 'pro', 'business'])->count();
        $freeUsers = User::where('plan', 'free')->count();
        $monthlySignups = User::whereMonth('created_at', now()->month)->count();
        $dailyActive = User::whereDate('last_login', today())->count();
        $monthlyActive = User::where('last_login', '>=', now()->subDays(30))->count();

        $planDistribution = User::selectRaw('plan, count(*) as count')->groupBy('plan')->pluck('count', 'plan');

        $totalListings = Listing::count();
        $avgListingsPerUser = $totalUsers > 0 ? round($totalListings / $totalUsers, 1) : 0;

        $totalBills = Bill::count();
        $onTimePayments = Bill::where('status', 'paid')->count();
        $latePayments = Bill::where('status', 'overdue')->count();

        return view('admin.dashboard', compact(
            'totalUsers', 'activePaid', 'freeUsers', 'monthlySignups',
            'dailyActive', 'monthlyActive', 'planDistribution',
            'totalListings', 'avgListingsPerUser', 'totalBills', 'onTimePayments', 'latePayments'
        ));
    }

    public function users(): View
    {
        $users = User::withCount(['listings', 'tenants'])
            ->latest()
            ->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function subscriptions(): View
    {
        $subscriptions = Subscription::with('user')->where('status', 'active')->latest()->paginate(20);
        return view('admin.subscriptions', compact('subscriptions'));
    }

    public function settings(): View
    {
        return view('admin.settings');
    }
}

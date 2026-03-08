<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Listing;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View|\Illuminate\Http\RedirectResponse
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isLandlord()) {
            return $this->landlordDashboard($user);
        }

        return $this->tenantDashboard($user);
    }

    private function landlordDashboard($user): View
    {
        $listings = $user->listings()->withCount(['tenants', 'bills'])->get();

        $totalListings = $listings->count();
        $occupiedListings = $listings->where('status', 'occupied')->count();
        $availableListings = $listings->where('status', 'available')->count();
        $totalTenants = $user->tenants()->count();

        $billsQuery = Bill::whereIn('listing_id', $listings->pluck('id'));
        $billsDue = (clone $billsQuery)->where('status', 'pending')->sum('amount');
        $billsPaid = (clone $billsQuery)->where('status', 'paid')->sum('amount');
        $overdueBills = (clone $billsQuery)->where('status', 'overdue')->count();

        return view('dashboard.landlord', compact(
            'listings', 'totalListings', 'occupiedListings', 'availableListings',
            'totalTenants', 'billsDue', 'billsPaid', 'overdueBills'
        ));
    }

    private function tenantDashboard($user): View
    {
        $tenantRecords = $user->tenantRecords()->with(['listing', 'bills'])->get();
        $bills = Bill::whereIn('tenant_id', $tenantRecords->pluck('id'))
            ->whereIn('status', ['pending', 'overdue'])
            ->orderBy('due_date')
            ->get();

        return view('dashboard.tenant', compact('tenantRecords', 'bills'));
    }
}

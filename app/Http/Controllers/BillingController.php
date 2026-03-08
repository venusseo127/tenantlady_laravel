<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Tenant;
use App\Services\FirebaseNotificationService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BillingController extends Controller
{
    public function __construct()
    {
        $this->middleware('landlord');
    }

    public function index(Request $request): View
    {
        $bills = Bill::whereIn('listing_id', $request->user()->listings()->pluck('id'))
            ->with(['tenant', 'listing'])
            ->latest()
            ->paginate(20);
        return view('bills.index', compact('bills'));
    }

    public function create(Request $request): View
    {
        $listings = $request->user()->listings()->with('tenants')->orderBy('name')->get();
        $preselectedListing = request('listing') ? (int) request('listing') : null;
        $preselectedTenant = request('tenant') ? (int) request('tenant') : null;
        return view('bills.create', compact('listings', 'preselectedListing', 'preselectedTenant'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tenant_id' => ['required', 'exists:tenants,id'],
            'listing_id' => ['required', 'exists:listings,id'],
            'type' => ['required', 'in:water,electricity,internet,rent,other'],
            'reading_start' => ['nullable', 'numeric', 'min:0'],
            'reading_end' => ['nullable', 'numeric', 'min:0'],
            'price_per_unit' => ['nullable', 'numeric', 'min:0'],
            'amount' => ['required', 'numeric', 'min:0'],
            'due_date' => ['required', 'date'],
            'description' => ['nullable', 'string'],
        ]);

        $tenant = Tenant::findOrFail($validated['tenant_id']);
        if ($tenant->user_id !== $request->user()->id || $tenant->listing_id != $validated['listing_id']) {
            abort(403);
        }

        $validated['status'] = Carbon::parse($validated['due_date'])->isPast() ? 'overdue' : 'pending';

        $bill = Bill::create($validated);

        $tenantUser = $tenant->account;
        if ($tenantUser?->fcm_token) {
            app(FirebaseNotificationService::class)->sendToUser(
                $tenantUser,
                'New bill',
                "You have a new {$bill->type} bill: ₱" . number_format($bill->amount, 0) . ' due ' . $bill->due_date->format('M d'),
                ['bill_id' => (string) $bill->id, 'type' => 'bill_created']
            );
        }

        return redirect()->route('bills.index')->with('success', 'Bill created.');
    }

    public function show(Bill $bill): View|RedirectResponse
    {
        $this->authorizeBill($bill);
        $bill->load(['tenant', 'listing', 'payments']);
        return view('bills.show', compact('bill'));
    }

    public function edit(Bill $bill): View|RedirectResponse
    {
        $this->authorizeBill($bill);
        $listings = request()->user()->listings()->with('tenants')->get();
        return view('bills.edit', compact('bill', 'listings'));
    }

    public function update(Request $request, Bill $bill): RedirectResponse
    {
        $this->authorizeBill($bill);

        $validated = $request->validate([
            'type' => ['required', 'in:water,electricity,internet,rent,other'],
            'reading_start' => ['nullable', 'numeric', 'min:0'],
            'reading_end' => ['nullable', 'numeric', 'min:0'],
            'price_per_unit' => ['nullable', 'numeric', 'min:0'],
            'amount' => ['required', 'numeric', 'min:0'],
            'due_date' => ['required', 'date'],
            'status' => ['required', 'in:pending,paid,overdue'],
            'description' => ['nullable', 'string'],
        ]);

        $bill->update($validated);

        return redirect()->route('bills.show', $bill)->with('success', 'Bill updated.');
    }

    public function destroy(Bill $bill): RedirectResponse
    {
        $this->authorizeBill($bill);
        $bill->delete();
        return redirect()->route('bills.index')->with('success', 'Bill deleted.');
    }

    public function markPaid(Bill $bill): RedirectResponse
    {
        $this->authorizeBill($bill);
        $bill->update(['status' => 'paid']);
        return back()->with('success', 'Bill marked as paid.');
    }

    private function authorizeBill(Bill $bill): void
    {
        if ($bill->listing->user_id !== request()->user()->id) {
            abort(403);
        }
    }
}

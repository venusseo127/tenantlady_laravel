<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Tenant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TenantController extends Controller
{
    public function __construct()
    {
        $this->middleware('landlord');
    }

    public function index(Request $request): View
    {
        $tenants = Tenant::where('user_id', $request->user()->id)
            ->with('listing')
            ->latest()
            ->paginate(15);
        return view('tenants.index', compact('tenants'));
    }

    public function create(Request $request): View
    {
        $listings = $request->user()->listings()->orderBy('name')->get();
        return view('tenants.create', compact('listings'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'listing_id' => ['required', 'exists:listings,id'],
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['nullable', 'string', 'max:20'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email'],
            'start_date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        $validated['user_id'] = $request->user()->id;

        Tenant::create($validated);

        return redirect()->route('tenants.index')->with('success', 'Tenant added.');
    }

    public function show(Tenant $tenant): View|RedirectResponse
    {
        $this->authorize('view', $tenant);
        $tenant->load(['listing', 'bills.payments']);
        return view('tenants.show', compact('tenant'));
    }

    public function edit(Tenant $tenant): View|RedirectResponse
    {
        $this->authorize('update', $tenant);
        $listings = request()->user()->listings()->orderBy('name')->get();
        return view('tenants.edit', compact('tenant', 'listings'));
    }

    public function update(Request $request, Tenant $tenant): RedirectResponse
    {
        $this->authorize('update', $tenant);

        $validated = $request->validate([
            'listing_id' => ['required', 'exists:listings,id'],
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['nullable', 'string', 'max:20'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email'],
            'start_date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        $tenant->update($validated);

        return redirect()->route('tenants.show', $tenant)->with('success', 'Tenant updated.');
    }

    public function destroy(Tenant $tenant): RedirectResponse
    {
        $this->authorize('delete', $tenant);
        $tenant->delete();
        return redirect()->route('tenants.index')->with('success', 'Tenant removed.');
    }
}

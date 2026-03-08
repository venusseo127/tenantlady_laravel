<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ListingController extends Controller
{
    public function __construct()
    {
        $this->middleware('landlord');
        $this->middleware('plan.limit')->only(['create', 'store']);
    }

    public function index(Request $request): View
    {
        $listings = $request->user()->listings()->withCount('tenants')->latest()->paginate(10);
        return view('listings.index', compact('listings'));
    }

    public function create(): View
    {
        return view('listings.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:room,house,apartment'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:occupied,renovation,available'],
        ]);

        $request->user()->listings()->create($validated);

        return redirect()->route('listings.index')->with('success', 'Listing created successfully.');
    }

    public function show(Listing $listing): View|RedirectResponse
    {
        $this->authorize('view', $listing);
        $listing->load(['tenants', 'bills']);
        return view('listings.show', compact('listing'));
    }

    public function edit(Listing $listing): View|RedirectResponse
    {
        $this->authorize('update', $listing);
        return view('listings.edit', compact('listing'));
    }

    public function update(Request $request, Listing $listing): RedirectResponse
    {
        $this->authorize('update', $listing);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:room,house,apartment'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:occupied,renovation,available'],
        ]);

        $listing->update($validated);

        return redirect()->route('listings.show', $listing)->with('success', 'Listing updated.');
    }

    public function destroy(Listing $listing): RedirectResponse
    {
        $this->authorize('delete', $listing);
        $listing->delete();
        return redirect()->route('listings.index')->with('success', 'Listing deleted.');
    }
}

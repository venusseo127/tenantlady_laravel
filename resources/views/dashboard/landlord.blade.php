<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">Landlord Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 rounded-lg text-emerald-800">{{ session('success') }}</div>
            @endif

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-8">
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <p class="text-sm text-slate-500">Total Listings</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $totalListings }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <p class="text-sm text-slate-500">Occupied</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $occupiedListings }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <p class="text-sm text-slate-500">Total Tenants</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $totalTenants }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <p class="text-sm text-slate-500">Bills Due</p>
                    <p class="text-2xl font-bold text-rose-600">₱{{ number_format($billsDue, 0) }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <p class="text-sm text-slate-500">Bills Paid</p>
                    <p class="text-2xl font-bold text-emerald-600">₱{{ number_format($billsPaid, 0) }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <p class="text-sm text-slate-500">Overdue Bills</p>
                    <p class="text-2xl font-bold text-amber-600">{{ $overdueBills }}</p>
                </div>
            </div>

            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-slate-900">Your Listings</h3>
                @if(auth()->user()->canAddListing())
                    <a href="{{ route('listings.create') }}" class="inline-flex items-center px-4 py-2 bg-rose-600 text-white rounded-lg font-medium hover:bg-rose-700">Add Listing</a>
                @endif
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($listings as $listing)
                    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-semibold text-slate-900">{{ $listing->name }}</h4>
                                <p class="text-sm text-slate-500">{{ ucfirst($listing->type) }} • {{ ucfirst($listing->status) }}</p>
                                <p class="mt-1 text-sm">₱{{ number_format($listing->price, 0) }}/mo</p>
                                <p class="mt-2 text-xs text-slate-400">{{ $listing->tenants_count }} tenants • {{ $listing->bills_count }} bills</p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full {{ $listing->status === 'occupied' ? 'bg-emerald-100 text-emerald-800' : ($listing->status === 'available' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-600') }}">{{ ucfirst($listing->status) }}</span>
                        </div>
                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('listings.show', $listing) }}" class="text-sm text-rose-600 hover:text-rose-700 font-medium">View</a>
                            <a href="{{ route('tenants.create') }}?listing={{ $listing->id }}" class="text-sm text-slate-600 hover:text-slate-800">Manage Tenants</a>
                            <a href="{{ route('bills.create') }}?listing={{ $listing->id }}" class="text-sm text-slate-600 hover:text-slate-800">Add Bill</a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-xl shadow-sm border border-slate-100 p-12 text-center">
                        <p class="text-slate-500">No listings yet.</p>
                        <a href="{{ route('listings.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-rose-600 text-white rounded-lg font-medium hover:bg-rose-700">Create your first listing</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>

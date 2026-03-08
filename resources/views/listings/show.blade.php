<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">{{ $listing->name }}</h2>
            <div class="flex gap-2">
                <a href="{{ route('listings.edit', $listing) }}" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50">Edit</a>
                <a href="{{ route('tenants.create') }}?listing={{ $listing->id }}" class="px-4 py-2 bg-rose-600 text-white rounded-lg font-medium hover:bg-rose-700">Add Tenant</a>
                <a href="{{ route('bills.create') }}?listing={{ $listing->id }}" class="px-4 py-2 bg-rose-600 text-white rounded-lg font-medium hover:bg-rose-700">Add Bill</a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 rounded-lg text-emerald-800">{{ session('success') }}</div>
            @endif

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <h3 class="font-semibold text-slate-900 mb-4">Listing Details</h3>
                    <dl class="space-y-2">
                        <div><dt class="text-sm text-slate-500">Type</dt><dd class="font-medium">{{ ucfirst($listing->type) }}</dd></div>
                        <div><dt class="text-sm text-slate-500">Status</dt><dd><span class="px-2 py-1 text-xs rounded-full {{ $listing->status === 'occupied' ? 'bg-emerald-100 text-emerald-800' : ($listing->status === 'available' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-600') }}">{{ ucfirst($listing->status) }}</span></dd></div>
                        <div><dt class="text-sm text-slate-500">Price</dt><dd class="font-medium">₱{{ number_format($listing->price, 0) }}/mo</dd></div>
                        @if($listing->description)
                            <div><dt class="text-sm text-slate-500">Description</dt><dd class="text-slate-700">{{ $listing->description }}</dd></div>
                        @endif
                    </dl>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <h3 class="font-semibold text-slate-900 mb-4">Tenants ({{ $listing->tenants->count() }})</h3>
                    @forelse($listing->tenants as $tenant)
                        <div class="flex justify-between items-center py-2 border-b border-slate-100 last:border-0">
                            <div>
                                <p class="font-medium text-slate-900">{{ $tenant->name }}</p>
                                <p class="text-sm text-slate-500">{{ $tenant->email ?? $tenant->phone ?? '—' }}</p>
                            </div>
                            <a href="{{ route('tenants.show', $tenant) }}" class="text-sm text-rose-600 hover:text-rose-700">View</a>
                        </div>
                    @empty
                        <p class="text-slate-500">No tenants yet.</p>
                        <a href="{{ route('tenants.create') }}?listing={{ $listing->id }}" class="mt-2 inline-block text-rose-600 hover:text-rose-700 font-medium">Add tenant</a>
                    @endforelse
                </div>
            </div>

            <div class="mt-8 bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                <h3 class="font-semibold text-slate-900 mb-4">Recent Bills</h3>
                @forelse($listing->bills->take(10) as $bill)
                    <div class="flex justify-between items-center py-3 border-b border-slate-100 last:border-0">
                        <div>
                            <p class="font-medium text-slate-900">{{ $bill->tenant->name }} — {{ ucfirst($bill->type) }}</p>
                            <p class="text-sm text-slate-500">Due {{ $bill->due_date->format('M d, Y') }}</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="font-semibold text-rose-600">₱{{ number_format($bill->amount, 0) }}</span>
                            <span class="px-2 py-1 text-xs rounded-full {{ $bill->status === 'paid' ? 'bg-emerald-100 text-emerald-800' : ($bill->status === 'overdue' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800') }}">{{ ucfirst($bill->status) }}</span>
                            <a href="{{ route('bills.show', $bill) }}" class="text-sm text-rose-600 hover:text-rose-700">View</a>
                        </div>
                    </div>
                @empty
                    <p class="text-slate-500">No bills yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>

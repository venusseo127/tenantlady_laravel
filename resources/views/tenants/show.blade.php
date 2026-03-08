<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">{{ $tenant->name }}</h2>
            <div class="flex gap-2">
                <a href="{{ route('tenants.edit', $tenant) }}" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50">Edit</a>
                <a href="{{ route('bills.create') }}?listing={{ $tenant->listing_id }}&tenant={{ $tenant->id }}" class="px-4 py-2 bg-rose-600 text-white rounded-lg font-medium hover:bg-rose-700">Add Bill</a>
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
                    <h3 class="font-semibold text-slate-900 mb-4">Tenant Details</h3>
                    <dl class="space-y-2">
                        <div><dt class="text-sm text-slate-500">Listing</dt><dd class="font-medium">{{ $tenant->listing->name }}</dd></div>
                        <div><dt class="text-sm text-slate-500">Email</dt><dd>{{ $tenant->email ?? '—' }}</dd></div>
                        <div><dt class="text-sm text-slate-500">Phone</dt><dd>{{ $tenant->phone ?? '—' }}</dd></div>
                        <div><dt class="text-sm text-slate-500">Start Date</dt><dd>{{ $tenant->start_date->format('M d, Y') }}</dd></div>
                        @if($tenant->notes)
                            <div><dt class="text-sm text-slate-500">Notes</dt><dd>{{ $tenant->notes }}</dd></div>
                        @endif
                    </dl>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <h3 class="font-semibold text-slate-900 mb-4">Bills</h3>
                    @forelse($tenant->bills as $bill)
                        <div class="flex justify-between items-center py-3 border-b border-slate-100 last:border-0">
                            <div>
                                <p class="font-medium text-slate-900">{{ ucfirst($bill->type) }}</p>
                                <p class="text-sm text-slate-500">Due {{ $bill->due_date->format('M d, Y') }}</p>
                            </div>
                            <div class="flex items-center gap-2">
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
    </div>
</x-app-layout>

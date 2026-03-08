<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">Listings</h2>
            @if(auth()->user()->canAddListing())
                <a href="{{ route('listings.create') }}" class="inline-flex items-center px-4 py-2 bg-rose-600 text-white rounded-lg font-medium hover:bg-rose-700">Add Listing</a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 rounded-lg text-emerald-800">{{ session('success') }}</div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Tenants</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($listings as $listing)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-900">{{ $listing->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-600">{{ ucfirst($listing->type) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 py-1 text-xs rounded-full {{ $listing->status === 'occupied' ? 'bg-emerald-100 text-emerald-800' : ($listing->status === 'available' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-600') }}">{{ ucfirst($listing->status) }}</span></td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-600">₱{{ number_format($listing->price, 0) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-600">{{ $listing->tenants_count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <a href="{{ route('listings.show', $listing) }}" class="text-rose-600 hover:text-rose-700 font-medium">View</a>
                                    <a href="{{ route('listings.edit', $listing) }}" class="ml-2 text-slate-600 hover:text-slate-800">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-6 py-12 text-center text-slate-500">No listings yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-3">{{ $listings->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>

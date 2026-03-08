<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">Tenants</h2>
            <a href="{{ route('tenants.create') }}" class="inline-flex items-center px-4 py-2 bg-rose-600 text-white rounded-lg font-medium hover:bg-rose-700">Add Tenant</a>
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Listing</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Start Date</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($tenants as $tenant)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-900">{{ $tenant->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-600">{{ $tenant->listing->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-600">{{ $tenant->email ?? $tenant->phone ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-600">{{ $tenant->start_date->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <a href="{{ route('tenants.show', $tenant) }}" class="text-rose-600 hover:text-rose-700 font-medium">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-6 py-12 text-center text-slate-500">No tenants yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-3">{{ $tenants->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>

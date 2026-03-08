<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">Bills</h2>
            <a href="{{ route('bills.create') }}" class="inline-flex items-center px-4 py-2 bg-rose-600 text-white rounded-lg font-medium hover:bg-rose-700">Create Bill</a>
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Tenant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Listing</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Due Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($bills as $bill)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-900">{{ $bill->tenant->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-600">{{ $bill->listing->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-600">{{ ucfirst($bill->type) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-semibold text-rose-600">₱{{ number_format($bill->amount, 0) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-600">{{ $bill->due_date->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 py-1 text-xs rounded-full {{ $bill->status === 'paid' ? 'bg-emerald-100 text-emerald-800' : ($bill->status === 'overdue' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800') }}">{{ ucfirst($bill->status) }}</span></td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <a href="{{ route('bills.show', $bill) }}" class="text-rose-600 hover:text-rose-700 font-medium">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-6 py-12 text-center text-slate-500">No bills yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-3">{{ $bills->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>

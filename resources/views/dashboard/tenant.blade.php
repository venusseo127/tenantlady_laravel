<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">Tenant Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 rounded-lg text-emerald-800">{{ session('success') }}</div>
            @endif

            <h3 class="text-lg font-semibold text-slate-900 mb-4">Bills Due</h3>

            @if($bills->isEmpty())
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-12 text-center">
                    <p class="text-slate-500">No pending bills.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($bills as $bill)
                        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div>
                                <h4 class="font-semibold text-slate-900">{{ $bill->listing->name }} — {{ ucfirst($bill->type) }}</h4>
                                <p class="text-sm text-slate-500">Due: {{ $bill->due_date->format('M d, Y') }}</p>
                                <p class="mt-1 text-lg font-bold text-rose-600">₱{{ number_format($bill->amount, 0) }}</p>
                            </div>
                            <div class="flex gap-2">
                                @if($bill->payments()->where('status', 'pending')->exists())
                                    <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-sm">Proof pending</span>
                                @else
                                    <a href="{{ route('payments.create', $bill) }}" class="inline-flex items-center px-4 py-2 bg-rose-600 text-white rounded-lg font-medium hover:bg-rose-700 text-sm">Upload Payment Proof</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @if($tenantRecords->isNotEmpty())
                <h3 class="text-lg font-semibold text-slate-900 mt-8 mb-4">Your Rentals</h3>
                <div class="grid gap-4 sm:grid-cols-2">
                    @foreach($tenantRecords as $record)
                        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                            <h4 class="font-semibold text-slate-900">{{ $record->listing->name }}</h4>
                            <p class="text-sm text-slate-500">{{ ucfirst($record->listing->type) }} • {{ $record->listing->status }}</p>
                            <p class="mt-4 text-sm text-slate-600">Since {{ $record->start_date->format('M Y') }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

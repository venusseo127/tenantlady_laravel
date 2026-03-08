<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">Bill #{{ $bill->id }}</h2>
            <div class="flex gap-2">
                @if($bill->status !== 'paid')
                    <form method="POST" action="{{ route('bills.mark-paid', $bill) }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg font-medium hover:bg-emerald-700">Mark Paid</button>
                    </form>
                @endif
                <a href="{{ route('bills.edit', $bill) }}" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50">Edit</a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 rounded-lg text-emerald-800">{{ session('success') }}</div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 mb-6">
                <dl class="grid grid-cols-2 gap-4">
                    <div><dt class="text-sm text-slate-500">Tenant</dt><dd class="font-medium">{{ $bill->tenant->name }}</dd></div>
                    <div><dt class="text-sm text-slate-500">Listing</dt><dd>{{ $bill->listing->name }}</dd></div>
                    <div><dt class="text-sm text-slate-500">Type</dt><dd>{{ ucfirst($bill->type) }}</dd></div>
                    <div><dt class="text-sm text-slate-500">Amount</dt><dd class="font-bold text-rose-600 text-xl">₱{{ number_format($bill->amount, 0) }}</dd></div>
                    <div><dt class="text-sm text-slate-500">Due Date</dt><dd>{{ $bill->due_date->format('M d, Y') }}</dd></div>
                    <div><dt class="text-sm text-slate-500">Status</dt><dd><span class="px-2 py-1 text-xs rounded-full {{ $bill->status === 'paid' ? 'bg-emerald-100 text-emerald-800' : ($bill->status === 'overdue' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800') }}">{{ ucfirst($bill->status) }}</span></dd></div>
                </dl>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                <h3 class="font-semibold text-slate-900 mb-4">Payment Proof</h3>
                @forelse($bill->payments as $payment)
                    <div class="flex items-start gap-4 py-4 border-b border-slate-100 last:border-0">
                        <img src="{{ Storage::url($payment->proof_image) }}" alt="Proof" class="w-32 h-32 object-cover rounded-lg border">
                        <div class="flex-1">
                            <p class="text-sm text-slate-500">Uploaded {{ $payment->uploaded_at->format('M d, Y H:i') }}</p>
                            <span class="inline-block mt-1 px-2 py-1 text-xs rounded-full {{ $payment->status === 'approved' ? 'bg-emerald-100 text-emerald-800' : ($payment->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800') }}">{{ ucfirst($payment->status) }}</span>
                            @if($payment->status === 'pending' && $bill->status !== 'paid')
                                <div class="mt-2 flex gap-2">
                                    <form method="POST" action="{{ route('payments.approve', $payment) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">Approve</button>
                                    </form>
                                    <form method="POST" action="{{ route('payments.reject', $payment) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-sm text-red-600 hover:text-red-700 font-medium">Reject</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-slate-500">No payment proof uploaded yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>

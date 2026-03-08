<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800 leading-tight">Payment Proofs</h2></x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 rounded-lg text-emerald-800">{{ session('success') }}</div>
            @endif

            <div class="space-y-4">
                @forelse($payments as $payment)
                    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex flex-col sm:flex-row gap-4">
                        <img src="{{ Storage::url($payment->proof_image) }}" alt="Proof" class="w-24 h-24 object-cover rounded-lg border shrink-0">
                        <div class="flex-1">
                            <p class="font-medium text-slate-900">{{ $payment->tenant->name }} — {{ $payment->bill->listing->name }}</p>
                            <p class="text-sm text-slate-500">{{ ucfirst($payment->bill->type) }} • ₱{{ number_format($payment->bill->amount, 0) }}</p>
                            <p class="text-xs text-slate-400 mt-1">Uploaded {{ $payment->uploaded_at->format('M d, Y H:i') }}</p>
                            <span class="inline-block mt-1 px-2 py-1 text-xs rounded-full {{ $payment->status === 'approved' ? 'bg-emerald-100 text-emerald-800' : ($payment->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800') }}">{{ ucfirst($payment->status) }}</span>
                            @if($payment->status === 'pending' && auth()->user()->isLandlord())
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
                    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-12 text-center text-slate-500">No payment proofs yet.</div>
                @endforelse
            </div>
            <div class="mt-4">{{ $payments->links() }}</div>
        </div>
    </div>
</x-app-layout>

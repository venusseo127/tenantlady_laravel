<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800 leading-tight">Upload Payment Proof</h2></x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 mb-6">
                <h3 class="font-semibold text-slate-900">{{ $bill->listing->name }} — {{ ucfirst($bill->type) }}</h3>
                <p class="text-2xl font-bold text-rose-600 mt-1">₱{{ number_format($bill->amount, 0) }}</p>
                <p class="text-sm text-slate-500">Due {{ $bill->due_date->format('M d, Y') }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                <form method="POST" action="{{ route('payments.store', $bill) }}" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Payment Proof (Image)</label>
                        <input type="file" name="proof_image" accept="image/*" required class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100">
                        @error('proof_image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        <p class="mt-1 text-xs text-slate-500">Max 5MB. JPG, PNG, or GIF.</p>
                    </div>
                    <div class="mt-6 flex gap-3">
                        <button type="submit" class="px-4 py-2 bg-rose-600 text-white rounded-lg font-medium hover:bg-rose-700">Upload</button>
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

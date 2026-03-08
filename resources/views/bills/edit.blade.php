<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800 leading-tight">Edit Bill</h2></x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                <form method="POST" action="{{ route('bills.update', $bill) }}">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Type</label>
                            <select name="type" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:ring-rose-500 focus:border-rose-500">
                                @foreach(\App\Models\Bill::types() as $k => $v)
                                    <option value="{{ $k }}" {{ old('type', $bill->type) === $k ? 'selected' : '' }}>{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Reading Start</label>
                                <input type="number" name="reading_start" value="{{ old('reading_start', $bill->reading_start) }}" step="0.01" min="0" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:ring-rose-500 focus:border-rose-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Reading End</label>
                                <input type="number" name="reading_end" value="{{ old('reading_end', $bill->reading_end) }}" step="0.01" min="0" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:ring-rose-500 focus:border-rose-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Price/Unit</label>
                                <input type="number" name="price_per_unit" value="{{ old('price_per_unit', $bill->price_per_unit) }}" step="0.01" min="0" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:ring-rose-500 focus:border-rose-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Amount (₱)</label>
                            <input type="number" name="amount" value="{{ old('amount', $bill->amount) }}" step="0.01" min="0" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:ring-rose-500 focus:border-rose-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Due Date</label>
                            <input type="date" name="due_date" value="{{ old('due_date', $bill->due_date->format('Y-m-d')) }}" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:ring-rose-500 focus:border-rose-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Status</label>
                            <select name="status" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:ring-rose-500 focus:border-rose-500">
                                @foreach(\App\Models\Bill::statuses() as $k => $v)
                                    <option value="{{ $k }}" {{ old('status', $bill->status) === $k ? 'selected' : '' }}>{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Description</label>
                            <textarea name="description" rows="2" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:ring-rose-500 focus:border-rose-500">{{ old('description', $bill->description) }}</textarea>
                        </div>
                    </div>
                    <div class="mt-6 flex gap-3">
                        <button type="submit" class="px-4 py-2 bg-rose-600 text-white rounded-lg font-medium hover:bg-rose-700">Update</button>
                        <a href="{{ route('bills.show', $bill) }}" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

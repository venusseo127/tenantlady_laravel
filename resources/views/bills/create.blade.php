<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800 leading-tight">Create Bill</h2></x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                <form method="POST" action="{{ route('bills.store') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Listing</label>
                            <select name="listing_id" id="listing_id" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:ring-rose-500 focus:border-rose-500">
                                @foreach($listings as $l)
                                    <option value="{{ $l->id }}" data-tenants="{{ $l->tenants->toJson() }}" {{ ($preselectedListing ?? old('listing_id')) == $l->id ? 'selected' : '' }}>{{ $l->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Tenant</label>
                            <select name="tenant_id" id="tenant_id" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:ring-rose-500 focus:border-rose-500">
                                @foreach($listings as $l)
                                    @foreach($l->tenants as $t)
                                        <option value="{{ $t->id }}" data-listing="{{ $l->id }}" {{ ($preselectedTenant ?? old('tenant_id')) == $t->id ? 'selected' : '' }}>{{ $t->name }} ({{ $l->name }})</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Type</label>
                            <select name="type" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:ring-rose-500 focus:border-rose-500">
                                @foreach(\App\Models\Bill::types() as $k => $v)
                                    <option value="{{ $k }}" {{ old('type') === $k ? 'selected' : '' }}>{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Reading Start</label>
                                <input type="number" name="reading_start" value="{{ old('reading_start') }}" step="0.01" min="0" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:ring-rose-500 focus:border-rose-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Reading End</label>
                                <input type="number" name="reading_end" value="{{ old('reading_end') }}" step="0.01" min="0" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:ring-rose-500 focus:border-rose-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Price/Unit</label>
                                <input type="number" name="price_per_unit" value="{{ old('price_per_unit') }}" step="0.01" min="0" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:ring-rose-500 focus:border-rose-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Amount (₱)</label>
                            <input type="number" name="amount" value="{{ old('amount') }}" step="0.01" min="0" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:ring-rose-500 focus:border-rose-500">
                            @error('amount')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Due Date</label>
                            <input type="date" name="due_date" value="{{ old('due_date', date('Y-m-d')) }}" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:ring-rose-500 focus:border-rose-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Description</label>
                            <textarea name="description" rows="2" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:ring-rose-500 focus:border-rose-500">{{ old('description') }}</textarea>
                        </div>
                    </div>
                    <div class="mt-6 flex gap-3">
                        <button type="submit" class="px-4 py-2 bg-rose-600 text-white rounded-lg font-medium hover:bg-rose-700">Create Bill</button>
                        <a href="{{ route('bills.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

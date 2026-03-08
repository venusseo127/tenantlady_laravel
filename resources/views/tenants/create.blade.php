<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800 leading-tight">Add Tenant</h2></x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                <form method="POST" action="{{ route('tenants.store') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Listing</label>
                            <select name="listing_id" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:ring-rose-500 focus:border-rose-500">
                                @foreach($listings as $l)
                                    <option value="{{ $l->id }}" {{ (request('listing') == $l->id || old('listing_id') == $l->id) ? 'selected' : '' }}>{{ $l->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:ring-rose-500 focus:border-rose-500">
                            @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:ring-rose-500 focus:border-rose-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Phone</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:ring-rose-500 focus:border-rose-500">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Gender</label>
                                <select name="gender" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:ring-rose-500 focus:border-rose-500">
                                    <option value="">—</option>
                                    <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Start Date</label>
                                <input type="date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:ring-rose-500 focus:border-rose-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Notes</label>
                            <textarea name="notes" rows="2" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:ring-rose-500 focus:border-rose-500">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                    <div class="mt-6 flex gap-3">
                        <button type="submit" class="px-4 py-2 bg-rose-600 text-white rounded-lg font-medium hover:bg-rose-700">Add Tenant</button>
                        <a href="{{ route('tenants.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

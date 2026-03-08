<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800 leading-tight">Edit Listing</h2></x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                <form method="POST" action="{{ route('listings.update', $listing) }}">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Name</label>
                            <input type="text" name="name" value="{{ old('name', $listing->name) }}" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:ring-rose-500 focus:border-rose-500">
                            @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Type</label>
                            <select name="type" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:ring-rose-500 focus:border-rose-500">
                                @foreach(\App\Models\Listing::types() as $k => $v)
                                    <option value="{{ $k }}" {{ old('type', $listing->type) === $k ? 'selected' : '' }}>{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Description</label>
                            <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:ring-rose-500 focus:border-rose-500">{{ old('description', $listing->description) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Price (₱/month)</label>
                            <input type="number" name="price" value="{{ old('price', $listing->price) }}" min="0" step="0.01" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:ring-rose-500 focus:border-rose-500">
                            @error('price')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Status</label>
                            <select name="status" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:ring-rose-500 focus:border-rose-500">
                                @foreach(\App\Models\Listing::statuses() as $k => $v)
                                    <option value="{{ $k }}" {{ old('status', $listing->status) === $k ? 'selected' : '' }}>{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-6 flex gap-3">
                        <button type="submit" class="px-4 py-2 bg-rose-600 text-white rounded-lg font-medium hover:bg-rose-700">Update</button>
                        <a href="{{ route('listings.show', $listing) }}" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

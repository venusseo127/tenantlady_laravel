<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">Subscriptions</h2>
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50">Back</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Plan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Renewal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($subscriptions as $s)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="font-medium text-slate-900">{{ $s->user->name }}</p>
                                    <p class="text-sm text-slate-500">{{ $s->user->email }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-600">{{ ucfirst($s->plan) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-600">{{ $s->renewal_date?->format('M d, Y') ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 py-1 text-xs rounded-full bg-emerald-100 text-emerald-800">{{ ucfirst($s->status) }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-6 py-3">{{ $subscriptions->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>

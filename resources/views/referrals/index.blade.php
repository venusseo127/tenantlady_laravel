<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800 leading-tight">Referral Program</h2></x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 mb-8">
                <h3 class="font-semibold text-slate-900">Your Referral Link</h3>
                <p class="mt-2 text-sm text-slate-500">Share this link. When someone registers with it, you earn rewards!</p>
                <div class="mt-4 flex gap-2">
                    <input type="text" value="{{ $referralLink }}" readonly class="flex-1 rounded-md border-slate-300 shadow-sm bg-slate-50 text-slate-600 text-sm">
                    <button type="button" onclick="navigator.clipboard.writeText('{{ $referralLink }}'); alert('Copied!');" class="px-4 py-2 bg-rose-600 text-white rounded-lg font-medium hover:bg-rose-700 text-sm">Copy</button>
                </div>
                <p class="mt-2 text-xs text-slate-500">Your code: <strong>{{ auth()->user()->referral_code }}</strong></p>
            </div>

            <h3 class="font-semibold text-slate-900 mb-4">Your Referrals</h3>
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Referred User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($referrals as $ref)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-900">{{ $ref->referredUser->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-600">{{ $ref->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 py-1 text-xs rounded-full bg-slate-100 text-slate-600">{{ ucfirst($ref->status) }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-6 py-12 text-center text-slate-500">No referrals yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-3">{{ $referrals->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>

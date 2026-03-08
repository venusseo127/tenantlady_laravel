<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">Admin Dashboard</h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.users') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50">Users</a>
                <a href="{{ route('admin.subscriptions') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50">Subscriptions</a>
                <a href="{{ route('admin.settings') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50">Settings</a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 mb-8">
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <p class="text-sm text-slate-500">Total Users</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $totalUsers }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <p class="text-sm text-slate-500">Active Paid Subscribers</p>
                    <p class="text-2xl font-bold text-emerald-600">{{ $activePaid }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <p class="text-sm text-slate-500">Free Users</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $freeUsers }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <p class="text-sm text-slate-500">Monthly Signups</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $monthlySignups }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <p class="text-sm text-slate-500">Daily Active Users</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $dailyActive }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <p class="text-sm text-slate-500">Monthly Active Users</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $monthlyActive }}</p>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <h3 class="font-semibold text-slate-900 mb-4">Plan Distribution</h3>
                    <dl class="space-y-2">
                        @foreach(['free','starter','pro','business'] as $p)
                            <div class="flex justify-between"><dt>{{ ucfirst($p) }}</dt><dd class="font-medium">{{ $planDistribution[$p] ?? 0 }}</dd></div>
                        @endforeach
                    </dl>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <h3 class="font-semibold text-slate-900 mb-4">Listings & Billing</h3>
                    <dl class="space-y-2">
                        <div class="flex justify-between"><dt>Total Listings</dt><dd class="font-medium">{{ $totalListings }}</dd></div>
                        <div class="flex justify-between"><dt>Avg Listings/User</dt><dd class="font-medium">{{ $avgListingsPerUser }}</dd></div>
                        <div class="flex justify-between"><dt>Total Bills</dt><dd class="font-medium">{{ $totalBills }}</dd></div>
                        <div class="flex justify-between"><dt>On-time Payments</dt><dd class="font-medium text-emerald-600">{{ $onTimePayments }}</dd></div>
                        <div class="flex justify-between"><dt>Late Payments</dt><dd class="font-medium text-amber-600">{{ $latePayments }}</dd></div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

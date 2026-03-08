<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800 leading-tight">Subscription</h2></x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 rounded-lg text-emerald-800">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-800">{{ session('error') }}</div>
            @endif

            <p class="mb-6 text-slate-600">Current plan: <strong>{{ ucfirst($user->plan) }}</strong> • Listings: {{ $user->listings()->count() }} / {{ $user->listingLimit() === PHP_INT_MAX ? '∞' : $user->listingLimit() }}</p>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($plans as $key => $plan)
                    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 {{ $user->plan === $key ? 'ring-2 ring-rose-500' : '' }}">
                        <h3 class="font-semibold text-slate-900">{{ $plan['label'] }}</h3>
                        <p class="mt-2 text-2xl font-bold text-rose-600">₱{{ $plan['price'] }}/mo</p>
                        <p class="mt-1 text-sm text-slate-500">{{ $plan['listings'] === -1 ? 'Unlimited' : $plan['listings'] }} listings</p>
                        @if($user->plan !== $key)
                            <form method="POST" action="{{ route('subscription.change-plan') }}" class="mt-4">
                                @csrf
                                <input type="hidden" name="plan" value="{{ $key }}">
                                <button type="submit" class="w-full px-4 py-2 bg-rose-600 text-white rounded-lg font-medium hover:bg-rose-700 text-sm">Select</button>
                            </form>
                        @else
                            <p class="mt-4 text-sm text-emerald-600 font-medium">Current plan</p>
                        @endif
                    </div>
                @endforeach
            </div>

            <p class="mt-6 text-sm text-slate-500">Payment integration (PayMongo, Maya) can be added for paid plans. For now, plan changes are manual.</p>
        </div>
    </div>
</x-app-layout>

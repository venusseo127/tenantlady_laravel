<nav x-data="{ open: false }" class="bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-rose-600">tenantlady</a>
                </div>
                <div class="hidden space-x-4 sm:ms-8 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-nav-link>
                    @if(Auth::user()->isLandlord())
                        <x-nav-link :href="route('listings.index')" :active="request()->routeIs('listings.*')">Listings</x-nav-link>
                        <x-nav-link :href="route('tenants.index')" :active="request()->routeIs('tenants.*')">Tenants</x-nav-link>
                        <x-nav-link :href="route('bills.index')" :active="request()->routeIs('bills.*')">Bills</x-nav-link>
                        <x-nav-link :href="route('payments.index')" :active="request()->routeIs('payments.index')">Payments</x-nav-link>
                    @endif
                    <x-nav-link :href="route('subscription.index')" :active="request()->routeIs('subscription.*')">Subscription</x-nav-link>
                    <x-nav-link :href="route('referrals.index')" :active="request()->routeIs('referrals.*')">Referrals</x-nav-link>
                    @if(Auth::user()->isAdmin())
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')">Admin</x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-slate-600 hover:text-slate-900">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-600 hover:bg-slate-100">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24"><path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /><path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')">Dashboard</x-responsive-nav-link>
            @if(Auth::user()->isLandlord())
                <x-responsive-nav-link :href="route('listings.index')">Listings</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('tenants.index')">Tenants</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('bills.index')">Bills</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('payments.index')">Payments</x-responsive-nav-link>
            @endif
            <x-responsive-nav-link :href="route('subscription.index')">Subscription</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('referrals.index')">Referrals</x-responsive-nav-link>
            @if(Auth::user()->isAdmin())
                <x-responsive-nav-link :href="route('admin.dashboard')">Admin</x-responsive-nav-link>
            @endif
        </div>
    </div>
</nav>

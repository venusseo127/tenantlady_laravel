<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>tenantlady — Landlord & Tenant Management</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50">
    <div class="min-h-screen">
        <nav class="bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <span class="text-xl font-bold text-rose-600">tenantlady</span>
                    </div>
                    <div class="flex items-center gap-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-slate-600 hover:text-slate-900 font-medium">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-slate-600 hover:text-slate-900 font-medium">Log in</a>
                            <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-rose-600 text-white rounded-lg font-medium hover:bg-rose-700">Register</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto px-4 py-16 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-slate-900 sm:text-5xl">Landlord & Tenant Billing</h1>
                <p class="mt-4 text-lg text-slate-600 max-w-2xl mx-auto">Manage listings, tenants, utility bills, and payment proof — designed for small landlords in the Philippines.</p>
                @guest
                <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-3 bg-rose-600 text-white rounded-lg font-semibold hover:bg-rose-700">Get Started Free</a>
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-3 border border-slate-300 text-slate-700 rounded-lg font-medium hover:bg-slate-50">Log in</a>
                </div>
                @endguest
            </div>

            <div class="mt-20 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100">
                    <div class="text-rose-500 text-2xl font-bold">📋</div>
                    <h3 class="mt-2 font-semibold text-slate-900">Listings</h3>
                    <p class="mt-1 text-sm text-slate-600">Manage rooms, houses, and apartments. Track occupancy and status.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100">
                    <div class="text-rose-500 text-2xl font-bold">👥</div>
                    <h3 class="mt-2 font-semibold text-slate-900">Tenants</h3>
                    <p class="mt-1 text-sm text-slate-600">Track tenants, payment history, and timeliness analytics.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100">
                    <div class="text-rose-500 text-2xl font-bold">💰</div>
                    <h3 class="mt-2 font-semibold text-slate-900">Billing</h3>
                    <p class="mt-1 text-sm text-slate-600">Water, electricity, rent. Meter-based or fixed. Payment proof upload.</p>
                </div>
            </div>
        </main>
    </div>
</body>
</html>

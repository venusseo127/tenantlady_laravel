<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">{{ __('Log in') }}</x-primary-button>
        </div>
    </form>

    <div class="mt-6 pt-6 border-t border-gray-200">
        <p class="text-sm text-gray-600 mb-2">Or login with:</p>
        <div class="flex flex-wrap gap-3">
            @if(config('services.firebase.api_key'))
                <a href="{{ route('auth.firebase') }}" class="inline-flex items-center px-4 py-2 bg-amber-50 border border-amber-200 rounded-md text-sm font-medium text-amber-800 hover:bg-amber-100">
                    <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24"><path fill="#FFA000" d="M3.89 15.673L6.255 2.02a.453.453 0 01.666-.355l3.78 1.522a.453.453 0 00.667-.355L13.239.106a.453.453 0 01.667-.355l4.53 1.823a.453.453 0 01.278.52l-2.72 13.4a.453.453 0 01-.665.355l-3.67-1.478a.453.453 0 00-.667.355l-.67 3.33a.453.453 0 01-.666.355l-4.53-1.823a.453.453 0 01-.278-.52z"/><path fill="#FFC107" d="M18.102 4.73l-2.72 13.4a.453.453 0 01-.665.355l-4.53-1.823a.454.454 0 00-.667.355l-.67 3.33a.453.453 0 01-.666.355l-3.78-1.522a.453.453 0 01-.278-.52L9.165 2.186a.453.453 0 00-.666-.355L4.82 3.351a.453.453 0 00-.278.52L6.914 17.4a.453.453 0 00.666.355l3.78-1.522a.453.453 0 01.666.355l.67 3.33a.453.453 0 00.666.355l4.53-1.823a.453.453 0 00.278-.52L18.102 4.73z"/></svg>
                    Firebase (Google)
                </a>
            @endif
            <a href="{{ route('auth.social', 'google') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                Google
            </a>
            <a href="{{ route('auth.social', 'facebook') }}" class="inline-flex items-center px-4 py-2 bg-[#1877F2] text-white rounded-md text-sm font-medium hover:bg-[#166FE5]">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                Facebook
            </a>
        </div>
    </div>
</x-guest-layout>

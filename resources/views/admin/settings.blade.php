<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">System Settings</h2>
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50">Back</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                <p class="text-slate-600">System configuration (feature flags, maintenance mode, email templates) can be extended here. Use the <code class="bg-slate-100 px-1 rounded">SystemSetting</code> model for key-value storage.</p>
            </div>
        </div>
    </div>
</x-app-layout>

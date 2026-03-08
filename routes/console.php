<?php

use App\Models\Bill;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Mark overdue bills daily
Schedule::call(function () {
    Bill::where('status', 'pending')
        ->whereDate('due_date', '<', now())
        ->update(['status' => 'overdue']);
})->daily();

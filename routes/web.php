<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\FirebaseAuthController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FcmTokenController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TenantController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

Route::get('/', function () {
    return view('welcome');
});

// Firebase Messaging Service Worker (must be served as JS)
Route::get('/firebase-messaging-sw.js', function () {
    $content = view('firebase-messaging-sw')->render();
    return Response::make($content)->header('Content-Type', 'application/javascript');
})->name('firebase-messaging-sw');

Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirect'])->name('auth.social')->middleware('guest');
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])->name('auth.social.callback');

Route::get('/auth/firebase', [FirebaseAuthController::class, 'show'])->name('auth.firebase')->middleware('guest');
Route::post('/auth/firebase/verify', [FirebaseAuthController::class, 'verifyToken'])->name('auth.firebase.verify')->middleware('guest');

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Landlord routes
    Route::resource('listings', ListingController::class);
    Route::resource('tenants', TenantController::class);
    Route::resource('bills', BillingController::class);
    Route::post('/bills/{bill}/mark-paid', [BillingController::class, 'markPaid'])->name('bills.mark-paid');

    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/bills/{bill}/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/bills/{bill}/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::post('/payments/{payment}/approve', [PaymentController::class, 'approve'])->name('payments.approve');
    Route::post('/payments/{payment}/reject', [PaymentController::class, 'reject'])->name('payments.reject');

    Route::get('/subscription', [SubscriptionController::class, 'index'])->name('subscription.index');
    Route::post('/subscription/change-plan', [SubscriptionController::class, 'changePlan'])->name('subscription.change-plan');

    Route::get('/referrals', [ReferralController::class, 'index'])->name('referrals.index');

    Route::post('/fcm-token', [FcmTokenController::class, 'store'])->name('fcm-token.store');
    Route::delete('/fcm-token', [FcmTokenController::class, 'destroy'])->name('fcm-token.destroy');
});

Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/subscriptions', [AdminController::class, 'subscriptions'])->name('subscriptions');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
});

require __DIR__.'/auth.php';

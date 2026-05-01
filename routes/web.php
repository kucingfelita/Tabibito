<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MidtransWebhookController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;
use App\Http\Controllers\Owner\DestinationController as OwnerDestinationController;
use App\Http\Controllers\Owner\OwnerRegisterController;
use App\Http\Controllers\Owner\ScannerController;
use App\Http\Controllers\Owner\TicketController as OwnerTicketController;
use App\Http\Controllers\Owner\WithdrawalController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Traveler\HistoryController;
use App\Http\Controllers\Traveler\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/wisata', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/wisata/{destination}', [DestinationController::class, 'show'])->name('destinations.show');
Route::get('/tiket/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
Route::get('/destinations/load-more', [DestinationController::class, 'loadMore'])->name('destinations.loadMore');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
    Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('google.redirect');
    Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('google.callback');
    Route::get('/owner/register/step1', [OwnerRegisterController::class, 'step1'])->name('owner.register.step1');
    Route::post('/owner/register/step1', [OwnerRegisterController::class, 'storeStep1'])->name('owner.register.step1.store');
    Route::get('/owner/register/step2', [OwnerRegisterController::class, 'step2'])->name('owner.register.step2');
    Route::post('/owner/register/step2', [OwnerRegisterController::class, 'storeStep2'])->name('owner.register.step2.store');
});

Route::post('/midtrans/webhook', [MidtransWebhookController::class, 'handle'])->name('midtrans.webhook');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/riwayat', [HistoryController::class, 'index'])->name('history.index');
    Route::post('/riwayat/{transaction}/check-status', [HistoryController::class, 'checkStatus'])->name('history.checkStatus');
    Route::get('/checkout/{ticket}', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout/{ticket}', [CheckoutController::class, 'store'])->name('checkout.store');
});

Route::get('/checkout/payment/resume', [CheckoutController::class, 'resume'])
    ->name('checkout.resume')
    ->middleware('auth');

Route::get('/test', function () {
    return 'test ok';
});

Route::get('/finish-test', function () {
    return 'finish test';
});

Route::get('/test-checkout', function () {
    return 'test checkout';
})->withoutMiddleware(['web', 'Illuminate\Foundation\Http\Middleware\VerifyCsrfToken', 'Illuminate\Session\Middleware\StartSession', 'Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests']);

Route::get('/payment/finish', [CheckoutController::class, 'finish'])->name('checkout.finish');

Route::prefix('owner')
    ->name('owner.')
    ->middleware(['auth', 'user.type:3,1'])
    ->group(function () {
        Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');
        Route::get('/destinations', [OwnerDestinationController::class, 'index'])->name('destinations.index');
        Route::post('/destinations', [OwnerDestinationController::class, 'store'])->name('destinations.store');
        Route::put('/destinations/{destination}', [OwnerDestinationController::class, 'update'])->name('destinations.update');
        Route::delete('/destinations/{destination}', [OwnerDestinationController::class, 'destroy'])->name('destinations.destroy');
        Route::get('/tickets', [OwnerTicketController::class, 'index'])->name('tickets.index');
        Route::post('/tickets', [OwnerTicketController::class, 'store'])->name('tickets.store');
        Route::put('/tickets/{ticket}', [OwnerTicketController::class, 'update'])->name('tickets.update');
        Route::delete('/tickets/{ticket}', [OwnerTicketController::class, 'destroy'])->name('tickets.destroy');
        Route::get('/withdrawals', [WithdrawalController::class, 'index'])->name('withdrawals.index');
        Route::post('/withdrawals', [WithdrawalController::class, 'store'])->name('withdrawals.store');
        Route::get('/scanner', [ScannerController::class, 'index'])->name('scanner');
        Route::post('/scanner/verify', [ScannerController::class, 'verify'])->name('scanner.verify');
    });

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'user.type:1'])
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::patch('/destinations/{destination}/approve', [AdminDashboardController::class, 'approveDestination'])->name('destinations.approve');
        Route::patch('/destinations/{destination}/reject', [AdminDashboardController::class, 'rejectDestination'])->name('destinations.reject');
        Route::patch('/withdrawals/{withdrawal}/approve', [AdminDashboardController::class, 'approveWithdrawal'])->name('withdrawals.approve');
    });

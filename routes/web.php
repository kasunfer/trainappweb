<?php

use App\Http\Controllers\Admin\PrintController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('lang/{locale}', function ($locale) {
    App::setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about-us', [HomeController::class, 'aboutus'])->name('aboutus');
Route::get('/contact-us', [HomeController::class, 'contact_us'])->name('contact-us');
Route::get('/privacy-policy', [HomeController::class, 'privacy_policy'])->name('privacy-policy');
Route::get('/check-seats', [HomeController::class, 'getSchedulesByDate'])->name('getSchedulesByDateFront');
Route::get('/booking', [HomeController::class, 'bookingCreate'])->name('bookingfront');
Route::post('/front-booking', [HomeController::class, 'bookingStore'])->name('bookingStore');
Route::post('/cancel-booking', [HomeController::class, 'bookingCancel'])->name('bookingCancel');
Route::get('/cancel-booking-stripe', [HomeController::class, 'bookingCancelStripe'])->name('bookingCancelStripe');
Route::post('/sendOtp', [HomeController::class, 'sendOtp'])->name('sendOtp');
Route::post('/pay-here', [HomeController::class, 'Payhere'])->name('Payhere');
Route::post('verifyOtp', [HomeController::class, 'verifyOtp'])->name('verifyOtp');
Route::get('/getSeatsByScheduleAndStationsfront', [HomeController::class, 'getSeatsByScheduleAndStationsfront'])->name('getSeatsByScheduleAndStationsfront');
Route::get('print/{id}', [PrintController::class, 'Printfront'])->name('front-print.ticket');
Route::post('/stripe-checkout',[HomeController::class, 'stripe'])->name('stripe');
Route::get('/payment-success', [HomeController::class, 'paymentSuccess'])->name('payment.success');


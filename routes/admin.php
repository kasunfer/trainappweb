<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ForgotPasswordController;
use App\Http\Controllers\Admin\PrintController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ResetPasswordController;
use App\Http\Controllers\Admin\RolesAndPermissionController;
use App\Http\Controllers\Admin\RouteFeeController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\StationController;
use App\Http\Controllers\Admin\TicketVerifyController;
use App\Http\Controllers\Admin\TrainController;
use App\Http\Controllers\Admin\TrainScheduleController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('login', [AdminAuthController::class, 'login']);
Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
Route::middleware(['admin'])->group(function () {
Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::resource('roles', RolesAndPermissionController::class);
Route::resource('users', UsersController::class);
Route::resource('station', StationController::class);
Route::get('print/{id}', [PrintController::class, 'Print'])->name('print.ticket');
Route::post('station/{status}', [StationController::class, 'status'])->name('station.status');
Route::resource('train', TrainController::class);
Route::resource('train-schedules', TrainScheduleController::class);
Route::resource('bookings', BookingController::class);
Route::resource('route-fee', RouteFeeController::class);
Route::post('trains/{status}', [TrainController::class, 'status'])->name('train.status');
Route::get('/users/ActiveUsers', [UsersController::class, 'ActiveUsers'])->name('users.activeUsers');
Route::get('/profile', [UsersController::class, 'profile'])->name('users.profile');
Route::post('/user-department', [UsersController::class, 'user_department_update'])->name('users.department');
Route::post('/user-password-update', [UsersController::class, 'PasswordReset'])->name('users.password-update');
Route::post('users/{status}', [UsersController::class, 'status'])->name('users.status');
Route::get('/getSchedulesByDate', [BookingController::class, 'getSchedulesByDate'])->name('getSchedulesByDate');
Route::get('/getStationsBySchedule', [BookingController::class, 'getStationsBySchedule'])->name('getStationsBySchedule');
Route::get('/getSeatsByScheduleAndStations', [BookingController::class, 'getSeatsByScheduleAndStations'])->name('getSeatsByScheduleAndStations');
Route::get('ticket-verification/{id}', [TicketVerifyController::class, 'verifyTicket']);
Route::post('ticket-verify/{id}', [TicketVerifyController::class, 'updateVerification']);
Route::resource('/ticket-verify',TicketVerifyController::class);
Route::resource('/setting',SettingsController::class);
Route::put('admin/setting/{setting}', [SettingsController::class, 'update'])->name('setting.update');
Route::get('/booking-report', [ReportController::class, 'booking'])->name('booking.report');
Route::get('/booking-pdf', [ReportController::class, 'export_pdf'])->name('booking.pdf');
Route::get('/booking-excel', [ReportController::class, 'export_excel'])->name('booking.excel');
});

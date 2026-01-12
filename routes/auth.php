<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminEmployeeController;
use App\Http\Controllers\Admin\AdminInformationController;
use App\Http\Controllers\Admin\IpAddressController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\SecurePasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\InformationController;
use App\Http\Controllers\User\UserAttendanceController;
use App\Http\Controllers\User\UserRequestDutyController;
use App\Http\Controllers\User\UserRequestOvertimeController;
use App\Http\Controllers\User\UserRequestPermissionController;
use App\Http\Controllers\User\UserStatusController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (!auth()->check()) {
        return redirect('/login');
    }

    if (auth()->user()->role === 'admin') {
        return redirect('/admin/dashboard');
    }

    return redirect('/dashboard');
});

Route::middleware('guest')->group(function () {
    // Route::get('register', [RegisteredUserController::class, 'create'])
    //     ->name('register');

    // Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {

    Route::get('secure-password', [SecurePasswordController::class, 'create'])
        ->name('password.secure');

    Route::post('secure-password', [SecurePasswordController::class, 'store'])
        ->name('password.store.secure');

    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

Route::middleware('auth', 'verified', 'user')->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('attend/{action}', [UserAttendanceController::class, 'attend'])->name('attend');

    Route::get('history', [UserAttendanceController::class, 'history'])->name('history');
    Route::get('status', [UserStatusController::class, 'getStatus'])->name('get-status');

    Route::post('request/permission', [UserRequestPermissionController::class, 'create'])->name('request-permission.create');
    Route::post('request/overtime', [UserRequestOvertimeController::class, 'create'])->name('request-overtime.create');
    Route::post('request/duty', [UserRequestDutyController::class, 'create'])->name('request-duty.create');

    Route::get('/history/findmany', [AttendanceController::class, 'findMany'])->name('history.find-many');
    Route::get('/history/export', [AttendanceController::class, 'exportAttendance'])->name('absens.export');

    Route::get('/absensi', function () {
        return Inertia::render('AttendanceHistory');
    })->name('absensi.riwayat');

    Route::post('/absen', [AttendanceController::class, 'store'])->middleware(['auth'])->name('absen.store');
    Route::get('informasi', [InformationController::class, 'index'])->name('information');
});

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('employee', [AdminEmployeeController::class, 'index'])->name('employee');
    Route::post('employee/create', [AdminEmployeeController::class, 'create'])->name('employee.create');

    Route::get('informasi', [AdminInformationController::class, 'index'])->name('informasi');

    Route::get('ip-address', [IpAddressController::class, 'index'])->name('ip address');

    Route::post('ip-address', [IpAddressController::class, 'store'])->name('ip-address.create');

});

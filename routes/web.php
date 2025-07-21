<?php

use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ProfilePhotoController;
use App\Http\Controllers\user\DashboardController;
use App\Http\Controllers\user\InformationController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Route::get('/', function () {
//     return Inertia::render('Welcome');
// })->name('home');

Route::get('/', function () {
    return Redirect::route('profile');
})->middleware(['auth', 'verified'])->name('home');

// Route::get('dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/client-ip', function (Request $request) {
    return response()->json([
        'ip' => $request->ip()
    ]);
})->name('client.ip');

Route::get('/history', [AttendanceController::class, 'history'])
    ->middleware(['auth', 'verified'])
    ->name('history');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';


Route::get('/absensi', function () {
    return Inertia::render('AttendanceHistory');
})->name('absensi.riwayat');

Route::post('/absen', [AttendanceController::class, 'store'])->middleware(['auth']);

Route::post('/absen-masuk', [AttendanceController::class, 'absenMasuk'])
    ->middleware(['auth'])
    ->name('absen.masuk');

Route::post('/absen-pulang', [AttendanceController::class, 'absenPulang'])
    ->middleware(['auth'])
    ->name('absen.pulang');
Route::post('/absen', [AttendanceController::class, 'store'])->name('absen.store');

Route::get('profile', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('profile');
Route::get('informasi', [InformationController::class, 'index'])->middleware(['auth', 'verified'])->name('information');

Route::post('/settings/profile', [ProfilePhotoController::class, 'update'])->name('profile.update');

<?php

use App\Http\Controllers\Admin\IpAddressController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ProfilePhotoController;
use App\Http\Controllers\user\DashboardController;
use App\Http\Controllers\user\InformationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/client-ip', function (Request $request) {
    return response()->json([
        'ip' => $request->getClientIp(),
    ]);
})->name('client.ip');

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/ip-address', [IpAddressController::class, 'index'])->name('admin.ipaddress');
    Route::post('/ip-address', [IpAddressController::class, 'store'])->name('admin.ipaddress.store');
    Route::delete('/ip-address/{id}', [IpAddressController::class, 'destroy'])->name('admin.ipaddress.delete');
});


require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';



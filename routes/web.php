<?php

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
        'ip' => $request->ip(),
    ]);
})->name('client.ip');



require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';



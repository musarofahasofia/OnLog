<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:masuk,pulang',
        ]);

        $user = $request->user();
        $today = Carbon::today();
        $now = now();

        $attendance = Attendance::firstOrNew([
            'user_id' => $user->id,
            'date' => $today,   
        ]);

        if ($request->type === 'masuk' && !$attendance->clock_in) {
            $attendance->clock_in = $now;
            $attendance->status = $now->gt(Carbon::createFromTime(9, 0)) ? 'Terlambat' : 'Hadir';
        }

        if ($request->type === 'pulang' && !$attendance->clock_out) {
            $attendance->clock_out = $now;
        }

        $attendance->save();

        return back()->with('message', 'Absen berhasil!');
    }

    public function history(Request $request)
    {
        $user = $request->user();
        $attendances = Attendance::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->get();

        return Inertia::render('AttendanceHistory', [
            'absens' => $attendances,
        ]);
    }
}
<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $today = Carbon::today();

        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->latest()->first();

        $summary = Attendance::selectRaw("status, COUNT(*) as count")
            ->where('user_id', $user->id)
            ->groupBy('status')
            ->pluck('count', 'status');


        return Inertia::render('admin/Dashboard', [
            'userIp' => $request->ip(),
            'todayDate' => now()->translatedFormat('l, d F Y'),
            'attendanceToday' => $attendance
                ? [
                    'clock_in' => $attendance->clock_in ? Carbon::parse($attendance->clock_in)->format('H:i') : null,
                    'clock_out' => $attendance->clock_out ? Carbon::parse($attendance->clock_out)->format('H:i') : null,
                    'status' => $attendance->status ?? 'Tidak Hadir',
                ]
                : null,
            'summary' => [
                        'presence' => $summary->get('Hadir', 0),
                        'late' => $summary->get('Terlambat', 0),
                        'absence' => $summary->get('Tidak Hadir', 0),
                    ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

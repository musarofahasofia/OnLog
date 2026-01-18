<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceHistory;
use App\Models\Information;
use App\Models\OfficeIp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user  = $request->user();
        $today = Carbon::today()->toDateString();

        $month       = $request->month ?? now()->month;
        $year        = $request->year ?? now()->year;
        $information = Information::get();

        $attendance                   = Attendance::where('user_id', $user->id);
        $todayAttendance              = (clone $attendance)->where('date', $today)->latest()->first();
        $thisMonthAttendanceCount     = (clone $attendance)->whereMonth('date', $month)->whereYear('date', $year)->count();
        $thisMonthLateAttendanceCount = (clone $attendance)->whereMonth('date', $month)->whereYear('date', $year)->where('status', 'late')->count();

        $history = AttendanceHistory::where('user_id', $user->id)
            ->whereMonth('date', $month)
            ->orderBy('created_at', 'asc')
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->created_at)->format('Y-m-d');
            })
            ->sortKeysDesc()
            ->mapWithKeys(function ($items, $date) {
                $label = Carbon::parse($date)
                    ->locale('id')
                    ->translatedFormat('l, d F Y');

                return [$label => $items];
            });

        $ips = OfficeIp::all();

        return Inertia::render('Dashboard', [
            'userIp'          => $request->ip(),
            'allowed_ips'     => $ips,
            'information'     => $information,
            'todayDate'       => now()->locale('id')->translatedFormat('l, d F Y'),
            'attendanceToday' => $todayAttendance
                ? [
                'clock_in'  => $todayAttendance->clock_in ? Carbon::parse($todayAttendance->clock_in)->format('H:i') : null,
                'clock_out' => $todayAttendance->clock_out ? Carbon::parse($todayAttendance->clock_out)->format('H:i') : null,
                'status'    => $todayAttendance->status == 'late' ? 'Terlambat' : null,
            ]
                : null,
            'summary'         => [
                'presence' => $thisMonthAttendanceCount,
                'late'     => $thisMonthLateAttendanceCount,
            ],
            'history'         => $history,
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

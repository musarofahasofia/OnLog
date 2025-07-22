<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Exports\AbsensExport;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:masuk,pulang',
        ]);

        $user  = $request->user();
        $today = Carbon::today();
        $now   = now();

        $attendance = Attendance::firstOrNew([
            'user_id' => $user->id,
            'date'    => $today,
        ]);

        if ($request->type === 'masuk' && ! $attendance->clock_in) {
            $attendance->clock_in = $now;
            $attendance->status   = $now->gt(Carbon::createFromTime(9, 0)) ? 'Terlambat' : 'Hadir';
        }

        if ($request->type === 'pulang' && ! $attendance->clock_out) {
            $attendance->clock_out = $now;
        }

        $attendance->save();

        return back()->with('message', 'Absen berhasil!');
    }

    public function history(Request $request)
    {
        return Inertia::render('AttendanceHistory');
    }

    public function findMany(Request $request)
    {
        $user = $request->user();

        $attendances = Attendance::where('user_id', $user->id)
            ->when($request->start_date && $request->end_date, function ($query) use ($request) {
                $query->whereBetween('date', [$request->start_date, $request->end_date]);
            })
            ->orderBy('date', 'desc')
            ->get();

        return response()->json($attendances);
    }

    public function exportAttendance(Request $request)
    {
        $user  = $request->user();
        $start = $request->start_date;
        $end   = $request->end_date;

        $filename = "absensi_{$start}_sampai_{$end}.xlsx";

        return Excel::download(new AbsensExport($user->id, $start, $end), $filename);
    }
}

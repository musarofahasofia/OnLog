<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceHistory;
use App\Models\RequestOvertime;
use App\Models\UserStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserRequestOvertimeController extends Controller
{
    public function create(Request $request)
    {
        $user  = $request->user();
        $today = Carbon::today()->toDateString();

        $todayAttendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->latest()
            ->first();

        if (! $todayAttendance) {
            return back()->withErrors([
                'note' => 'Anda belum absen masuk hari ini',
            ]);
        }

        try {
            RequestOvertime::create([
                'user_id'       => $user->id,
                'attendance_id' => $todayAttendance->id,
                'start_at'      => $request->start_at,
                'end_at'        => $request->end_at,
                'date'          => $request->date,
                'status'        => 'pending',
                'description'   => $request->desc,
            ]);

            AttendanceHistory::create([
                'user_id'     => $user->id,
                'date'        => $today,
                'type'        => 'overtime',
                'status'      => 'pending',
                'description' => 'Mengajukan Lembur',
            ]);

            UserStatus::where('user_id', $user->id)->update([
                'status'   => 'lembur',
                'end_date' => $today,
            ]);

            return back(); // sukses
        } catch (\Throwable $e) {
            Log::error('Overtime create failed', [
                'user_id' => $user->id,
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return back()->withErrors([
                'note' => 'Internal server bermasalah, silakan coba lagi.',
            ]);
        }
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
}

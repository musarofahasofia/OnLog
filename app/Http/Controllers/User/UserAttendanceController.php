<?php
namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\User;
use App\Models\OfficeIp;
use App\Models\Attendance;
use App\Models\UserStatus;
use Illuminate\Http\Request;
use App\Models\AttendanceHistory;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function attend(Request $request, $action)
    {
        try {
            $officeIps = OfficeIp::pluck('ip_address')->toArray();
            $clientIp  = $request->client_ip ?? $request->ip();
            if (! in_array($clientIp, $officeIps)) {
                throw new \Exception('IP tidak diizinkan');
            }

            $user_id     = Auth::user()->id;
            $currentTime = Carbon::now();
            $status      = $currentTime->gt(Carbon::createFromTime(0, 30, 0)) ? 'late' : 'on_time';

            $ket   = $status == 'late' ? 'Terlambet, a' : 'A';
            $where = [
                'date'    => Carbon::today()->toDateString(),
                'user_id' => $user_id,
            ];

            $attend = Attendance::firstOrNew($where);

            if ($action == 'in') {
                $attend->clock_in = $currentTime->format('H:i:s');
                $attend->status   = $status;
            }

            if ($action == 'out') {
                $attend->clock_out = $currentTime->format('H:i:s');
            }

            $attend->save();
            $desc = $action == 'in' ? "{$ket}bsen Masuk" : "Absen Pulang ";

            $History = AttendanceHistory::create([
                'user_id'     => $user_id,
                'date'        => Carbon::today()->toDateString(),
                'type'        => 'attend',
                'status'      => $action,
                'description' => $desc,
            ]);

            UserStatus::where('user_id', $user_id)
                ->update([
                    'status' => $status == 'late' ? 'Terlambet' : 'Masuk',
                    'end_date' => Carbon::today()->toDateString(),
                ]);

        } catch (\Exception $e) {
            Log::warning('Attend warning: ' . $e->getMessage());

            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Throwable $th) {
            Log::error('Attend error: ' . $th->getMessage(), ['trace' => $th->getTraceAsString()]);

            return response()->json([
                'message' => 'Terjadi kesalahan pada server.',
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function history(Request $request)
    {
        $user = $request->user();

        $month   = $request->month ?? now()->month;
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

        return response()->json([
            'history' => $history,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}

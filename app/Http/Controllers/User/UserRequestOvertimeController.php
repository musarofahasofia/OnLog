<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
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
        try {
            $user        = $request->user();

            $permission = RequestOvertime::create([
                'user_id'     => $user->id,
                'start_at'    => $request->start_at,
                'end_at'      => $request->end_at,
                'date'        => $request->date,
                'status'      => 'pending',
                'description' => $request->desc,
            ]);

            $desc = "Mengajukan Lembur";

            $History = AttendanceHistory::create([
                'user_id'     => $user->id,
                'date'        => Carbon::today()->toDateString(),
                'type'        => 'overtime',
                'status'      => 'pending',
                'description' => $desc,
            ]);

            UserStatus::where('user_id', $user->id)
                ->update([
                    'status'   => 'lembur',
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

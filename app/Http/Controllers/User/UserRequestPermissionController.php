<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AttendanceHistory;
use App\Models\RequestPermission;
use App\Models\UserStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserRequestPermissionController extends Controller
{
    public function create(Request $request)
    {
        try {
            $user        = $request->user();

            $permission = RequestPermission::create([
                'user_id'     => $user->id,
                'start_date'    => $request->start_date,
                'end_date'      => $request->end_date,
                'type'        => $request->type,
                'status'      => 'pending',
                'description' => $request->desc,
            ]);

            $desc = "Mengajukan Izin/Cuti {$request->type}";

            $History = AttendanceHistory::create([
                'user_id'     => $user->id,
                'date'        => Carbon::today()->toDateString(),
                'type'        => 'permission',
                'status'      => 'pending',
                'description' => $desc,
            ]);

            UserStatus::where('user_id', $user->id)
                ->update([
                    'status'   => 'izin',
                    'end_date' => $request->end_date,
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

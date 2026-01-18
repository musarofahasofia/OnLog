<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceHistory;
use App\Models\Information;
use App\Models\OfficeIp;
use App\Models\RequestDuty;
use App\Models\RequestOvertime;
use App\Models\RequestPermission;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user  = $request->user();
        $today = Carbon::today();

        $ips = OfficeIp::all();

        $information     = Information::get();
        $activeUserIds   = $this->getActiveUserIdsToday($today);
        $data_attendance = [
            'permission' => RequestPermission::with('user', 'user.status')
                ->whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)
                ->get(),

            'duty'       => RequestDuty::with('user', 'user.status')
                ->whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)
                ->get(),

            'overtime'   => RequestOvertime::with('user', 'user.status')
                ->whereDate('created_at', $today)
                ->get(),

            'attendance' => Attendance::with('user', 'user.status')
                ->whereDate('created_at', $today)
                ->get(),

            'late'       => Attendance::with('user', 'user.status')
                ->whereDate('created_at', $today)
                ->where('status', 'late')
                ->get(),
            'absen'      => User::with('status')->where('role', 'user')
                ->whereNotIn('id', $activeUserIds)
                ->get(),
        ];

        $attendance = Attendance::whereDate('created_at', $today);

        $summary = [
            'permission' => RequestPermission::whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)
                ->count(),
            'duty'       => RequestDuty::whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)
                ->count(),
            'overtime'   => RequestOvertime::whereDate('created_at', $today)->count(),
            'attendance' => $attendance->count(),
            'late'       => $attendance->where('status', 'late')->count(),
            'absen'      => User::where('role', 'user')
                ->whereNotIn('id', $activeUserIds)
                ->count(),
            'users'      => User::where('role', 'user')->count(),
        ];

        return Inertia::render('admin/Dashboard', [
            'userIp'      => $request->ip(),
            'information' => $information,
            'ips'         => $ips,
            'todayDate'   => now()->translatedFormat('l, d F Y'),
            'data'        => $data_attendance,
            'summary'     => $summary,
        ]);
    }

    private function getActiveUserIdsToday(Carbon $today)
    {
        return collect()
            ->merge(
                RequestPermission::whereDate('start_date', '<=', $today)
                    ->whereDate('end_date', '>=', $today)
                    ->pluck('user_id')
            )
            ->merge(
                RequestDuty::whereDate('start_date', '<=', $today)
                    ->whereDate('end_date', '>=', $today)
                    ->pluck('user_id')
            )
            ->merge(
                Attendance::whereDate('created_at', $today)
                    ->pluck('user_id')
            )
            ->unique()
            ->values();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function employee()
    {
        return Inertia::render('admin/Employee', [

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function approvalList(Request $request)
    {
        $reqPermission = RequestPermission::with('user')->get();
        $reqDuty       = RequestDuty::with('user')->get();
        $reqOvertime   = RequestOvertime::with('user')->get();

        $allRequests = $reqPermission->map(fn($item) => $this->tagRequest($item, 'permission'))
            ->concat($reqDuty->map(fn($item) => $this->tagRequest($item, 'duty')))
            ->concat($reqOvertime->map(fn($item) => $this->tagRequest($item, 'overtime')));

        $groupedApproval = $allRequests->sortByDesc('created_at')
            ->groupBy(function ($item) {
                return Carbon::parse($item->created_at)
                    ->locale('id')
                    ->translatedFormat('l, d F Y');
            });

        return response()->json([
            'list' => $groupedApproval,
        ]);

    }

    private function tagRequest($item, $category)
    {
        $item->category = $category;
        return $item;
    }

    /**
     * Display the specified resource.
     */
    public function approveRequest(Request $request)
    {
        try {
            $id       = $request->id;
            $category = strtolower($request->category);

            $modelMap = [
                'permission' => \App\Models\RequestPermission::class,
                'duty'       => \App\Models\RequestDuty::class,
                'overtime'   => \App\Models\RequestOvertime::class,
            ];

            if (! isset($modelMap[$category])) {
                return back()->with('error', "Kategori '$category' tidak valid.");
            }

            $modelClass = $modelMap[$category];
            $updated    = $modelClass::where('id', $id)
                ->where('status', 'pending')
                ->update([
                    'status'     => 'approved',
                    'updated_at' => now(),
                ]);

            $History = AttendanceHistory::create([
                'user_id'     => $request->user_id,
                'date'        => Carbon::today()->toDateString(),
                'type'        => $category,
                'status'      => 'approved',
                'description' => "Pengajuan permintaan anda telah disetuji ",
            ]);

            if (! $updated) {
                return back()->with('error', 'Data tidak ditemukan atau sudah diproses sebelumnya.');
            }

            return back()->with('success', 'Permintaan berhasil disetujui!');

        } catch (Exception $e) {
            Log::error("Error saat approve {$request->category}: " . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan sistem. Silakan coba beberapa saat lagi.');
        }

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

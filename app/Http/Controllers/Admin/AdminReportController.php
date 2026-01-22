<?php
namespace App\Http\Controllers\Admin;

use App\Exports\DailyAttendanceExport;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\RequestDuty;
use App\Models\RequestPermission;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->start_date
            ? Carbon::parse($request->start_date)->startOfDay()
            : now()->startOfMonth();

        $endDate = $request->end_date
            ? Carbon::parse($request->end_date)->endOfDay()
            : now()->endOfDay();

        $allUsers = User::with('status')
            ->where('role', 'user')
            ->get();

        $attendances = Attendance::with('user.status')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->groupBy(fn($item) => $item->created_at->format('Y-m-d'));

        $permissions = RequestPermission::with('user.status')
            ->whereBetween('start_date', [$startDate, $endDate])
            ->get();

        $duties = RequestDuty::with('user.status')
            ->whereBetween('start_date', [$startDate, $endDate])
            ->get();

        $period = CarbonPeriod::create($startDate, $endDate);
        $days   = array_reverse($period->toArray());

        $data_attendance = [];

        foreach ($days as $day) {
            $dateKey = $day->format('Y-m-d');

            $dailyAttendance = ($attendances[$dateKey] ?? collect())
                ->map(function ($item) {
                    $item->badge_status = 'masuk';
                    $item->description = 'Hadir';
                    if ($item->status == 'late') {$item->badge_status = 'terlambat'; }
                    if ($item->overtime) {$item->badge_status = 'lembur';}
                    if ($item->status == 'late' && $item->overtime) {$item->badge_status = 'terlambat_lembur';}

                    return $item;
                });

            $dailyPermission = $permissions->filter(fn($p) =>
                $day->between($p->start_date, $p->end_date)
            )->values()->map(function ($item) {
                $item->badge_status = 'izin';
                $item->description  = $item->type;
                return $item;
            });

            $dailyDuty = $duties->filter(fn($d) =>
                $day->between($d->start_date, $d->end_date)
            )->values()->map(function ($item) {
                $item->badge_status = 'dinas_luar';
                $item->description  = $item->purpose;
                return $item;
            });

            $presentUserIds = $dailyAttendance->pluck('user_id')
                ->merge($dailyPermission->pluck('user_id'))
                ->merge($dailyDuty->pluck('user_id'))
                ->unique();

            $dailyAbsen = $allUsers->whereNotIn('id', $presentUserIds)->values()->map(function ($user) {
                return (object) [
                    'user'         => $user,
                    'badge_status' => 'none',
                    'description' => 'Tanpa keterangan'
                ];
            });

            $data_attendance[$dateKey] = [
                'formatted_date' => $day->translatedFormat('l, d F Y'),
                'permission'     => $dailyPermission,
                'duty'           => $dailyDuty,
                'attendance'     => $dailyAttendance,
                'absen'          => $dailyAbsen,

                'summary'        => [
                    'permission' => $dailyPermission->count(),
                    'duty'       => $dailyDuty->count(),
                    'attendance' => $dailyAttendance->count(),
                    'absen'      => $dailyAbsen->count(),
                ],
            ];
        }

        return Inertia::render('admin/Report', ['data' => $data_attendance, 'start_date' => $startDate, 'end_date' => $endDate]);
    }

    public function exportReport(Request $request)
    {
        $startDate = $request->start_date
            ? Carbon::parse($request->start_date)->startOfDay()
            : now()->startOfMonth();

        $endDate = $request->end_date
            ? Carbon::parse($request->end_date)->endOfDay()
            : now()->endOfDay();

        $allUsers = User::with('status')
            ->where('role', 'user')
            ->get();

        $attendances = Attendance::with('user.status')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->groupBy(fn($item) => $item->created_at->format('Y-m-d'));

        $permissions = RequestPermission::with('user.status')
            ->whereBetween('start_date', [$startDate, $endDate])
            ->get();

        $duties = RequestDuty::with('user.status')
            ->whereBetween('start_date', [$startDate, $endDate])
            ->get();

        $period = CarbonPeriod::create($startDate, $endDate);
        $days   = array_reverse($period->toArray());

        $data_attendance = [];

        foreach ($days as $day) {
            $dateKey = $day->format('Y-m-d');

            $dailyAttendance = ($attendances[$dateKey] ?? collect())
                ->map(function ($item) {
                    $item->badge_status = 'masuk';
                    if ($item->status == 'late') {$item->badge_status = 'terlambat';}
                    if ($item->overtime) {$item->badge_status = 'lembur';}
                    if ($item->status == 'late' && $item->overtime) {$item->badge_status = 'terlambat_lembur';}
                    return $item;
                });

            $dailyPermission = $permissions->filter(fn($p) =>
                $day->between($p->start_date, $p->end_date)
            )->values()->map(function ($item) {
                $item->badge_status = 'izin';
                $item->description  = $item->type;
                return $item;
            });

            $dailyDuty = $duties->filter(fn($d) =>
                $day->between($d->start_date, $d->end_date)
            )->values()->map(function ($item) {
                $item->badge_status = 'dinas_luar';
                $item->description  = $item->purpose;
                return $item;
            });

            $presentUserIds = $dailyAttendance->pluck('user_id')
                ->merge($dailyPermission->pluck('user_id'))
                ->merge($dailyDuty->pluck('user_id'))
                ->unique();

            $dailyAbsen = $allUsers->whereNotIn('id', $presentUserIds)->values()->map(function ($user) {
                return (object) [
                    'user'         => $user,
                    'badge_status' => 'none',
                ];
            });

            $data_attendance[$dateKey] = [
                'formatted_date' => $day->translatedFormat('l, d F Y'),
                'permission'     => $dailyPermission,
                'duty'           => $dailyDuty,
                'attendance'     => $dailyAttendance,
                'absen'          => $dailyAbsen,

                'summary'        => [
                    'permission' => $dailyPermission->count(),
                    'duty'       => $dailyDuty->count(),
                    'attendance' => $dailyAttendance->count(),
                    'absen'      => $dailyAbsen->count(),
                ],
            ];
        }

        $exportData = [];

        foreach ($data_attendance as $keyDate => $row) {
            $formattedDate = $row['formatted_date']; // "Senin, 01 Januari 2024"

            // A. Masukkan Data Hadir (Attendance)
            foreach ($row['attendance'] as $item) {
                $exportData[] = [
                    'date'        => $formattedDate,
                    'name'        => $item->user->name ?? '-',
                    'status'      => strtoupper(str_replace('_', ' ', $item->badge_status)), // MASUK, TERLAMBAT, dll
                    'clock_in'    => $item->clock_in ?? '-',
                    'clock_out'   => $item->clock_out ?? '-',
                    'description' => 'Hadir',
                ];
            }

            // B. Masukkan Data Izin (Permission)
            foreach ($row['permission'] as $item) {
                $exportData[] = [
                    'date'        => $formattedDate,
                    'name'        => $item->user->name ?? '-',
                    'status'      => 'IZIN',
                    'clock_in'    => '-',
                    'clock_out'   => '-',
                    'description' => $item->description ?? $item->type,
                ];
            }

            // C. Masukkan Data Dinas Luar (Duty)
            foreach ($row['duty'] as $item) {
                $exportData[] = [
                    'date'        => $formattedDate,
                    'name'        => $item->user->name ?? '-',
                    'status'      => 'DINAS LUAR',
                    'clock_in'    => '-',
                    'clock_out'   => '-',
                    'description' => $item->description ?? $item->purpose,
                ];
            }

            // D. Masukkan Data Absen/Alpha
            foreach ($row['absen'] as $item) {
                $exportData[] = [
                    'date'        => $formattedDate,
                    'name'        => $item->user->name ?? '-',
                    'status'      => 'ALPHA', // Atau TANPA KETERANGAN
                    'clock_in'    => '-',
                    'clock_out'   => '-',
                    'description' => 'Tidak hadir tanpa keterangan',
                ];
            }
        }

        // 2. Download file Excel
        $filename = 'Laporan_Absensi_' . $startDate . '_sd_' . $endDate . '.xlsx';

        return Excel::download(new DailyAttendanceExport($exportData), $filename);
    }
}

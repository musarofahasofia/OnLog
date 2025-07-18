<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\User;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first(); // ambil user pertama

        if (!$user) {
            echo "Tidak ada user di database.\n";
            return;
        }

        $dates = [
            ['2025-06-01', '08:55', '17:00', 'Hadir'],
            ['2025-06-02', '09:10', '17:00', 'Terlambat'],
            ['2025-06-03', null, null, 'Tidak Hadir'],
        ];

        foreach ($dates as [$date, $in, $out, $status]) {
            Attendance::create([
                'user_id' => $user->id,
                'date' => $date,
                'clock_in' => $in,
                'clock_out' => $out,
                'status' => $status,
            ]);
        }
    }
}

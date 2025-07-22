<?php

namespace App\Exports;

use App\Models\Attendance;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AbsensExport implements FromCollection, WithHeadings
{
    protected $userId, $start, $end;

    public function __construct($userId, $start, $end)
    {
        $this->userId = $userId;
        $this->start = $start;
        $this->end = $end;
    }

    public function collection(): Collection
    {
        return Attendance::where('user_id', $this->userId)
            ->when($this->start && $this->end, function ($query) {
                $query->whereBetween('date', [$this->start, $this->end]);
            })
            ->orderBy('date', 'desc')
            ->get(['date', 'clock_in', 'clock_out', 'status']);
    }

    public function headings(): array
    {
        return ['Tanggal', 'Clock In', 'Clock Out', 'Status'];
    }
}

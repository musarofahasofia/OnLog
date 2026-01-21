<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DailyAttendanceExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama Karyawan',
            'Status Kehadiran', // Masuk/Izin/Dinas/Alpha
            'Jam Masuk',
            'Jam Pulang',
            'Keterangan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Bold baris pertama (Header)
            1 => ['font' => ['bold' => true]],
        ];
    }
}

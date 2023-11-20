<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithBackgroundColor;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromCollection, WithHeadings, WithColumnWidths, WithStyles
{
    public function collection(): \Illuminate\Database\Eloquent\Collection|Collection
    {
        return DB::table('users')
            ->where('users.role', '!=', 'admin')
            ->select('phone_number', 'email', 'full_name', 'gender', 'address', 'date_of_birth', 'skin_condition', 'note')
            ->get();
    }

    public
    function headings(): array
    {
        return [
            'Số điện thoại',
            'Email',
            'Họ và tên',
            'Giới tính',
            'Địa chỉ',
            'Ngày sinh',
            'Tình trạng da',
            'Ghi chú',
        ];
    }

   public function columnWidths(): array
{
    return [
        'A' => 15,  // Số điện thoại
        'B' => 25,  // Email
        'C' => 20,  // Họ và tên
        'D' => 10,  // Giới tính
        'E' => 30,  // Địa chỉ
        'F' => 15,  // Ngày sinh
        'G' => 35,  // Tình trạng da
        'H' => 30,  // Ghi chú
    ];
}

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EDC06C']]],
        ];
    }
}

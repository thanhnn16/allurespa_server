<?php

namespace App\Imports;

use App\Models\User;
use DateTime;
use Exception;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row): User
    {
        $dateOfBirth = DateTime::createFromFormat('d/m/Y', $row['ngay_sinh']);
        if ($dateOfBirth === false) {
            throw new Exception('Invalid date: ' . $row['ngay_sinh']);
        }
        $dateOfBirth = $dateOfBirth->format('Y-m-d');

        return new User([
            'full_name' => $row['ho_ten'],
            'email' => $row['email'],
            'phone_number' => $row['so_dien_thoai'],
            'gender' => $row['gioi_tinh'],
            'date_of_birth' => $dateOfBirth,
            'address' => $row['dia_chi'],
            'skin_condition' => $row['tinh_trang_da'],
            'note' => $row['ghi_chu'],
            'password' => bcrypt('123456'),
        ]);
    }
}

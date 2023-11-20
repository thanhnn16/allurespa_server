<?php

namespace App\Imports;

use App\Models\User;
use DateTime;
use Exception;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class UsersImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use Importable;

    private array $errors = [];

    /**
     * @throws Exception
     */
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

    public function rules(): array
    {
        return [
            'ho_ten' => 'required',
            'email' => 'nullable|email|unique:users,email',
            'so_dien_thoai' => 'required|unique:users,phone_number',
            'gioi_tinh' => 'nullable|in:1,0',
            'ngay_sinh' => 'nullable|date_format:d/m/Y',
            'dia_chi' => 'nullable',
            'tinh_trang_da' => 'nullable',
            'ghi_chu' => 'nullable',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'ho_ten.required' => 'Họ tên không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại trong hệ thống',
            'so_dien_thoai.required' => 'Số điện thoại không được để trống',
            'so_dien_thoai.unique' => 'Số điện thoại đã tồn tại trong hệ thống',
            'gioi_tinh.in' => 'Giới tính không hợp lệ',
            'ngay_sinh.date_format' => 'Ngày sinh không đúng định dạng',
        ];
    }

    public function onError(Throwable $e): void
    {
        $this->errors[] = $e;
    }

    public function onFailure(Failure ...$failures): void
    {
        foreach ($failures as $failure) {
            $this->errors[] = $failure;
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}

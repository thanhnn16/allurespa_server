<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('pages.user-management', ['users' => $users]);
    }

    public function create()
    {
        return view('pages.user-management-create');
    }

    public function show($user): JsonResponse
    {
        return response()->json($user);
    }

    public function delete($user): JsonResponse
    {
        $user->delete();
        return response()->json(['success' => true]);
    }

    public function export(): BinaryFileResponse
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function import(): RedirectResponse
    {
        $import = new UsersImport;

        try {
            Excel::import($import, request()->file('file'));
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return redirect('/user-management')->with('error', 'Có lỗi xảy ra trong quá trình nhập dữ liệu. Email hoặc số điện thoại đã tồn tại trong hệ thống.');
            }
        } catch (\Exception $e) {
            return redirect('/user-management')->with('error', 'Có lỗi xảy ra trong quá trình nhập dữ liệu. Lỗi chi tiết: ' . $e->getMessage());
        }

        $errors = $import->getErrors();

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->errors()[0];
            }
            return redirect('/user-management')->with('error', implode('<br>', $errorMessages));
        }
        return redirect('/user-management')->with('success', 'Import dữ liệu từ Excel thành công');
    }

    public function template()
    {
        $file = public_path() . "/templates/import_template.xlsx";
        return response()->download($file, 'import_template.xlsx');
    }
}

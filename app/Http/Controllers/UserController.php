<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UserController extends Controller
{
    public function index(): \Illuminate\Foundation\Application|Factory|View|Application
    {
        $users = User::all();

        return view('pages.user-management', ['users' => $users]);
    }


    public function show(User $user): JsonResponse
    {
        return response()->json($user);
    }

    public function delete($id): Application|\Illuminate\Foundation\Application|RedirectResponse|Redirector
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect('/user-management')->with('success', 'Xóa người dùng thành công');
        } else {
            return redirect('/user-management')->with('error', 'Có lỗi xảy ra trong quá trình xóa người dùng');
        }
    }

    /**
     * @throws Exception
     */
    public function export(): BinaryFileResponse
    {
        try {
            return Excel::download(new UsersExport, 'users.xlsx');
        } catch (\PhpOffice\PhpSpreadsheet\Writer\Exception|\PhpOffice\PhpSpreadsheet\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function create(): \Illuminate\Foundation\Application|Factory|View|Application
    {
        return view('pages.user-management-create');
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
        } catch (Exception $e) {
            return redirect('/user-management')->with('error', 'Có lỗi xảy ra trong quá trình nhập dữ liệu. Lỗi chi tiết: ' . $e->getMessage());
        }

        $errors = $import->getErrors();

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return redirect('/user-management')->with('error', implode('<br>', $errorMessages));
        }
        return redirect('/user-management')->with('success', 'Import dữ liệu từ Excel thành công');
    }

    public function store(): JsonResponse
    {
        $data = request()->validate([
            'full_name' => 'required',
            'email' => 'required|unique:users,email',
            'phone_number' => 'required|unique:users,phone_number',
        ]);
        $data['password'] = '123456';

        try {
            if (request()->hasFile('image')) {
                $imageController = new ImageController;
                $imagePath = $imageController->userImageUpload(request());
                $data['image'] = $imagePath;
            } else {
                $data['image'] = '/img/marie.jpg';
            }

            User::create($data);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return response()->json([
                    'error' => 'Email hoặc số điện thoại đã tồn tại trong hệ thống.'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }

        return response()->json([
            'success' => 'Thêm người dùng thành công',
            'data' => $data
        ]);
    }

    public function template(): BinaryFileResponse
    {
        $file = public_path() . "/templates/import_template.xlsx";
        return response()->download($file, 'import_template.xlsx');
    }
}

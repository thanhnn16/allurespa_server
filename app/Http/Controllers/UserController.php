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
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UserController extends Controller
{
    public function index(Request $request): \Illuminate\Foundation\Application|Factory|View|Application
    {
        $usersPerPage = $request->get('usersPerPage', 10);
        $users = User::where('role', 'users')
            ->where(function ($query) use ($request) {
                $query->where('full_name', 'like', '%' . $request->get('search', '') . '%')
                    ->orWhere('phone_number', 'like', '%' . $request->get('search', '') . '%');
            })
            ->paginate($usersPerPage);
        return view('pages.user-management', ['users' => $users]);
    }

    public function show($id): JsonResponse
    {
        $user = User::all()
            ->find($id);
        if ($user) {
            return response()->json([
                'user' => $user,
                'appointment' => $user->appointments
            ]);
        } else {
            return response()->json([
                'error' => 'User not found'
            ], 404);
        }
    }

    public function delete($id): JsonResponse
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return
                response()->json([
                    'success' => 'Xóa người dùng thành công'
                ]);
        } else {
            return
                response()->json([
                    'error' => 'Người dùng không tồn tại'
                ]);
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
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:1,0',
            'address' => 'nullable',
            'skin_condition' => 'nullable',
            'note' => 'nullable',
            'image' => 'nullable|image|max:2048',
        ]);
        $data['password'] = '123456';
        $data['role'] = 'users';

        try {
            if (request()->hasFile('image')) {
                try {
                    $imageController = new ImageController;
                    $imagePath = $imageController->cosmeticImageUpload();
                    $imagePath = explode('/', $imagePath);
                    $imagePath = $imagePath[count($imagePath) - 1];
                    $data['image'] = "./" . $imagePath;
                } catch
                (Exception $e) {
                    return response()->json([
                        'error' => $e->getMessage()
                    ]);
                }
            } else {
                $data['image'] = '/img/marie.jpg';
            }
            User::create($data);
        } catch
        (QueryException $e) {
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

    public function deleteSelected(Request $request): JsonResponse|Red
    {
        $ids = $request->get('selectedIds');
        $errors = [];

        foreach ($ids as $id) {
            $user = User::find($id);
            if (!$user) {
                continue;
            }
            if ($user->appointments()->exists()) {
                $errors[] = 'Không thể xóa người dùng ' . $user->full_name . ' vì người dùng này đã có lịch hẹn';
                continue;
            }
            if ($user->image != '/img/marie.jpg' || $user->image === '') {
                $imageController = new ImageController;
                if (!$imageController->deleteUserAvatar($user->image)) {
                    $errors[] = 'Không thể xóa ảnh của người dùng ' . $user->full_name;
                    continue;
                }
            }
            $user->delete();
        }

        if (!empty($errors)) {
            return response()->json(['error' => $errors]);
        }

        return response()->json(['success' => 'Xóa người dùng thành công']);
    }

    public function template(): BinaryFileResponse
    {
        $file = public_path() . "/templates/import_template.xlsx";
        return response()->download($file, 'import_template.xlsx');
    }

    public function search(Request $request): JsonResponse
    {
        info($request);

        $users = User::where('role', 'users')
            ->where(function ($query) use ($request) {
                $query->where('full_name', 'like', '%' . $request->get('q', '') . '%')
                    ->orWhere('phone_number', 'like', '%' . $request->get('q', '') . '%');
            })->get();

        if (count($users) === 0) {
            return response()->json([
                'error' => 'Không tìm thấy người dùng nào'
            ]);
        }

        return response()->json([
            'users' => $users
        ]);
    }

    public function updateView(Request $request): Factory|\Illuminate\Foundation\Application|View|Application
    {
        $id = $request->get('id');
        $user = User::find($id);
        if (!$user) {
            return redirect('/user-management');
        }
        return view('pages.user-management-update', ['user' => $user]);
    }

    public function updateUser(Request $request): JsonResponse
    {
        $id = $request->input('id');
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'error' => 'Người dùng không tồn tại',
                'request' => $request->all()
            ]);
        }
        $data = $request->validate([
            'full_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone_number' => 'required|unique:users,phone_number,' . $id,
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:1,0',
            'address' => 'nullable',
            'skin_condition' => 'nullable',
            'note' => 'nullable',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imageController = new ImageController;
            if ($user->image != '/img/marie.jpg' && $user->image !== '') {
                $imageController->deleteUserAvatar($user->image);
            }
            $imagePath = $imageController->userImageUpload($request);
            $imagePath = explode('/', $imagePath);
            $imagePath = $imagePath[count($imagePath) - 1];
            $data['image'] = "/uploads/img/users/avatar/" . $imagePath;
        }

        $user->update($data);

        return response()->json([
            'success' => 'Cập nhật thông tin người dùng thành công',
            'data' => $data
        ]);
    }
}

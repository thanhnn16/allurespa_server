<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Models\User;
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

    public function export(): BinaryFileResponse
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function import(): RedirectResponse
    {
        Excel::import(new UsersImport, request()->file('file'));

        return redirect('/user-management');
    }

    public function template()
    {
//        get file from public/templates
        $file = public_path() . "/templates/import_template.xlsx";
//        return response()->download($file);
        return response()->download($file, 'import_template.xlsx');
    }
}

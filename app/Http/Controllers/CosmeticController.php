<?php

namespace App\Http\Controllers;

use App\Models\Cosmetic;
use Illuminate\Contracts\Foundation\Application as ViewApplication;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CosmeticController extends Controller
{
    public function index(Request $request): ViewApplication|Factory|View|Application|JsonResponse
    {
        $cosmeticsPerPage = $request->get('cosmeticsPerPage', 10);

        $cosmetics = Cosmetic::query()
            ->where(function ($query) use ($request) {
                $query->where('cosmetic_name', 'like', '%' . $request->get('search', '') . '%');
            })
            ->join('cosmetic_categories', 'cosmetic_categories.id', '=', 'cosmetics.cosmetic_category_id')
            ->select('cosmetics.*', 'cosmetic_categories.cosmetic_category_name')
            ->paginate($cosmeticsPerPage);

        if ($request->wantsJson()) {
            return response()->json(['cosmetics' => Cosmetic::all()]);
        }

        return view('pages.cosmetic-management', ['cosmetics' => $cosmetics]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string', 'max:191'],
        ]);

        $cosmetic = Cosmetic::create($request->all());

        return response()->json([
            'cosmetic' => $cosmetic
        ]);
    }

    public function show($id): JsonResponse
    {
        $cosmetic = Cosmetic::find($id);

        return response()->json([
            'cosmetic' => $cosmetic
        ]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string', 'max:191'],
        ]);

        $cosmetic = Cosmetic::find($id);
        $cosmetic->update($request->all());

        return response()->json([
            'cosmetic' => $cosmetic
        ]);
    }

    public function destroy($id)
    {
        $cosmetic = Cosmetic::find($id);
        $cosmetic->delete();

        return response()->json([
            'cosmetic' => $cosmetic
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $cosmetics = Cosmetic::query()
            ->where(function ($query) use ($request) {
                $query->where('cosmetic_name', 'like', '%' . $request->get('q', '') . '%');
            })
            ->get();

        if (count($cosmetics) > 0) {
            return response()->json([
                'cosmetics' => $cosmetics
            ]);
        } else {
            return response()->json([
                'error' => 'Không tìm thấy kết quả'
            ]);
        }
    }
}

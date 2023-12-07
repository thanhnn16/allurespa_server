<?php

namespace App\Http\Controllers;

use App\Models\Cosmetic;
use App\Models\CosmeticCategory;
use Exception;
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

    public function store(Request $request): JsonResponse
    {
        $data = request()->validate([
            'cosmetic_name' => ['required', 'string', 'max:191'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string', 'max:191'],
            'cosmetic_category_id' => ['required', 'numeric', 'min:1'],
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'purpose' => 'required|string',
            'ingredients' => 'required|string',
            'how_to_use' => 'required|string',
        ]);
        try {
            if (request()->hasFile('image')) {
                try {
                    $imageController = new ImageController;
                    $imagePath = $imageController->cosmeticImageUpload($request);
                    $imagePath = explode('/', $imagePath);
                    $imagePath = $imagePath[count($imagePath) - 1];
                    $data['image'] = "./uploads/img/cosmetics/" . $imagePath;
                } catch
                (Exception $e) {
                    return response()->json([
                        'error' => $e->getMessage()
                    ]);
                }
            } else {
                $data['image'] = '/img/logo.png';
            }
            $cosmetic = Cosmetic::create($data);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
        return response()->json([
            'cosmetic' => $cosmetic,
            'success' => 'Thêm mới thành công'
        ]);

    }

    public function show($id): JsonResponse
    {
        $cosmetic = Cosmetic::find($id)
            ->join('cosmetic_categories', 'cosmetic_categories.id', '=', 'cosmetics.cosmetic_category_id')
            ->join('invoice_cosmetics', 'invoice_cosmetics.cosmetic_id', '=', 'cosmetics.id')
            ->select('cosmetics.*', 'cosmetic_categories.cosmetic_category_name')
            ->first();

        $totalSold = $cosmetic->invoiceCosmetics->sum('cosmetic_quantity');


        return response()->json([
            'cosmetic' => $cosmetic,
            'total_sold' => $totalSold,
        ]);
    }

    public function getTopCosmetics(): JsonResponse
    {
        $cosmeticInvoiceCount = Cosmetic::query()
            ->join('invoice_cosmetics', 'invoice_cosmetics.cosmetic_id', '=', 'cosmetics.id')
            ->selectRaw('cosmetics.*, count(invoice_cosmetics.cosmetic_id) as cosmetic_invoice_count')
            ->groupBy('cosmetics.id')
            ->orderByDesc('cosmetic_invoice_count')
            ->limit(5)
            ->get();

        return response()->json([
            'cosmetics' => $cosmeticInvoiceCount
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

    public function create(): Factory|Application|View|ViewApplication
    {
        $cosmeticCategories = CosmeticCategory::all();
        return view('pages.cosmetic-management-create', ['cosmeticCategories' => $cosmeticCategories]);

    }

    public function delete($id): JsonResponse
    {
        $cosmetic = Cosmetic::find($id);
        try {
            $cosmetic->delete();
            return response()->json([
                'success' => 'Xóa thành công'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function deleteSelected(Request $request): JsonResponse
    {
        $ids = $request->get('ids');
        $errors = [];
        foreach ($ids as $id) {
            $cosmetic = Cosmetic::find($id);
            if (!$cosmetic) {
                $errors[] = 'Không tìm thấy sản phẩm có id = ' . $id;
                continue;
            }
            if ($cosmetic->image !== '/img/logo.png' || $cosmetic->image === '') {
                $imageController = new ImageController;
                if (!$imageController->deleteCosmeticImage($cosmetic->image)) {
                    $errors[] = 'Không thể xóa ảnh của sản phẩm ' . $cosmetic->cosmetic_name;
                    continue;
                }
            }
            try {
                $cosmetic->delete();
            } catch (Exception $e) {
                $errors[] = $e->getMessage();
            }
        }

        if (!empty($errors)) {
            return response()->json(['error' => $errors]);
        }

        return response()->json(['success' => 'Xóa sản phẩm thành công']);
    }
}

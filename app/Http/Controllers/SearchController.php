<?php

namespace App\Http\Controllers;

use App\Models\Cosmetic;
use App\Models\Treatment;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $treatments = Treatment::query()
            ->where('treatment_name', 'like', '%' . $search . '%')
            ->select('id', 'treatment_name', 'image', 'description')
            ->get();

        $cosmetics = Cosmetic::query()
            ->where('cosmetic_name', 'like', '%' . $search . '%')
            ->select('id', 'cosmetic_name', 'image', 'description')
            ->get();

        $results = collect();

        foreach ($treatments as $treatment) {
            $results->push([
                'id' => $treatment->id,
                'name' => $treatment->treatment_name,
                'image' => $treatment->image,
                'description' => $treatment->description,
                'type' => 'treatment',
            ]);
        }

        foreach ($cosmetics as $cosmetic) {
            $results->push([
                'id' => $cosmetic->id,
                'name' => $cosmetic->cosmetic_name,
                'image' => $cosmetic->image,
                'description' => $cosmetic->description,
                'type' => 'cosmetic',
            ]);
        }

        if ($treatments->isEmpty() && $cosmetics->isEmpty()) {
            return response()->json([
                'message' => 'Không tìm thấy kết quả nào',
            ]);
        }

        return response()->json([
            'results' => $results,
            'message' => 'Tìm thấy ' . count($results) . ' kết quả',
        ]);

    }
}

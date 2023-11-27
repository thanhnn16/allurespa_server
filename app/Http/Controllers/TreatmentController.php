<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application as ViewApplication;

class TreatmentController extends Controller
{
    public function index(Request $request): ViewApplication|Factory|View|Application|JsonResponse
    {
        $treatmentsPerPage = $request->get('treatmentsPerPage', 10);
        $treatments = Treatment::query()
            ->where(function ($query) use ($request) {
                $query->where('treatment_name', 'like', '%' . $request->get('search', '') . '%');
            })
            ->join('treatment_categories', 'treatment_categories.id', '=', 'treatments.treatment_category_id')
            ->select('treatments.*', 'treatment_categories.treatment_category_name')
            ->paginate($treatmentsPerPage);

        if ($request->wantsJson()) {
            return response()->json(['treatments' => Treatment::all()]);
        }

        return view('pages.treatment-management', ['treatments' => $treatments]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string', 'max:191'],
        ]);

        $treatment = Treatment::create($request->all());

        return response()->json([
            'treatment' => $treatment
        ]);
    }

    public function show($id)
    {
        $treatment = Treatment::find($id);

        return response()->json([
            'treatment' => $treatment
        ]);
    }


}

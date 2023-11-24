<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use Illuminate\Http\Request;

class TreatmentController extends Controller
{
    public function index()
    {
        Treatment::all();

        return response()->json([
            'treatments' => Treatment::all()
        ]);
    }

    public function store(Request $request)
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

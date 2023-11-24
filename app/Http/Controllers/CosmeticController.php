<?php

namespace App\Http\Controllers;

use App\Models\Cosmetic;
use Illuminate\Http\Request;

class CosmeticController extends Controller
{
    public function index()
    {
        Cosmetic::all();
        return response()->json([
            'cosmetics' => Cosmetic::all()
        ]);
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

    public function show($id)
    {
        $cosmetic = Cosmetic::find($id);

        return response()->json([
            'cosmetic' => $cosmetic
        ]);
    }

    public function update(Request $request, $id)
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
}

<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        return view('pages.voucher');
    }

    public function check(Request $request): JsonResponse
    {
        $voucher = $request->voucher;

        $voucher = Voucher::where('code', $voucher)->
        where('status', 'active')->
        where('start_date', '<=', date('Y-m-d'))->
        where('end_date', '>=', date('Y-m-d'))->first();

        if ($voucher) {
            $percent = $voucher->discount_percent;
            return response()->json([
                'success' => 'Áp dụng voucher thành công, giảm ' . $percent . '%',
                'voucher' => $voucher
            ]);
        } else {
            return response()->json([
                'error' => 'Voucher không tồn tại'
            ]);
        }
    }
}

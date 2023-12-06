<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceCosmetic;
use App\Models\InvoiceTreatment;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('pages.invoice');
    }

    public function store(Request $request)
    {
        $invoiceData = request()->validate([
            'user_id' => 'required',
            'voucher_id' => 'nullable',
            'note' => 'nullable',
        ]);

        $invoiceData['status'] = 'pending';

        try {
            $invoice = Invoice::create($invoiceData);

            $invoceId = $invoice->id;
            $treatments = $request->treatments;

            foreach ($treatments as $treatment) {
                $invoice->invoiceTreatments()->create([
                    'invoice_id' => $invoceId,
                    'treatment_id' => $treatment['id'],
                    'treatment_quantity' => $treatment['quantity'],
                    'total_amount' => $treatment['price'],
                ]);
            }

            $cosmetics = $request->cosmetics;
            foreach ($cosmetics as $cosmetic) {
                $invoice->invoiceCosmetics()->create([
                    'invoice_id' => $invoceId,
                    'cosmetic_id' => $cosmetic['id'],
                    'cosmetic_quantity' => $cosmetic['quantity'],
                    'total_amount' => $cosmetic['price'],
                ]);
            }

            return response()->json([
                'success' => 'Thêm hóa đơn thành công',
                'invoice' => $invoice
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'error' => 'Thêm hóa đơn thất bại',
                'message' => $e->getMessage(), // Add this line
            ], 500);
        }
    }

    public function management(Request $request): Application|Factory|View|\Illuminate\Contracts\Foundation\Application
    {
        $orderBy = $request->get('orderBy', 'id');
        $order = $request->get('order', 'asc');

        $invoicesPerPage = $request->get('invoicesPerPage', 10);

        $invoices = Invoice::query()
            ->select('invoices.*', 'users.full_name')
            ->join('users', 'invoices.user_id', '=', 'users.id')
            ->where(function ($query) use ($request) {
                $query->where('invoices.id', 'like', '%' . $request->get('search', '') . '%')
                    ->orWhere('users.full_name', 'like', '%' . $request->get('search', '') . '%');
            })
            ->orderBy($orderBy, $order)
            ->paginate($invoicesPerPage);

        return view('pages.invoice-management', ['invoices' => $invoices]);
    }

    public function show($id): JsonResponse
    {
        $invoice = Invoice::query()
            ->where('invoices.id', $id)
            ->select('invoices.*', 'users.full_name')
            ->join('users', 'invoices.user_id', '=', 'users.id')
            ->first();

        $invoiceTreatments = InvoiceTreatment::query()
            ->where('invoice_id', $id)
            ->select('invoice_treatments.*', 'treatments.treatment_name')
            ->join('treatments', 'invoice_treatments.treatment_id', '=', 'treatments.id')
            ->get();

        $invoiceCosmetics = InvoiceCosmetic::query()
            ->where('invoice_id', $id)
            ->select('invoice_cosmetics.*', 'cosmetics.cosmetic_name')
            ->join('cosmetics', 'invoice_cosmetics.cosmetic_id', '=', 'cosmetics.id')
            ->get();

        return response()->json([
            'invoice' => $invoice,
            'invoiceTreatments' => $invoiceTreatments,
            'invoiceCosmetics' => $invoiceCosmetics,
        ]);
    }

    public function deleteSelected(Request $request): JsonResponse
    {
        $ids = $request->ids;
        try {
            InvoiceCosmetic::whereIn('invoice_id', explode(",", $ids))->delete();
            InvoiceTreatment::whereIn('invoice_id', explode(",", $ids))->delete();
            Invoice::whereIn('id', explode(",", $ids))->delete();
            return response()->json([
                'success' => 'Xóa hóa đơn thành công',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Xóa hóa đơn thất bại'
            ], 500);
        }
    }

    public function delete($id): JsonResponse
    {
        try {
            InvoiceCosmetic::where('invoice_id', $id)->delete();
            InvoiceTreatment::where('invoice_id', $id)->delete();
            Invoice::where('id', $id)->delete();
            return response()->json([
                'success' => 'Xóa hóa đơn thành công',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Xóa hóa đơn thất bại'
            ], 500);
        }
    }

    public function printToPDF(Request $request){
        $pdf = PDF::loadHTML($request->get('html'));
        return $pdf->download('invoice.pdf');
    }
}

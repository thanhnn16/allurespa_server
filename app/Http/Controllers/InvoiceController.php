<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceCosmetic;
use App\Models\InvoiceTreatment;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
            'created_at' => 'required',
            'updated_at' => 'required',
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
                    'quantity' => $treatment['quantity'],
                    'price' => $treatment['price'],
                ]);
            }

            $cosmetics = $request->cosmetics;
            foreach ($cosmetics as $cosmetic) {
                $invoice->invoiceCosmetics()->create([
                    'invoice_id' => $invoceId,
                    'cosmetic_id' => $cosmetic['id'],
                    'quantity' => $cosmetic['quantity'],
                    'price' => $cosmetic['price'],
                ]);
            }


            return response()->json([
                'success' => 'Thêm hóa đơn thành công',
                'invoice' => $invoice
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'error' => 'Thêm hóa đơn thất bại'
            ], 500);
        }
    }

    public function management(Request $request)
    {
        $invoicesPerPage = $request->get('invoicesPerPage', 10);
        $invoices = Invoice::query()
            ->where(function ($query) use ($request) {
                $query->where('invoices.id', 'like', '%' . $request->get('search', '') . '%')
                    ->orWhere('invoices.user_id', 'like', '%' . $request->get('search', '') . '%');
            })
            ->select('invoices.*', 'users.full_name')
            ->join('users', 'invoices.user_id', '=', 'users.id')
            ->orderBy('invoices.id', 'desc')
            ->paginate($invoicesPerPage);

        return view('pages.invoice-management', ['invoices' => $invoices]);
    }

    public function show($id)
    {
        $invoice = Invoice::query()
            ->where('invoices.id', $id)
            ->select('invoices.*', 'users.full_name')
            ->join('users', 'invoices.user_id', '=', 'users.id')
            ->first();

        $invoiceTreatments = $invoice->invoiceTreatments;
        $invoiceCosmetics = $invoice->invoiceCosmetics;

        return view('pages.invoice-details', [
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
}

<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        $invoices = Invoice::all();
        $user_count = User::query()->where('role', 'users')->count();
        $total_amount = 0;

        $total_invoice = Invoice::all()->count();

        // Lấy tháng hiện tại và tháng trước
        $currentMonth = Carbon::now()->month;
        $lastMonth = Carbon::now()->subMonth()->month;

        // Lấy năm hiện tại
        $currentYear = Carbon::now()->year;

        // Lấy tổng số tiền của tháng hiện tại
        $currentMonthTotal = Invoice::whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->get()->sum('total_amount');

//        Lấy tổng số user của tháng hiện tại
        $currentMonthUser = User::whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->where('role', 'users')->get()->count();

        // Lấy tổng số đơn hàng của tháng hiện tại
        $currentMonthInvoice = Invoice::whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->get()->count();


        // Lấy tổng số tiền của tháng trước
        $lastMonthTotal = Invoice::whereMonth('created_at', $lastMonth)->whereYear('created_at', $currentYear)->get()->sum('total_amount');
//        Lấy tổng số user của tháng trước
        $lastMonthUser = User::whereMonth('created_at', $lastMonth)->whereYear('created_at', $currentYear)->where('role', 'users')->get()->count();
//        Lấy tổng số đơn hàng của tháng trước
        $lastMonthInvoice = Invoice::whereMonth('created_at', $lastMonth)->whereYear('created_at', $currentYear)->get()->count();

        // So sánh tổng số tiền của tháng hiện tại với tháng trước
        $comparisonAmount = $currentMonthTotal - $lastMonthTotal;
        // Tính phần trăm tăng giảm

        if ($lastMonthTotal != 0) {
            $percentAmount = round($comparisonAmount / $lastMonthTotal * 100, 2);
        } else {
            $percentAmount = 0;
        }

//        So sánh tổng số đơn hàng của tháng hiện tại với tháng trước

        $comparisonInvoice = $currentMonthInvoice - $lastMonthInvoice;

        // Tính phần trăm tăng giảm

        if ($lastMonthInvoice != 0) {
            $percentInvoice = round($comparisonInvoice / $lastMonthInvoice * 100, 2);
        } else {
            $percentInvoice = 0;
        }

        // So sánh tổng số user của tháng hiện tại với tháng trước

        $comparisonUser = $currentMonthUser - $lastMonthUser;
        // Tính phần trăm tăng giảm

        if ($lastMonthUser != 0) {
            $percentUser = round($comparisonUser / $lastMonthUser * 100, 2);
        } else {
            $percentUser = 0;
        }

        $monthlyTotals = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthlyTotals[$month] = Invoice::whereMonth('created_at', $month)
                ->get()
                ->sum(function ($invoice) {
                    return $invoice->total_amount;
                });
        }

        foreach ($invoices as $invoice) {
            $total_amount += $invoice->total_amount;
        }
        return view('pages.dashboard', compact('invoices', 'user_count','total_invoice', 'total_amount', 'monthlyTotals', 'percentAmount', 'percentUser', 'percentInvoice'
        ));
    }

    public function webhook(Request $request)
    {
        if ($request->hasHeader('X-GitHub-Event')) {
            if ($request->header('X-GitHub-Event') == 'pull_request') {
                $payload = $request->all();
                if ($payload['action'] == 'closed') {
                    try {
                        $this->gitPull();
                    } catch (Exception $e) {
                        return response()->json(['error' => $e->getMessage()]);
                    }
                }
            }
        }
        return response()->json(['success' => 'Webhook received']);
    }

    /**
     * @throws Exception
     */
    private function gitPull()
    {
        $process = new Process(['cd /var/www/allurespa_server && git pull']);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new Exception('Git pull failed: ' . $process->getErrorOutput());
        }

        echo $process->getOutput();
    }
}

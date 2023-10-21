<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $report = null;

        if ($request->input('from_date') != null && $request->input('to_date')) {
            $fromDate = $request->input('from_date');
            $toDate = $request->input('to_date');

            $report = Checkout::select(
                'menu_id',
                DB::raw('SUM(order_qty) as total_order_qty')
            )
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->where('order_status', 'D')
                ->groupBy('menu_id')
                ->get();
        }

        // Simpan data input dalam flash session
        $request->flash();

        return view('employee.pages.report.report', [
            'title' => 'Report',
            'reports' => $report
        ]);
    }
}

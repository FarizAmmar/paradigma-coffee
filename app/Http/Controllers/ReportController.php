<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use TCPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $report = null;
        $todate = date('Y-m-d');
        $fromdate = date('Y-m-d', strtotime($todate . ' - 7 days'));

        // dd($request);

        if ($request->has('btn-print')) {
            $fromdate = $request->input('from_date');
            $todate = $request->input('to_date');

            return redirect(route('print', ['fromdate' => $fromdate, 'todate' => $todate]));
        }

        if ($request->input('from_date') != null && $request->input('to_date')) {
            $fromdate = $request->input('from_date');
            $todate = $request->input('to_date');

            if ($fromdate == $todate) {
                $fromdate = date('Y-m-d 00:00:00', strtotime($request->input('from_date')));
                $todate = date('Y-m-d 23:59:59', strtotime($request->input('to_date')));
                $report = Checkout::select(
                    'menu_id',
                    DB::raw('SUM(order_qty) as total_order_qty')
                )
                    ->where(['order_status' => 'D', 'created_at' => $fromdate])
                    ->groupBy('menu_id')
                    ->get();
            } else {
                $report = Checkout::select(
                    'menu_id',
                    DB::raw('SUM(order_qty) as total_order_qty')
                )
                    ->whereBetween('created_at', [$fromdate, $todate])
                    ->where('order_status', 'D')
                    ->groupBy('menu_id')
                    ->get();
            }
        }

        return view('employee.pages.report.report', [
            'title' => 'Report',
            'reports' => $report,
            'todate' => $todate,
            'fromdate' => $fromdate,
        ]);
    }

    public function Report(string $fromdate, string $todate)
    {
        if ($fromdate == $todate) {
            $fromdate = date('Y-m-d 00:00:00', strtotime($fromdate));
            $todate = date('Y-m-d 23:59:59', strtotime($todate));
            $reportData = Checkout::select(
                'menu_id',
                DB::raw('SUM(order_qty) as total_order_qty')
            )
                ->where(['order_status' => 'D', 'created_at' => $fromdate])
                ->groupBy('menu_id')
                ->get();
        } else {
            $reportData = Checkout::select(
                'menu_id',
                DB::raw('SUM(order_qty) as total_order_qty')
            )
                ->whereBetween('created_at', [$fromdate, $todate])
                ->where('order_status', 'D')
                ->groupBy('menu_id')
                ->get();
        }

        $todate = date('d-m-Y', strtotime($todate));
        $fromdate = date('d-m-Y', strtotime($fromdate));

        return view('employee.pages.report.print', [
            'title' => 'Print Report',
            'reportData' => $reportData,
            'todate' => $todate,
            'fromdate' => $fromdate,
        ]);
    }


    public function generatePdf(string $fromdate, string $todate)
    {
        if ($fromdate == $todate) {
            $fromdate = date('Y-m-d 00:00:00', strtotime($fromdate));
            $todate = date('Y-m-d 23:59:59', strtotime($todate));
            $reportData = Checkout::select(
                'menu_id',
                DB::raw('SUM(order_qty) as total_order_qty')
            )
                ->where(['order_status' => 'D', 'created_at' => $fromdate])
                ->groupBy('menu_id')
                ->get();
        } else {
            $reportData = Checkout::select(
                'menu_id',
                DB::raw('SUM(order_qty) as total_order_qty')
            )
                ->whereBetween('created_at', [$fromdate, $todate])
                ->where('order_status', 'D')
                ->groupBy('menu_id')
                ->get();
        }

        $no = 1;
        $totalIncome = 0;

        // Inisialisasi instance TCPDF
        $pdf = new TCPDF();

        // Set judul dokumen
        $pdf->SetTitle('Print Report');

        // Tambahkan halaman
        $pdf->AddPage();

        // Buat konten PDF

        $content = '<h1>Paradigma Coffee</h1>';
        $content .= '<table>';
        $content .= '<tr><td style="width: 100px;">From Date</td><td style="width: 5px;">:</td><td style="padding-left: 10px;">' . $fromdate . '</td></tr>';
        $content .= '<tr><td style="width: 100px;">To Date</td><td style="width: 5px;">:</td><td style="padding-left: 10px;">' . $todate . '</td></tr>';
        $content .= '</table>';
        $content .= '<table border="1">';
        $content .= '<thead>';
        $content .= '<tr>';
        $content .= '<td>No</td>';
        $content .= '<td>Menu Name</td>';
        $content .= '<td>Order Quantity</td>';
        $content .= '<td>Total Price</td>';
        $content .= '</tr>';
        $content .= '</thead>';
        $content .= '<tbody>';

        foreach ($reportData as $item) {
            $content .= '<tr>';
            $content .= '<td>' . $no++ . '</td>';
            $content .= '<td>' . $item->menu->name . '</td>';
            $content .= '<td>' . $item->total_order_qty . '</td>';

            $itemPrice = $item->menu->amount * $item->total_order_qty;
            $totalIncome += $itemPrice;

            $content .= '<td>Rp. ' . $itemPrice . '</td>';
            $content .= '</tr>';
        }

        // Total
        $content .= '<tr><td colspan="3" style="text-align: right"><b>Total Income :</b></td><td>Rp. ' . $totalIncome . '</td></tr>';
        $content .= '</tbody>';
        $content .= '</table>';

        // Tulis konten ke PDF
        $pdf->writeHTML($content, true, false, true, false, '');

        // Output PDF ke browser atau simpan sebagai file
        $pdf->Output('report.pdf', 'D');
    }
}

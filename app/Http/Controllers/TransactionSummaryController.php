<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Transaction_summary;
use Illuminate\Http\Request;

class TransactionSummaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $total_keuntungan = DB::table('transactions')->sum('netto_total');
        $total_customers = DB::table('transactions')->sum('customer_id');
        $total_products = Product::count();
        $total_categories = Category::count();
        $total_transactions = Transaction::count();

        // menghitung total keuntungan hari ini
        $currentDate = Carbon::today();
        $totalProfit_today = Transaction::whereDate('transaction_datetime', $currentDate)
            ->sum('netto_total');

        // menghitung total keuntungan kemarin
        $yesterday = Carbon::yesterday();
        $totalProfit_yesterday = Transaction::whereDate('transaction_datetime', $yesterday)
            ->sum('netto_total');

        // menghitung total keuntungan bulan lalu
        $lastMonth = Carbon::now()->subMonth();
        $totalProfit_month = Transaction::whereYear('transaction_datetime', $lastMonth->year)
            ->whereMonth('transaction_datetime', $lastMonth->month)
            ->sum('netto_total');

        // menghitung total keuntungan tahun lalu
        $lastYear = Carbon::now()->subYear();

        $totalProfit_lastYear = Transaction::whereYear('transaction_datetime', $lastYear->year)
            ->sum('netto_total');

        
        // Grafik Penerbit
        $data_donut = Product::select(DB::raw("COUNT(category_id) as total"))->groupBy('category_id')->orderBy('category_id', 'asc')->pluck('total');
        $label_donut = Category::orderBy('categories.id', 'asc')->join('products', 'products.category_id', '=', 'categories.id')->groupBy('categories.name')->pluck('categories.name');
        
        // Bar Grafik Transaction
        $label_bar = ['transaksi'];
        $data_bar = [];

        // settingan bar Transaction
        foreach ($label_bar as $key => $value) {
            $data_bar[$key]['label'] = $label_bar[$key];
            $data_bar[$key]['backgroundColor'] = $key == 1 ? 'rgba[60,141,188,0.9]' : 'rgba(210, 214, 222, 1)';
            $data_month = [];

            foreach (range(1,12) as $month) {
                if($key == 0) {
                    $data_month[] = Transaction::select(DB::raw("COUNT(*) as total"))->whereMonth('created_at', $month)->first()->total;
                } else {
                    $data_month[] = Transaction::select(DB::raw("COUNT(*) as total"))->whereMonth('updated_at', $month)->first()->total;

                }
            }
            $data_bar[$key]['data'] = $data_month;
        }

        return view('admin.transaction_summary.index', 
            compact(
            'total_keuntungan',
            'total_customers',
            'total_products', 
            'total_categories',
            'total_transactions',
            'totalProfit_today',
            'totalProfit_yesterday',
            'totalProfit_month',
            'totalProfit_lastYear',
            'data_donut',
            'label_donut',
            'data_bar'
        ));
    }

    public function api() {
        $transaction_summaries = Transaction_summary::all();
        $datatables = datatables()->of($transaction_summaries)->addIndexColumn();

        return $datatables->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction_summary $transaction_summary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction_summary $transaction_summary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction_summary $transaction_summary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction_summary $transaction_summary)
    {
        //
    }
}

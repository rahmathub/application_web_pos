<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total_customers = Customer::count();
        $total_products = Product::count();
        $total_categories = Category::count();
        $total_transactions = Transaction::count();

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

        return view('admin.dashboard.home', 
            compact('total_customers',
            'total_products', 
            'total_categories',
            'total_transactions',
            'data_donut',
            'label_donut',
            'data_bar'
        ));
    }
}

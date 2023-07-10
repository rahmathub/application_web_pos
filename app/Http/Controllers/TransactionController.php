<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Customer;
use App\Models\Product;
use App\Models\TransactionDetail;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_customer = Customer::all();

        return view('admin.transaction.index', Compact('data_customer'));
    }

    public function api() {
        $transactions = Transaction::with('customer')->get();
        $datatables = datatables()->of($transactions)->addIndexColumn();

        return $datatables->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $costumerName = Customer::all();
        $products = Product::all();
        return view ('admin.transaction.create', compact('costumerName', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;
        // Validasi input
        $validator = Validator::make($request->all(), [
            'customer_id' => ['required', 'numeric'],
            'transaction_datetime' => ['required', 'date'],
            'product_id' => ['required', 'array'],
            'product_id.*' => ['required', 'numeric'],
            'quantity' => ['required', 'array'],
            'quantity.*' => ['required', 'numeric'],
            'price_total' => ['required', 'numeric'],
            'accept_customer_money' => ['required', 'numeric'],
            'change_customer_money' => ['required', 'numeric'],
        ]);
    
        // Jika validasi gagal, kembalikan respon dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Mendapatkan input dari request
        $customer_id = $request->input('customer_id');
        $transaction_datetime = $request->input('transaction_datetime');
        $product_ids = $request->input('product_id');
        $quantities = $request->input('quantity');
        $price_total = $request->input('price_total');
        $accept_customer_money = $request->input('accept_customer_money');
        $change_customer_money = $request->input('change_customer_money');
    
        // Membuat transaksi baru
        $transaction = new Transaction();
        $transaction->customer_id = $customer_id;
        $transaction->transaction_datetime = date('Y-m-d H:i:s', strtotime($transaction_datetime));
        $transaction->price_total = $price_total;
        $transaction->accept_customer_money = $accept_customer_money;
        $transaction->change_customer_money = $change_customer_money;
    
        // Menghitung total produk
        $product_total = count($product_ids);
        $transaction->product_total = $product_total;
    
        $transaction->save();
    
        // Menyimpan detail transaksi untuk setiap produk yang dipilih
        foreach ($product_ids as $index => $product_id) {
            if (isset($quantities[$index])) {
                $quantity = $quantities[$index];
    
                // Membuat detail transaksi baru
                $transactionDetail = new TransactionDetail();
                $transactionDetail->transaction_id = $transaction->id;
                $transactionDetail->product_id = $product_id;
                $transactionDetail->qty = $quantity;
    
                // Mendapatkan harga produk dari database
                $product = Product::find($product_id);
                $transactionDetail->price = $product->price_deal;
    
                try {
                    // Simpan data transaksi detail ke database
                    $transactionDetail->save();
    
                    // Mengurangi stok produk berdasarkan jumlah yang dibeli
                    $product->stock -= $quantity;
                    $product->save();
                } catch (QueryException $e) {
                    // Menangkap error saat create data
                    // Cetak pesan error untuk membantu mendiagnosis masalah
                    dd($e->getMessage());
                }
            }
        }
    
        // Redirect atau lakukan tindakan selanjutnya
        return redirect()->route('transactions.index');
    }
    
    
    
    
    
    
    
    
    // return $request;
    
    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}

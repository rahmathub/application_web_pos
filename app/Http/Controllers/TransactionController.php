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
    
        // Menghitung total produk
        $product_total = count($product_ids);
    
        // Menghitung netto_total berdasarkan bahan yang diberikan
        $netto_total = 0;
    
        foreach ($product_ids as $index => $product_id) {
            if (isset($quantities[$index])) {
                $quantity = $quantities[$index];
    
                // Mendapatkan harga produk dari database berdasarkan product_id
                $product = Product::find($product_id);
                $product_netto = $product->netto;
    
                // Menghitung netto_total berdasarkan netto produk dan kuantitas
                $netto_total += $product_netto * $quantity;
            }
        }
    
        // Membuat transaksi baru
        $transaction = new Transaction();
        $transaction->customer_id = $customer_id;
        $transaction->transaction_datetime = date('Y-m-d H:i:s', strtotime($transaction_datetime));
        $transaction->price_total = $price_total;
        $transaction->accept_customer_money = $accept_customer_money;
        $transaction->change_customer_money = $change_customer_money;
        $transaction->product_total = $product_total;
        $transaction->netto_total = $netto_total;
    
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
        $customer = Customer::all();
        $transactionDetail = TransactionDetail::all();
        $product = Product::all();

        return view('admin.transaction.detail', compact('transaction', 'customer', 'transactionDetail', 'product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        $costumerName = Customer::all();
        $products = Product::all();
        $transactionDetail = TransactionDetail::all();
        $selectedProductIds = $transaction->transactionDetails->pluck('product_id')->toArray();
    
        return view('admin.transaction.edit', compact('costumerName', 'products', 'transaction', 'transactionDetail', 'selectedProductIds'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
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
    
        // Mengupdate data transaksi
        $transaction->customer_id = $customer_id;
        $transaction->transaction_datetime = date('Y-m-d H:i:s', strtotime($transaction_datetime));
        $transaction->price_total = $price_total;
        $transaction->accept_customer_money = $accept_customer_money;
        $transaction->change_customer_money = $change_customer_money;
    
        // Menghitung total produk
        $product_total = count($product_ids);
        $transaction->product_total = $product_total;
    
        // Menghitung netto_total berdasarkan bahan yang diberikan
        $netto_total = 0;
    
        // Loop untuk mengupdate stok produk berdasarkan perubahan kuantitas
        foreach ($product_ids as $index => $product_id) {
            if (isset($quantities[$index])) {
                $quantity = $quantities[$index];

                // Mendapatkan harga produk dari database berdasarkan product_id
                $product = Product::find($product_id);
                $product_netto = $product->netto;

                // Menghitung netto_total berdasarkan netto produk dan kuantitas
                $netto_total += $product_netto * $quantity;

                // Membuat detail transaksi baru atau mengupdate jika sudah ada
                $transactionDetail = $transaction->transactionDetails()->updateOrCreate(
                    ['product_id' => $product_id],
                    ['qty' => $quantity, 'price' => $product->price_deal]
                );

                // Mengurangi stok produk jika ada perubahan kuantitas
                if ($transactionDetail->wasRecentlyCreated || $transactionDetail->qty != $quantity) {
                    // Mengembalikan stok sebelumnya jika ada perubahan kuantitas
                    if (!$transactionDetail->wasRecentlyCreated) {
                        $product->stock += $transactionDetail->qty;
                    }

                    // Mengurangi stok berdasarkan kuantitas baru
                    $product->stock -= $quantity;
                    $product->save();
                }
            }
        }

    
        // Menghapus detail transaksi yang tidak ada dalam perubahan kuantitas
        $existingProductIds = $transaction->transactionDetails()->pluck('product_id')->toArray();
        $productIdsToDelete = array_diff($existingProductIds, $product_ids);
        if (!empty($productIdsToDelete)) {
            foreach ($productIdsToDelete as $productId) {
                $transactionDetail = $transaction->transactionDetails()->where('product_id', $productId)->first();
                $product = Product::find($productId);
                $product->stock += $transactionDetail->qty; // Menambahkan stok yang dihapus
                $product->save();
            }
            $transaction->transactionDetails()->whereIn('product_id', $productIdsToDelete)->delete();
        }
    
        // Mengupdate netto_total pada transaksi
        $transaction->netto_total = $netto_total;
    
        // Simpan perubahan data transaksi
        $transaction->save();
    
        // Redirect atau lakukan tindakan selanjutnya
        return redirect()->route('transactions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        // Hapus data pada tabel transaction_details berdasarkan transaction_id
        $transaction->transactionDetails()->delete();

        // Hapus data pada tabel transactions
        $transaction->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}

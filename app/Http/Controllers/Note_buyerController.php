<?php

namespace App\Http\Controllers;

use App\Models\Note_buyer;
use App\Models\Product;
use App\Models\Note_buyer_detail;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Note_buyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.supplier.index');
    }

    // membuat api database Note_buyers sesuai id
    public function api($store_id)
    {
        $noteBuyers = Note_buyer::where('store_id', $store_id)->get();
        $datatables = datatables()->of($noteBuyers)->addIndexColumn();
    
        return $datatables->make(true);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create(Store $store)
    {
        $notebuyer = Note_buyer::all();
        $products = Product::all();
        return view('admin.supplier.create', compact('notebuyer', 'store', 'products'));
        // disengaja compact tulis store karena untuk membawa id dari table store
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $request;

        // Validasi input
        $validatedData = $request->validate([
            'store_id' => ['required', 'numeric'],
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:7000', // Hanya menerima file gambar dengan ukuran maksimal 7MB
            'tanggal_pembelian' => ['required', 'date_format:"m/d/Y g:i A"'],
            'product_id' => ['required', 'array'],
            'product_id.*' => ['required', 'numeric'],
            'quantity' => ['required', 'array'],
            'quantity.*' => ['required', 'numeric'],
            'total_buyer' => ['required', 'numeric'],
        ]);

        // Mendapatkan data input kecuali _token
        $data = $request->except('_token');

        // Upload file gambar
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = 'nota_supplier'; // Ubah sesuai dengan lokasi folder yang diinginkan
            $file->move(public_path($path), $filename);
            $data['photo'] = $path . '/' . $filename;
        }

        // Konversi tanggal_pembelian ke format Y-m-d H:i:s
        $tanggalPembelian = Carbon::createFromFormat('m/d/Y g:i A', $data['tanggal_pembelian'])->format('Y-m-d H:i:s');

        // Buat data di tabel note_buyers
        $noteBuyer = Note_buyer::create([
            'store_id' => $data['store_id'],
            'photo' => $data['photo'],
            'tanggal_pembelian' => $tanggalPembelian,
            'total_buyer' => $data['total_buyer'],
        ]);

        // Dapatkan product_id dan quantity dari input form
        $product_ids = $request->input('product_id');
        $quantities = $request->input('quantity');

        // Simpan data di tabel note_buyer_details dan perbarui stock produk
        foreach ($product_ids as $index => $product_id) {
            $quantity = $quantities[$index];

            // Buat data di tabel note_buyer_details
            Note_buyer_detail::create([
                'note_buyer_id' => $noteBuyer->id,
                'product_id' => $product_id,
                'qty' => $quantity,
            ]);

            // Perbarui stock produk di tabel products
            $product = Product::find($product_id);
            $product->stock += $quantity;
            $product->save();
        }

        // Redirect ke halaman sebelumnya dengan ID store
        $store_id = $data['store_id'];
        // return redirect()->route('store.show', ['store' => $store_id])->with('success', 'Note Buyer created successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Note_buyer $note_buyer)
    {
        $buyerdetail = Note_buyer_detail::all();
        $product = Product::all();
    
        return view('admin.supplier.detail2', compact('note_buyer', 'buyerdetail', 'product'));
        // disengaja compact tulis store karena untuk membawa id dari table store
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note_buyer $note_buyer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note_buyer $note_buyer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note_buyer $note_buyer)
    {
        //
    }
}

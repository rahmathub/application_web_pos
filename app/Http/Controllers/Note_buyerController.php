<?php

namespace App\Http\Controllers;

use App\Models\Note_buyer;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Note_buyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        // Validasi input
        $validator = Validator::make($request->all(), [
            'store_id' => ['required', 'numeric'],
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:5000', // Hanya menerima file gambar dengan ukuran maksimal 5MB
            'tanggal_pembelian' => ['required', 'date'],
            'product_id' => ['required', 'array'],
            'product_id.*' => ['required', 'numeric'],
            'quantity' => ['required', 'array'],
            'quantity.*' => ['required', 'numeric'],
            'price_total' => ['required', 'numeric'],
        ]);


        return $request;
    }

    /**
     * Display the specified resource.
     */
    public function show(Note_buyer $note_buyer)
    {
        //
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

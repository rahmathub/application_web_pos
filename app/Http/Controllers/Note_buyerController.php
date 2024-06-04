<?php

namespace App\Http\Controllers;

use App\Models\Note_buyer;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

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
    public function create()
    {
        $notebuyer = Note_buyer::all();
        $store = Store::all();
        $products = Product::all();
        return view ('admin.supplier.create', compact('notebuyer', 'store', 'products'));
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

<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Product;
use App\Models\Note_buyer;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    // security
    public function __construct() {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.supplier.index');
    }

    // untuk table supaya muncul
    public function api()
    {
        $store = Store::all();
        $datatables = datatables()->of($store)->addIndexColumn();
    
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
        $this->validate($request, [
            'name_store' => ['required', 'string', 'max:50'],
            'number_phone' => ['required', 'string', 'max:12'],
            'address_store' => ['required', 'string', 'max:80'],
            'description' => ['required', 'string', 'max:100'],
        ]);
        Store::create($request->all());

        return response()->json(['message' => 'Customer Create successfully'], 200);
        return redirect()->route('supplier.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Store $store)
    {
        $store = Store::all();
        $storedetail = Note_buyer::all();
        $product = Product::all();

        return view('admin.supplier.detail', compact('store', 'storedetail', 'product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Store $store)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Store $store)
    {
        //
        $this->validate($request,[
            'name_store' => ['required', 'string', 'max:50'],
            'number_phone' => ['required', 'string', 'max:12'],
            'address_store' => ['required', 'string', 'max:80'],
            'description' => ['required', 'string', 'max:100'],
        ]);

        $store->update($request->all());

        return response()->json(['message' => 'Store update successfully'], 200);
        return redirect()->route('supplier.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Store $store)
    {
        //
        $store->delete();
    }
}

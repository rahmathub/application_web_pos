<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.customer.index');
    }

    /**
     * Show the form for creating a new resource.
     */

    public function api()
    {
        $costumer = Customer::all();
        $datatables = datatables()->of($costumer)->addIndexColumn();
    
        return $datatables->make(true);
    }

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
            'name' => ['required', 'string', 'max:25'],
            'email' => ['required', 'string', 'max:20'],
            'phone' => ['required', 'string', 'max:15'],
            'address' => ['required', 'string', 'max:40'],
        ]);
        Customer::create($request->all());

        return response()->json(['message' => 'Customer Create successfully'], 200);
        return redirect()->route('customer.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Customer $customer)
    {
        $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:15'],
            'phone' => ['required', 'string', 'max:12'],
            'address' => ['required', 'string', 'max:30'],
        ]);

        $customer->update($request->all());

        return response()->json(['message' => 'Customer update successfully'], 200);
        return redirect()->route('customer.index');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Customer $customer)
    {
        $customer->delete();
    }
}

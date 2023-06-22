<?php

namespace App\Http\Controllers;

use App\Models\Transaction_summary;
use Illuminate\Http\Request;

class TransactionSummaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.transaction_summary.index');
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

@extends('layouts.admin')
@section('header', 'Detail Transaction')

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Theme style -->
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Transaction Detail</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="form-group row">
            <label class="col-lg-2">Customer :</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" value="{{ $transaction->customer->name }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-lg-2">No Handphone :</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" value="{{ $transaction->customer->phone }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-lg-2">Address :</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" value="{{ $transaction->customer->address }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-lg-2">Transaction Products :</label>
            <div class="col-lg-6">
                <ul>
                    @foreach($transaction->transactionDetails as $detail)
                        <li class="bg-info color-palette p-2 mt-2">
                            {{ $detail->product->name }} ( Jumlah Barang : {{ $detail->qty }} )
                        </li> 
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-4">
                <ul>
                    @foreach($transaction->transactionDetails as $detail)
                        <li class="bg-primary disabled color-palette p-2 mt-2">
                            ( Harga setiap Barang : Rp {{ number_format($detail->product->price_deal, 0, ',', '.') }} )
                        </li> 
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-lg-2">Total Pembayaran :</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" value="Rp {{ number_format($transaction->price_total, 0, ',', '.') }}" readonly>
            </div>
        </div>
    </div>
</div>
@endsection
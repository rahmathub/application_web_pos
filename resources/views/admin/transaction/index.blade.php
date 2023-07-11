@extends('layouts.admin')
@section('header', 'Transaction')

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Theme style -->
@endsection

@section('content')
    <div id="controller">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10">
                                <a href="{{ url('transactions/create') }}"  class="btn btn-sm btn-primary pull-right">
                                    Create New Transaction
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="card-body">
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">No</th>
                                    <th class="text-center">Nama Pembeli</th>
                                    <th class="text-center">Tanggal Pembelian</th>
                                    <th class="text-center">Total Produk</th>
                                    <th class="text-center">Total Pembayaran</th>
                                    <th class="text-center">Uang Diterima</th>
                                    <th class="text-center">Uang Kembalian</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <!-- Modal show foto -->
                    <div class="modal fade" id="photoModal" tabindex="-1" role="dialog" aria-labelledby="photoModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <img src="" alt="Product Photo" class="img-fluid" id="modalPhoto">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div>
    </div>
@endsection

@section('js')
    <!-- DataTables & Plugins -->
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- Page specific script -->
    <script type="text/javascript">
        var controller = new Vue({
            el: '#app',
            data: {
                apiUrl: '{{ url('api/transactions') }}',
                table: null,
            },
            methods: {
                formatCurrency(amount) {
                    var formatter = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0,
                    });

                    return formatter.format(amount);
                },
                deleteData(event, id) {
                    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                        const _this = this;
                        axios.delete('{{ url('transactions') }}/' + id)
                            .then((response) => {
                                alert('Data berhasil di hapus');
                                _this.reloadData();
                            })
                            .catch((error) => {
                                console.error(error);
                                alert('Terjadi kesalahan saat menghapus data');
                            });
                    }
                },
                reloadData() {
                    this.table.clear().draw();
                    this.table.ajax.reload();
                },
            },
            mounted() {
                var _this = this;

                var columns = [
                    { data: 'DT_RowIndex', className: 'text-center' },
                    { data: 'customer.name', className: 'text-center' },
                    { data: 'transaction_datetime', className: 'text-center' },
                    { data: 'product_total', className: 'text-center' },
                    { 
                        data: 'price_total', 
                        className: 'text-center',
                        render: function (data, type, row) {
                            return _this.formatCurrency(data);
                        }
                    },
                    { 
                        data: 'accept_customer_money', 
                        className: 'text-center',
                        render: function (data, type, row) {
                            return _this.formatCurrency(data);
                        }
                    },
                    { 
                        data: 'change_customer_money', 
                        className: 'text-center',
                        render: function (data, type, row) {
                            return _this.formatCurrency(data);
                        }
                    },
                    // Bagian render tombol delete
                    {
                        render: function(index, row, data, meta){
                            var detailUrl = '{{ url('transactions') }}' + '/' + data.id;
                            var editUrl = '{{ url('transactions') }}' + '/' + data.id + '/edit';
                            return '\
                            <a href="' + detailUrl + '" class="btn btn-primary btn-sm mr-1">Detail</a>' +
                            '<a href="' + editUrl + '" class="btn btn-warning btn-sm mr-1">Edit</a>' +
                            '<a class="btn btn-danger btn-sm" onclick="controller.deleteData(event, '+data.id+')">Delete</a>';
                        },
                        orderable: false,
                        width: '200px',
                        class: 'text-center'
                    }
                ];

                this.table = $('#datatable').DataTable({
                    ajax: {
                        url: this.apiUrl,
                        type: 'GET',
                        dataSrc: function (response) {
                            return response.data;
                        },
                    },
                    columns: columns,
                    initComplete: function () {
                        _this.table = this.api();
                    }
                });
            }
        });
    </script>


@endsection

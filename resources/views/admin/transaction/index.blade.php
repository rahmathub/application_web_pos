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
                                <a href="{{ url('transactions/create') }}" class="btn btn-sm btn-primary pull-right">
                                    Create New Transaction
                                </a>
                            </div>

                            <div class="col-md-2">
                                <select name="tanggalTransaksiFilter" id="tanggalTransaksiFilter" class="form-control"
                                    v-model="selectedTanggalTransaksi" @change="filterByTanggalTransaksi">
                                    <option value="">Filter Tanggal Transaksi</option>
                                    <option value="1">Hari ini</option>
                                    <option value="7">7 Hari Terakhir</option>
                                    <option value="30">30 Hari Terakhir</option>
                                </select>
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
                                    <th class="text-center">Total Jenis Produk</th>
                                    <th class="text-center">Total Pembayaran</th>
                                    <th class="text-center">Total Keuntungan</th>
                                    <th class="text-center">Uang Diterima</th>
                                    <th class="text-center">Uang Kembalian</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <!-- Modal show foto -->
                    <div class="modal fade" id="photoModal" tabindex="-1" role="dialog" aria-labelledby="photoModalLabel"
                        aria-hidden="true">
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
                var table;

                var controller = new Vue({
                    el: '#controller',
                    data: {
                        table: null,
                        selectedTanggalTransaksi: ''
                    },
                    mounted() {
                        this.initDataTable();
                    },
                    methods: {
                        initDataTable() {
                            var self = this; // Menyimpan referensi objek Vue

                            if ($.fn.DataTable.isDataTable('#datatable')) {
                                this.table = $('#datatable').DataTable();
                            } else {
                                this.table = $('#datatable').DataTable({
                                    processing: true,
                                    serverSide: true,
                                    ajax: {
                                        url: '{{ url('api/transactions') }}',
                                        data: function(d) {
                                            // Menambahkan parameter filter tanggal saat melakukan request AJAX
                                            d.tanggalTransaksiFilter = self.selectedTanggalTransaksi;
                                        }
                                    },
                                    columns: [{
                                            data: 'DT_RowIndex',
                                            className: 'text-center',
                                            orderable: false,
                                            searchable: false
                                        },
                                        {
                                            data: 'customer.name',
                                            className: 'text-center',
                                            searchable: true
                                        },
                                        {
                                            data: 'transaction_datetime',
                                            className: 'text-center',
                                            searchable: true
                                        },
                                        {
                                            data: 'product_total',
                                            className: 'text-center',
                                            searchable: true
                                        },
                                        {
                                            data: 'price_total',
                                            className: 'text-center',
                                            render: function(data) {
                                                return self.formatCurrency(data);
                                            },
                                            searchable: true
                                        },
                                        {
                                            data: 'netto_total',
                                            className: 'text-center',
                                            render: function(data) {
                                                return self.formatCurrency(data);
                                            },
                                            searchable: true
                                        },
                                        {
                                            data: 'accept_customer_money',
                                            className: 'text-center',
                                            render: function(data) {
                                                return self.formatCurrency(data);
                                            },
                                            searchable: true
                                        },
                                        {
                                            data: 'change_customer_money',
                                            className: 'text-center',
                                            render: function(data) {
                                                return self.formatCurrency(data);
                                            },
                                            searchable: true
                                        },
                                        {
                                            data: null,
                                            className: 'text-center',
                                            render: function(data, type, row) {
                                                var detailUrl = '{{ url('transactions') }}/' + data.id;
                                                var editUrl = '{{ url('transactions') }}/' + data.id +
                                                    '/edit';
                                                var deleteUrl = '{{ url('transactions') }}/' + data.id;

                                                return '<a href="' + detailUrl +
                                                    '" class="btn btn-primary btn-sm mr-1 mb-1">Detail</a>' +
                                                    '<a href="' + editUrl +
                                                    '" class="btn btn-warning btn-sm mr-1 mb-1">Edit</a>' +
                                                    '<button class="btn btn-danger btn-sm mb-1 mr-1" onclick="controller.deleteData(' +
                                                    data.id + ')">Hapus</button>';
                                            },
                                            searchable: false
                                        }
                                    ]
                                });
                            }
                        },
                        deleteData(id) {
                            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                                axios.delete('{{ url('transactions') }}/' + id)
                                    .then(response => {
                                        this.table.ajax.reload();
                                    })
                                    .catch(error => {
                                        console.log(error);
                                    });
                            }
                        },
                        filterByTanggalTransaksi() {
                            let selectedValue = this.selectedTanggalTransaksi;

                            if (selectedValue === "") {
                                this.table.ajax.url('{{ url('api/transactions') }}').load();
                            } else if (selectedValue === "1") {
                                let today = new Date().toISOString().split('T')[0];
                                this.table.ajax.url('{{ url('api/transactions') }}?tanggalTransaksiFilter=' + today)
                            .load();
                            } else if (selectedValue === "7") {
                                let lastWeek = new Date();
                                lastWeek.setDate(lastWeek.getDate() -
                                6); // Ubah menjadi 6 untuk mendapatkan 7 hari terakhir
                                let formattedDate = lastWeek.toISOString().split('T')[0];
                                this.table.ajax.url('{{ url('api/transactions') }}?tanggalTransaksiFilter=' +
                                    formattedDate).load();
                            } else if (selectedValue === "30") {
                                let last30Days = new Date();
                                last30Days.setDate(last30Days.getDate() -
                                29); // Ubah menjadi 29 untuk mendapatkan 30 hari terakhir
                                let formattedDate = last30Days.toISOString().split('T')[0];
                                this.table.ajax.url('{{ url('api/transactions') }}?tanggalTransaksiFilter=' +
                                    formattedDate).load();
                            } else {
                                this.table.ajax.url('{{ url('api/transactions') }}').load();
                            }
                        },
                        formatCurrency(amount) {
                            var formatter = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0,
                            });
                            return formatter.format(amount);
                        }
                    }
                });
            </script>


        @endsection

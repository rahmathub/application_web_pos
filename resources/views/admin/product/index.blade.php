@extends('layouts.admin')
@section('header', 'Produk')

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
                                <a href="{{ url('products/create') }}"  class="btn btn-sm btn-primary pull-right">
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
                                <th class="text-center">Nama Produk</th>
                                <th class="text-center">Kategori</th>
                                <th class="text-center">Harga Modal</th>
                                <th class="text-center">Harga Penjualan</th>
                                <th class="text-center">Keuntungan</th>
                                <th class="text-center">Stok Barang</th>
                                <th class="text-center">Foto</th>
                                <th class="text-center">Deskripsi Produk</th>
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
    // DataTables  & Plugins 
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


    <!-- Page specific script pada datatables di atas -->
    <script type="text/javascript">
        $(function () {
            $("#datatable").DataTable();
        });
    </script>
    
    <script type="text/javascript">
        var actionUrl = '{{ url('products') }}';
        var apiUrl = '{{ url('api/products') }}';
    
        var columns = [
            { data: 'DT_RowIndex', className: 'text-center' },
            { data: 'name', name: 'name', className: 'text-center' },
            { data: 'category.name', className: 'text-center' },
            { 
                data: 'price_start', 
                className: 'text-center',
                render: function (data, type, row) {
                    return formatCurrency(data);
                }
            },
            { 
                data: 'price_deal', 
                className: 'text-center',
                render: function (data, type, row) {
                    return formatCurrency(data);
                }
            },
            { 
                data: 'netto', 
                className: 'text-center',
                render: function (data, type, row) {
                    return formatCurrency(data);
                }
            },
            { data: 'stock', className: 'text-center' },
            {
                data: 'photo',
                render: function (data, type, row) {
                    return (
                        '<a href="javascript:void(0)" onclick="controller.openPhotoModal(\'' +
                        '{{ asset('/') }}' +
                        data +
                        '\')">' +
                        '<img src="' +
                        '{{ asset('/') }}' +
                        data +
                        '" alt="Product Photo" class="img-thumbnail" style="width: 150px; height: auto;">' +
                        '</a>'
                    );
                },
                orderable: false,
                className: 'text-center',
            },
            { data: 'description', className: 'text-center' },
            {
                render: function (data, type, row, meta) {
                    var editUrl = '{{ url('products') }}' + '/' + row.id + '/edit';
                    return '<a href="' + editUrl + '" class="btn btn-warning btn-sm mr-1">Edit</a>' +
                        '<a class="btn btn-danger btn-sm" onclick="controller.deleteData(event, ' + row.id + ')">Delete</a>';
                },
                orderable: false,
                width: '200px',
                className: 'text-center',
            },
        ];
    
        function formatCurrency(amount) {
            var formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            });
    
            return formatter.format(amount);
        }
    
        var controller = new Vue({
            el: '#controller',
            data: {
                datas: [],
                data: {},
                actionUrl: actionUrl,
                apiUrl: apiUrl,
                table: null,
            },
            mounted: function () {
                this.datatable();
            },
            methods: {
                datatable() {
                    const _this = this;
                    _this.table = $('#datatable').DataTable({
                        ajax: {
                            url: _this.apiUrl,
                            type: 'GET',
                            dataSrc: function (response) {
                                return response.data;
                            },
                        },
                        columns: columns,
                    }).on('xhr', function () {
                        _this.datas = _this.table.ajax.json().data;
                        _this.table.draw();
                    });
                },
                openPhotoModal(photoUrl) {
                    $('#modalPhoto').attr('src', photoUrl);
                    $('#photoModal').modal('show');
                },
                deleteData(event, id) {
                    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                        const _this = this;
                        axios
                            .delete(_this.actionUrl + '/' + id)
                            .then((response) => {
                                alert('Data has been removed');
                                _this.table
                                    .row($(event.target).closest('tr'))
                                    .remove()
                                    .draw(false);
                            })
                            .catch((error) => {
                                console.error(error);
                                alert('An error occurred while deleting data');
                            });
                    }
                },
            },
        });
    </script>
    
    
    


@endsection

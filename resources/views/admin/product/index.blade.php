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
                            <a href="#" @click="addData" class="btn btn-sm btn-primary pull-right" >
                                Create New Produk
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
                            <th class="text-center">Harga Modal</th>
                            <th class="text-center">Harga Penjualan</th>
                            <th class="text-center">Stok Barang</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                
                {{-- Modal Product --}}
                <div class="modal fade" id="modal-default">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="post" :action="actionUrl" autocomplete="off" @submit="submitForm($event, data.id)">
                                <div class="modal-header">
                                    <h4 class="modal-title">Produk Anda</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @csrf

                                    <input type="hidden" name="_method" value="PUT" v-if="editStatus">
                                    
                                    <div class="form-group">
                                        <label>Nama Produk</label>
                                        <input type="text" class="form-control" name="name_product" :value="data.name_product" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Harga Produk</label>
                                        <input type="number" class="form-control" name="price" :value="data.price" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Stok</label>
                                        <input type="number" class="form-control" name="qty" :value="data.qty" required>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </div>
        </div>
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

    
    <!-- Page specific script pada datatables di atas-->
    <script type="text/javascript">
        $(function () {
            $("#datatable").DataTable();
            });
    </script>

    <script type="text/javascript">
        var actionUrl = '{{ url('products') }}';
        var apiUrl = '{{ url('api/products') }}';

        var columns =  [
            {data: 'DT_RowIndex', class: 'text-center', orderable: false},
            {data: 'name_product', class: 'text-center', orderable: false},
            {data: 'price', class: 'text-center', orderable: false},
            {data: 'price_deal', class: 'text-center', orderable: false},
            {data: 'qty', class: 'text-center', orderable: false},
            {render: function(index, row, data, meta){
                return '\
                <a href="#" class="btn btn-warning btn-sm" onclick="controller.editData(event, '+meta.row+')">\
                    Edit\
                </a>\
                <a class="btn btn-danger btn-sm" onclick="controller.deleteData(event, '+data.id+')">\
                    Delete\
                </a>';
            }, orderable: false, width: '200px', class: 'text-center'},
        ];
    </script>

    <script type="text/javascript">
        var controller = new Vue({
            el: '#controller',
            data: {
                datas: [],
                data: {},
                actionUrl,
                apiUrl,
                editStatus: false,
                errorMessage: '', // Menambah properti untuk menampilkan pesan kesalahan
            },
            mounted: function() {
                this.datatable();
            },
            methods: {
                datatable() {
                    const _this = this;
                    _this.table = $('#datatable').DataTable({
                        ajax: {
                            url: _this.apiUrl,
                            type: 'GET',
                        },
                        columns
                    }).on('xhr', function() {
                        _this.datas = _this.table.ajax.json().data;
                    });
                },
                addData() {
                    this.data = {};
                    this.editStatus = false;
                    $('#modal-default').modal();
                },
                editData(event, row) {
                    this.data = this.datas[row];
                    this.editStatus = true;
                    $('#modal-default').modal();
                },
                deleteData(event, id) {
                    if (confirm("Are you sure?")) {
                        const _this = this;
                        $(event.target).parents('tr').remove();
                        axios
                            .post(this.actionUrl + '/' + id, { _method: 'DELETE' })
                            .then(response => {
                                alert('Data has been removed');
                            })
                            .catch(error => {
                                console.error(error);
                                alert('An error occurred while deleting the data.');
                            });
                    }
                },
                submitForm(event, id) {
                    event.preventDefault();
                    const _this = this;
                    var actionUrl = ! this.editStatus ? this.actionUrl : this.actionUrl+'/'+id;
                    axios.post(actionUrl, new FormData($(event.target)[0])).then(response => {
                        $('#modal-default').modal('hide');
                        _this.table.ajax.reload();
                    });
                },
            }
        });
    </script>
@endsection

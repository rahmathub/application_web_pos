@extends('layouts.admin')
@section('header', 'Supplier Store')

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
                            <div class="col-md-8">
                                <a href="#" @click="addData()" class="btn btn-sm btn-primary pull-right">
                                    Create Supplier 
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">No</th>
                                    <th style="width: 10px">Nama Supplier</th>
                                    <th class="text-center">No Hp</th>
                                    <th class="text-center">Alamat</th>
                                    <th class="text-center">Keterangan Toko Supplier</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    {{-- Modal Create Supplier --}}
                    <div class="modal fade" id="modal-default">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" :action="actionUrl" autocomplete="off" @submit="submitForm($event, data.id)">
                                    <div class="modal-header">
                                        <h4 class="modal-title">New Supplier</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @csrf
                                        <input type="hidden" name="_method" :value="editStatus ? 'PUT' : 'POST'">
                                        <div class="form-group">
                                            <label>Name Supplier</label>
                                            <input type="text" class="form-control" name="name" v-model="data.name" required maxlength="30">
                                            <small class="text-danger" v-if="data.name && data.name.length > 28">
                                                Nama tidak boleh melebihi 30 karakter.
                                            </small>
                                        </div>
                                        <div class="form-group">
                                            <label>Nomor Hp</label>
                                            <input type="number" class="form-control" name="phone" v-model="data.phone" required maxlength="15">
                                            <small class="text-danger" v-if="data.phone && data.phone.toString().length > 12">
                                                Nomor hape tidak boleh melebihi 12 karakter.
                                            </small>
                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" class="form-control" name="address" v-model="data.address" required maxlength="40">
                                            <small class="text-danger" v-if="data.address && data.address.length > 60">
                                                Alamat tidak boleh melebihi 58 karakter.
                                            </small>
                                        </div>
                                        <div class="form-group">
                                            <label>Keterangan Toko Supplier</label>
                                            <input type="text" class="form-control" name="email" v-model="data.email" required maxlength="30">
                                            <small class="text-danger" v-if="data.email && data.email.length > 28">
                                                Email tidak boleh melebih 30 karakter.
                                            </small>
                                        </div>
                                    </div>
                                    
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Buat</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
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

    <script type="text/javascript">
        $(function () {
            $("#datatable").DataTable();
            });
    </script>

    <script type="text/javascript">
        var actionUrl = '{{ url('store') }}';
        var apiUrl = '{{ url('api/store') }}';

        var columns =  [
            {data: 'DT_RowIndex', class: 'text-center', orderable: false},
            {data: 'name_store', class: 'text-center', orderable: false},
            {data: 'number_phone', class: 'text-center', orderable: false},
            {data: 'address_store', class: 'text-center', orderable: false},
            {data: 'description', class: 'text-center', orderable: false},
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

                // ambil di script di bawah paste disini
                addData(){
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
                    if (confirm("Are you sure ?")) {
                        $(event.target).parents('tr').remove();
                        axios.post(this.actionUrl+'/'+id, {_method: 'DELETE'}).then(response => {
                            alert('Data has been removed');
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


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
                                <th class="text-center">Stok Barang</th>
                                <th class="text-center">Foto</th>
                                <th class="text-center">Deskripsi Produk</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    
                    {{-- Modal Product --}}
                    <div class="modal fade" id="modal-default">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" :action="actionUrl" enctype="multipart/form-data" autocomplete="off" @submit="submitForm($event, data.id)">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Edit Produk</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @csrf
                            
                                        <input type="hidden" name="_method" v-if="editProductId" value="PUT">
                            
                                        <div class="form-group">
                                            <label>Nama Produk</label>
                                            <input type="text" class="form-control" name="name_product" v-model="data.name" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Kategori</label>
                                            <select class="form-control" style="width: 100%;" name="category_id" v-model="data.category_id" required>
                                                @foreach($data_category as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Harga Modal</label>
                                            <input type="number" class="form-control" name="price_start" v-model="data.price_start" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Harga Penjualan</label>
                                            <input type="number" class="form-control" name="price_deal" v-model="data.price_deal" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Stok Barang</label>
                                            <input type="number" class="form-control" name="stock" v-model="data.stock" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="photo">Foto Produk</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="photo" class="custom-file-input" id="photo" @change="handleFileChange" />
                                                    <label class="custom-file-label">Choose file</label>
                                                </div>
                                            </div>
                                            <img :src="photoUrl" alt="Product Photo" class="img-thumbnail mt-2" style="width: 150px; height: auto;" v-if="photoUrl">
                                        </div>
                                        <div class="form-group">
                                            <label>Deskripsi Produk</label>
                                            <input type="text" class="form-control" name="description" v-model="data.description" required>
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
            {data: 'DT_RowIndex', class: 'text-center', orderable: false},
            {data: 'name', className: 'text-center', orderable: false},
            {data: 'category.name', className: 'text-center', orderable: false},
            {data: 'price_start', className: 'text-center', orderable: false},
            {data: 'price_deal', className: 'text-center', orderable: false},
            {data: 'stock', className: 'text-center', orderable: false},
            {
                data: 'photo',
                render: function(data, type, row) {
                    return '<img src="' + data + '" alt="Product Photo" class="img-thumbnail" style="width: 150px; height: auto;">';
                },
                orderable: false,
                className: 'text-center'
            },
            {data: 'description', className: 'text-center', orderable: false},
            {
                render: function(data, type, row, meta) {
                    return '\
                    <a href="#" class="btn btn-warning btn-sm" onclick="controller.editData(event, ' + meta.row + ')">\
                        Edit\
                    </a>\
                    <a class="btn btn-danger btn-sm" onclick="controller.deleteData(event, ' + row.id + ')">\
                        Delete\
                    </a>';
                },
                orderable: false,
                width: '200px',
                className: 'text-center'
            },
        ];
    </script>


    <script type="text/javascript">
        var controller = new Vue({
            el: '#controller',
            data: {
                datas: [],
                data: {},
                actionUrl: actionUrl,
                apiUrl: apiUrl,
                editProductId: null,
                photoUrl: null,
                deletePhoto: false,
                data_category: [],
            },
            mounted: function() {
                this.datatable();
                this.loadCategories();
            },
            methods: {
                datatable() {
                    const _this = this;
                    _this.table = $('#datatable').DataTable({
                        ajax: {
                            url: _this.apiUrl,
                            type: 'GET',
                        },
                        columns: columns
                    }).on('xhr', function() {
                        _this.datas = _this.table.ajax.json().data;
                    });
                },
                loadCategories() {
                    const _this = this;
                    axios.get('{{ url('categories') }}')
                        .then(response => {
                            _this.data_category = response.data;
                        })
                        .catch(error => {
                            console.error(error);
                            alert('Failed to fetch categories');
                        });
                },
                editData(event, row) {
                    if (row >= 0 && row < this.datas.length) {
                        this.data = Object.assign({}, this.datas[row]);
                        this.editProductId = this.data.id;

                        if (this.data.photo) {
                            this.photoUrl = this.data.photo;
                        }
                    } else {
                        this.resetForm();
                    }
                    $('#modal-default').modal();
                },
                deleteData(event, id) {
                    if (confirm("Are you sure?")) {
                        const _this = this;
                        const rowData = this.datas.find(data => data.id === id);

                        axios
                            .post(_this.actionUrl + '/' + id, { _method: 'DELETE' })
                            .then(response => {
                                alert('Data has been removed');
                                _this.table
                                    .row($(event.target).closest('tr'))
                                    .remove()
                                    .draw(false);
                            })
                            .catch(error => {
                                console.error(error);
                                alert('An error occurred while deleting data');
                            });
                    }
                },
                submitForm(event, id) {
                    event.preventDefault();
                    const _this = this;
                    var actionUrl = !_this.editProductId ? _this.actionUrl : _this.actionUrl + '/' + id;

                    const formData = new FormData(event.target);
                    const photoInput = document.getElementById('photo');

                    if (_this.editProductId) {
                        formData.append('_method', 'PUT');
                    }

                    if (_this.deletePhoto) {
                        formData.append('delete_photo', '1');
                    }

                    if (photoInput && photoInput.files.length > 0) {
                        const photoFile = photoInput.files[0];
                        formData.append('photo', photoFile);
                    }

                    axios.post(actionUrl, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(response => {
                        if (_this.editProductId) {
                            const editedDataIndex = _this.datas.findIndex(data => data.id === _this.editProductId);
                            if (editedDataIndex !== -1) {
                                Object.assign(_this.datas[editedDataIndex], response.data);
                                _this.table.row(editedDataIndex).data(response.data).draw(false);

                                // Update photo URL
                                if (response.data.photo) {
                                    _this.photoUrl = response.data.photo;
                                } else {
                                    _this.photoUrl = null;
                                }
                            }
                        } else {
                            _this.datas.push(response.data);
                            _this.table.row.add(response.data).draw(false);
                        }
                        _this.resetForm();
                        $('#modal-default').modal('hide');
                        alert('Data has been saved');
                        _this.reloadTableData(); // Reload data after successful update
                    })
                },
                reloadTableData() {
                    const _this = this;
                    _this.table.ajax.reload(null, false); // Reload data without resetting the current paging
                },
                handleFileChange(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.data.photo = file;
                        this.photoUrl = URL.createObjectURL(file);
                        this.deletePhoto = false;
                    } else {
                        if (this.deletePhoto) {
                            this.data.photo = null;
                            this.photoUrl = null;
                        } else if (!this.data.photo && this.product && this.product.photo) {
                            this.photoUrl = this.product.photo;
                        }
                    }
                },
                resetForm() {
                    this.data = {};
                    this.editProductId = null;
                    this.photoUrl = null;
                    this.deletePhoto = false;
                    const photoInput = document.getElementById('photo');
                    if (photoInput) {
                        photoInput.value = '';
                    }
                }
            }
        });
    </script>

@endsection

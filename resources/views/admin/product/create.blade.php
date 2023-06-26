@extends('layouts.admin')
@section('header', 'Create Produk')

@section('css')
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bs-stepper/css/bs-stepper.min.css') }}">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/dropzone/min/dropzone.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    
    <style>
        #imagePreview img {
            width: 300px;
        }
    </style>
    @endsection


@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Create New Product</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form method="POST" action="{{ url('products') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-2">
                        <label>Nama Produk</label>
                    </div>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="name" required>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-2">
                        <label>Kategori Produk</label>
                    </div>
                    <div class="col-lg-10">
                        <select name="category_id" class="form-control select2" style="width: 100%;" required>
                            {{-- looping data member --}}
                            @foreach($data_category as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col lg-2">
                        <label>Harga Modal</label>
                    </div>
                    <div class="col-lg-10">
                        <input type="number" class="form-control" name="price_start" required>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col lg-2">
                        <label>Harga Penjualan</label>
                    </div>
                    <div class="col-lg-10">
                        <input type="number" class="form-control" name="price_deal" required>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col lg-2">
                        <label>Stok Barang</label>
                    </div>
                    <div class="col-lg-10">
                        <input type="number" class="form-control" name="stock" required>
                    </div>
                </div>

                

                <div class="form-group row">
                    <div class="col-lg-2">
                        <label for="exampleInputFile">Foto Produk</label>
                    </div>
                    <div class="col-lg-10">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="exampleInputFile" name="photo" onchange="displayFileName(); displayPreviewImage(this);">
                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text">Upload</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-2">
                    </div>
                    <div class="col-lg-10">
                        <div id="imagePreview"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-2">
                        <label>Deskripsi Produk</label>
                    </div>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="description" required>
                    </div>
                </div>
            </div>


            <!-- /.card-body -->
        
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
        
    </div>
    <!-- /.card -->
@endsection

@section('js')
    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="{{ asset('assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- bootstrap color picker -->
    <script src="{{ asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Bootstrap Switch -->
    <script src="{{ asset('assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
    <!-- BS-Stepper -->
    <script src="{{ asset('assets/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
    <!-- dropzonejs -->
    <script src="{{ asset('assets/plugins/dropzone/min/dropzone.min.js') }}"></script>


    <script>
        function displayFileName() {
            var input = document.getElementById("exampleInputFile");
            var fileName = input.files[0].name;
            var label = document.querySelector(".custom-file-label");
            label.textContent = fileName;
        }
        
        function displayPreviewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var imagePreview = document.getElementById("imagePreview");
                    imagePreview.innerHTML = '<img src="' + e.target.result + '" class="img-thumbnail" style="max-width: 200px;">';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        </script>
@endsection
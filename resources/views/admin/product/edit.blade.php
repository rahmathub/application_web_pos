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
            <h3 class="card-title">Edit Product</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form method="POST" action="{{ url('products/' . $product->id) }}" enctype="multipart/form-data">
            @csrf
            {{ method_field('PUT') }}
            <div class="card-body">
                <div class="form-group row">
                    <label for="name" class="col-lg-2 col-form-label">Nama Produk</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="name" value="{{ $product->name }}" required>
                    </div>
                </div>
        
                <div class="form-group row">
                    <label for="category_id" class="col-lg-2 col-form-label">Kategori Produk</label>
                    <div class="col-lg-10">
                        <select name="category_id" id="category_id" class="form-control select2" style="width: 100%;" required>
                            @foreach($data_category as $category)
                                <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
        
                <div class="form-group row">
                    <label for="price_start" class="col-lg-2 col-form-label">Harga Modal</label>
                    <div class="col-lg-10">
                        <input type="number" class="form-control" id="price_start" name="price_start" value="{{ $product->price_start }}" required>
                    </div>
                </div>
        
                <div class="form-group row">
                    <label for="price_deal" class="col-lg-2 col-form-label">Harga Penjualan</label>
                    <div class="col-lg-10">
                        <input type="number" class="form-control" id="price_deal" name="price_deal" value="{{ $product->price_deal }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="price_deal" class="col-lg-2 col-form-label">Keuntungan</label>
                    <div class="col-lg-10">
                        <input type="number" class="form-control" id="netto" name="netto" value="{{ $product->netto }}" readonly required>
                    </div>
                </div>
        
                <div class="form-group row">
                    <label for="stock" class="col-lg-2 col-form-label">Stok Barang</label>
                    <div class="col-lg-10">
                        <input type="number" class="form-control" id="stock" name="stock" value="{{ $product->stock }}" required>
                    </div>
                </div>
        
                <div class="form-group row">
                    <label for="photo" class="col-lg-2 col-form-label">Foto Produk</label>
                    <div class="col-lg-10">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="photo" name="photo" onchange="displayFileName(); displayPreviewImage(this);">
                                <label class="custom-file-label" for="photo">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-lg-2 col-form-label">Foto Produk Saat Ini</label>
                    <div class="col-lg-10">
                        @if ($product->photo)
                            <img src="{{ asset('/' . $product->photo) }}" class="img-thumbnail" style="max-width: 200px;" alt="Product Photo" id="currentPhoto">
                        @else
                            <p>No photo available</p>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="description" class="col-lg-2 col-form-label">Deskripsi Produk</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" id="description" name="description" value="{{ $product->description }}" required>
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
            var input = document.getElementById("photo");
            var fileName = input.files[0].name;
            var label = document.querySelector(".custom-file-label");
            label.textContent = fileName;

            // Reset current photo preview
            var currentPhoto = document.getElementById("currentPhoto");
            currentPhoto.src = "{{ asset('/' . $product->photo) }}";
        }

        function displayPreviewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var currentPhoto = document.getElementById("currentPhoto");
                    currentPhoto.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Ambil elemen input harga modal, harga penjualan, dan netto
        var priceStartInput = document.getElementById('price_start');
        var priceDealInput = document.getElementById('price_deal');
        var nettoInput = document.getElementById('netto');

        // Tambahkan event listener pada input harga modal dan harga penjualan
        priceStartInput.addEventListener('input', updateNetto);
        priceDealInput.addEventListener('input', updateNetto);

        // Fungsi untuk memperbarui nilai input keuntungan
        function updateNetto() {
            var priceStart = parseFloat(priceStartInput.value);
            var priceDeal = parseFloat(priceDealInput.value);
            
            var netto = priceDeal - priceStart;

            // // Pastikan nilai keuntungan tetap positif
            // if (netto < 0) {
            //     netto = 0;
            // }

            // Update nilai input keuntungan
            nettoInput.value = netto;
        }

    </script>
@endsection
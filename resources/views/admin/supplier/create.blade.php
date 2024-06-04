@extends('layouts.admin')
@section('header', 'Buat Transaksi Produk')

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
    

@endsection


@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Create New Product</h3>
        </div>
        <form method="POST" action="{{ url('transactions') }}">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-3">
                        <label for="exampleInputFile">Foto Produk</label>
                    </div>
                    <div class="col-lg-9">
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
                    <div class="col-lg-3">
                        <label>Tanggal dan waktu pembelian :</label>
                    </div>
                    <div class="col-lg-9">
                        <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                            <input name="transaction_datetime" type="text" class="form-control datetimepicker-input" data-target="#reservationdatetime"/>
                            <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="form-group row">
                    <div class="col-lg-3">
                        <label>Pilih Produk</label>
                    </div>
                    <div class="col-lg-9">
                        <select name="product_id[]" class="select2" multiple="multiple" data-placeholder="Pilih Pembeli" style="width: 100%;" required onchange="showQuantityInputs(this)">
                            @foreach($products as $index => $product)
                                <option value="{{ $index + 1 }}" data-price="{{ $product->price_deal }}">{{ $product->name }}</option>
                            @endforeach
                        </select>                        
                    </div>
                </div>
                
                {{-- atur kuantiti produk --}}
                <div id="quantityInputs" style="display: none;">
                    @foreach($products as $index => $product)
                        <div class="form-group row quantity-input" id="quantityInput{{ $index + 1 }}">
                            <div class="form-group row">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-6">
                                    <label>Atur Kuantitas {{ $product->name }} (Rp {{ number_format($product->price_deal, 0, ',', '.') }}) : Sisa Stok : {{ $product->stock }}</label>
                                </div>
                                <div class="col-lg-3">
                                    <input type="number" class="form-control" name="quantity[]" onchange="updateTotalPayment()" min="0">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                
        
                <div class="form-group row">
                    <div class="col-lg-3">
                        <label>Total Pembayaran</label>
                    </div>
                    <div class="col-lg-9">
                        <input type="number" class="form-control" id="totalPayment" name="price_total" required readonly>
                    </div>
                </div>
        
                <div class="form-group row">
                    <div class="col lg-3">
                        <label>Uang diterima</label>
                    </div>
                    <div class="col-lg-9">
                        <input type="number" class="form-control" id="receivedMoney" name="accept_customer_money" required>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-lg-3">
                        <label>Uang kembalian</label>
                    </div>
                    <div class="col-lg-9">
                        <input type="text" class="form-control" id="changeMoney" required readonly>
                        <input type="hidden" id="changeMoneyHidden" name="change_customer_money">
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
        $(function ()   {

        $(document).ready(function() {
            $('.select2').select2();
        });

        //Date and time picker
        $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });
        
    })

    // fitur quantiti ditampilkan setiap produk dipilih
    function showQuantityInputs(selectElement) {
        var selectedOptions = selectElement.selectedOptions;
        var quantityInputsContainer = document.getElementById('quantityInputs');

        // Setel ulang tampilan dan status nonaktif dari semua baris input kuantitas
        var quantityInputs = document.getElementsByClassName('quantity-input');
        for (var i = 0; i < quantityInputs.length; i++) {
            quantityInputs[i].style.display = 'none';
            var quantityInput = quantityInputs[i].querySelector('input[name^="quantity"]');
            quantityInput.disabled = true;
        }

        // Tampilkan baris input kuantitas untuk setiap produk yang dipilih dan aktifkan input
        for (var i = 0; i < selectedOptions.length; i++) {
            var productId = selectedOptions[i].value;
            var quantityInputRow = document.getElementById('quantityInput' + productId);
            if (quantityInputRow) {
                quantityInputRow.style.display = 'block';
                var quantityInput = quantityInputRow.querySelector('input[name^="quantity"]');
                quantityInput.disabled = false;
            }
        }

        // Tampilkan atau sembunyikan wadah input kuantitas berdasarkan jumlah opsi yang dipilih
        if (selectedOptions.length > 0) {
            quantityInputsContainer.style.display = 'block';
        } else {
            quantityInputsContainer.style.display = 'none';
        }
    }

    
    // tampilan total pembayaran setelah menekan input salah satu produk atau beberapa produk
    function updateTotalPayment() {
        var selectedProducts = document.querySelectorAll('select[name="product_id[]"] option:checked');
        var totalPayment = 0;

        selectedProducts.forEach(function(product) {
            var productId = product.value - 1; // Kurangi 1 dari nilai product ID untuk mendapatkan indeks
            var quantityInput = document.querySelectorAll('input[name="quantity[]"]')[productId];
            var price = parseFloat(product.getAttribute('data-price'));
            var quantity = parseInt(quantityInput.value);

            if (!isNaN(quantity)) {
                totalPayment += price * quantity;
            }
        });

        document.getElementById('totalPayment').value = totalPayment;
    }


    // fitur uang kembalian di input
    // Ambil elemen-elemen input yang diperlukan
    var receivedMoneyInput = document.getElementById('receivedMoney');
    var changeMoneyInput = document.getElementById('changeMoney');
    var changeMoneyHiddenInput = document.getElementById('changeMoneyHidden');
    var totalPaymentInput = document.getElementById('totalPayment');

    // Tambahkan event listener untuk perubahan pada input 'Uang Diterima'
    receivedMoneyInput.addEventListener('input', function() {
        var totalPayment = parseFloat(totalPaymentInput.value.replace(/\D/g, ''));
        var receivedMoney = parseFloat(this.value.replace(/\D/g, ''));

        // Hitung uang kembalian dan tampilkan dengan format Rupiah
        var changeMoney = receivedMoney - totalPayment;
        var formattedChangeMoney = changeMoney.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });

        // Perbarui nilai input 'Uang Kembalian'
        changeMoneyInput.value = formattedChangeMoney;

        // Ubah nilai input tersembunyi 'change_customer_money_hidden' menjadi angka tanpa format Rupiah
        var changeMoneyWithoutCurrency = changeMoney.toString().replace(/\D/g, '');
        changeMoneyHiddenInput.value = changeMoneyWithoutCurrency;
    });
</script>

@endsection
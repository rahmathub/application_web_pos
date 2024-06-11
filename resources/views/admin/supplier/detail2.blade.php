@extends('layouts.admin')
@section('header', 'Detail Supplier')

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
                    <div class="card-body">
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">No</th>
                                    <th class="text-center">Nama Product</th>
                                    <th class="text-center">Foto</th>
                                    <th class="text-center">Harga Modal</th>
                                    <th class="text-center">quantiti</th>
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
            // DataTables & Plugins
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
                $(function() {
                    $("#datatable").DataTable();
                });
            </script>

            <script type="text/javascript">
                var actionUrl = '{{ url('note_buyer_detail') }}';

                // Menyesuaikan api sesuai id dari store ke note_buyer
                var apiUrl = '{{ url('api/note_buyer_detail_with_products', ['note_buyer_id' => $note_buyer->id]) }}';

                var columns = [{
                        data: null,
                        className: 'text-center',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'product.name',
                        className: 'text-center',
                        orderable: false
                    },
                    {
                        data: 'product.photo',
                        render: function(data, type, row) {
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
                    {
                        data: 'product.price_start',
                        className: 'text-center',
                        render: function(data, type, row) {
                            return formatCurrency(data);
                        }
                    },
                    {
                        data: 'note_buyer_detail.qty',
                        className: 'text-center'
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
                                    dataSrc: function(response) {
                                        return response.data;
                                    },
                                },
                                columns: columns,
                                rowCallback: function(row, data, index) {
                                    var pageInfo = _this.table.page.info();
                                    $('td:eq(0)', row).html(pageInfo.start + index + 1);
                                }
                            }).on('xhr', function() {
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

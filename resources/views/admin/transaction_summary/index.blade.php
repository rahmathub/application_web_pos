@extends('layouts.admin')
@section('header', 'Rekap Transaksi')

@section('content')
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <h3>Data Rekap Transaksi</h3>
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-gray-dark">
                    <div class="inner">
                        <h3>Rp {{ number_format($total_keuntungan, 0, ',', '.') }}</h3>
                        <p>Total Keuntungan dari semua transaksi</p>
                    </div>
                    <div class="icon" style="color: #6c757d">
                        <i class="ion ion-bag"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-navy">
                    <div class="inner">
                        <h3>{{ $total_categories }}</h3>
                        <p>Total Categories</p>
                    </div>
                    <div class="icon" style="color: white">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-secondary" style="color: #343a40">
                    <div class="inner">
                        <h3>{{ $total_customers }}</h3>
                        <p> total Customers yang sudah transaksi</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div div class="small-box bg-light">
                    <div class="inner">
                        <h3>{{ $total_transactions }}</h3>
                        <p>Total Transactions</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <!-- DONUT CHART -->
                    <div class="card card-gray-dark">
                        <div class="card-header">
                            <h3 class="card-title">Grafik Categori</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="donutChart"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col (LEFT) -->
                <div class="col-md-6">
                    <!-- BAR CHART -->
                    <div class="card card-navy">
                        <div class="card-header">
                            <h3 class="card-title">Grafik Transaksi Bulanan</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="barChart"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col (RIGHT) -->
            </div>
            <!-- /.row -->

            <div class="card-footer bg-dark">
                <div class="row">
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                            {{-- <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span> --}}
                            <h5 class="description-header">Rp {{ number_format($totalProfit_today, 0, ',', '.') }}</h5>
                            <span class="description-text">TOTAL KEUNTUNGAN HARI INI</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                            {{-- <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span> --}}
                            <h5 class="description-header">Rp {{ number_format($totalProfit_yesterday, 0, ',', '.') }}</h5>
                            <span class="description-text">TOTAL Keuntungan HARI KEMARIN</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                            {{-- <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span> --}}
                            <h5 class="description-header">Rp {{ number_format($totalProfit_month, 0, ',', '.') }}</h5>
                            <span class="description-text">TOTAL KEUNTUNGAN BULAN LALU</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block">
                            {{-- <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span> --}}
                            <h5 class="description-header">Rp {{ number_format($totalProfit_lastYear, 0, ',', '.') }}</h5>
                            <span class="description-text">TOTAL KEUNTUNGAN TAHUN LALU</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                </div>

            </div>

            {{-- bagian keuntungan tahunan --}}
            <div class="card-footer col-lg-12">
                {{-- bulan 1 sampai bulan 6 --}}
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Penjualan (Jan - Jun)</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">Tahun Ini Rp
                                    {{ number_format($totalProfitCurrentYear, 0, ',', '.') }}</span>
                                <span>Total Penjualan</span>
                            </p>
                            <p class="ml-auto d-flex flex-column text-right">
                                {{-- Menggunakan Conditional Statemen untuk persentase --}}
                                @if ($profitPercentageChange >= 0)
                                    <span class="text-success">
                                        Persentase Tahunan
                                        <i class="fas fa-arrow-up"></i>Naik {{ $profitPercentageChange }}%
                                    </span>
                                @else
                                    <span class="text-danger">
                                        Persentase Tahunan
                                        <i class="fas fa-arrow-down"></i>Turun {{ $profitPercentageChange }}%
                                    </span>
                                @endif

                                <span class="text-muted">Perbandingan Tahun Lalu dari bulan 1-6</span>
                            </p>
                        </div>
                        <!-- /.d-flex -->

                        <div class="position-relative mb-4">
                            <canvas id="sales-chart1" height="200"></canvas>
                        </div>

                        <div class="d-flex flex-row justify-content-end">
                            <span class="mr-2">
                                <i class="fas fa-square text-primary"></i> Tahun Ini
                            </span>

                            <span>
                                <i class="fas fa-square text-gray"></i> Tahun Lalu
                            </span>
                        </div>
                    </div>
                </div>

                {{-- bulan 7 sampai 12 --}}
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Penjualan (Jul - Dec)</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">Tahun Lalu Rp
                                    {{ number_format($totalProfit_lastYear, 0, ',', '.') }}</span>
                                <span>Total Penjualan</span>
                            </p>
                            <p class="ml-auto d-flex flex-column text-right">
                                {{-- Menggunakan Conditional Statemen untuk persentase --}}
                                @if ($profitPercentageChange >= 0)
                                    <span class="text-success">
                                        Persentase Tahunan
                                        <i class="fas fa-arrow-up"></i>Naik {{ $profitPercentageChange }}%
                                    </span>
                                @else
                                    <span class="text-danger">
                                        Persentase Tahunan
                                        <i class="fas fa-arrow-down"></i>Turun {{ $profitPercentageChange }}%
                                    </span>
                                @endif
                                <span class="text-muted">Perbandingan Tahun Lalu dari bulan 7-12</span>
                            </p>
                        </div>
                        <!-- /.d-flex -->

                        <div class="position-relative mb-4">
                            <canvas id="sales-chart2" height="200"></canvas>
                        </div>

                        <div class="d-flex flex-row justify-content-end">
                            <span class="mr-2">
                                <i class="fas fa-square text-primary"></i> Tahun Ini
                            </span>

                            <span>
                                <i class="fas fa-square text-gray"></i> Tahun Lalu
                            </span>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
                {{-- membuat table barang yang sering di beli top 10 ranks --}}
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">Top Rank 10 Products Last Month</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-striped table-valign-middle">
                            <thead>
                                <tr>
                                    <th>Nama Product</th>
                                    <th>Harga</th>
                                    <th>Terjual</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($topProducts as $product)
                                <tr>
                                    <td>
                                        <img src="{{ $product->product->photo ?? 'dist/img/default-150x150.png' }}" alt="{{ $product->product->name }}"
                                            class="img-circle img-size-32 mr-2">
                                        {{ $product->product->name }}
                                    </td>
                                    <td>Rp {{ number_format($product->product->price_deal, 0, ',', '.') }}</td>
                                    <td>
                                        <small class="text-success mr-1">
                                            <i class="fas fa-arrow-up"></i>
                                            {{ number_format($product->total_sales) }} total product
                                        </small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('js')
    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>

    {{-- Chart untuk tahun ini dan tahun lalu dalam keuntungan --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx1 = document.getElementById('sales-chart1').getContext('2d');
            var salesChart1 = new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                            label: 'This year',
                            backgroundColor: '#007bff',
                            borderColor: '#007bff',
                            data: @json(array_slice($currentYearData, 0, 6))
                        },
                        {
                            label: 'Last year',
                            backgroundColor: '#ced4da',
                            borderColor: '#ced4da',
                            data: @json(array_slice($lastYearData, 0, 6))
                        }
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        mode: 'index',
                        intersect: true
                    },
                    hover: {
                        mode: 'index',
                        intersect: true
                    },
                    legend: {
                        display: true
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: true,
                                lineWidth: '4px',
                                color: 'rgba(0, 0, 0, .2)',
                                zeroLineColor: 'transparent'
                            },
                            ticks: {
                                beginAtZero: true,
                                callback: function(value) {
                                    if (value >= 1000) {
                                        value /= 1000;
                                        value += 'k';
                                    }
                                    return 'Rp ' + value;
                                }
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                display: false
                            }
                        }]
                    }
                }
            });

            var ctx2 = document.getElementById('sales-chart2').getContext('2d');
            var salesChart2 = new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: ['Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                            label: 'This year',
                            backgroundColor: '#007bff',
                            borderColor: '#007bff',
                            data: @json(array_slice($currentYearData, 6, 6))
                        },
                        {
                            label: 'Last year',
                            backgroundColor: '#ced4da',
                            borderColor: '#ced4da',
                            data: @json(array_slice($lastYearData, 6, 6))
                        }
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        mode: 'index',
                        intersect: true
                    },
                    hover: {
                        mode: 'index',
                        intersect: true
                    },
                    legend: {
                        display: true
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: true,
                                lineWidth: '4px',
                                color: 'rgba(0, 0, 0, .2)',
                                zeroLineColor: 'transparent'
                            },
                            ticks: {
                                beginAtZero: true,
                                callback: function(value) {
                                    if (value >= 1000) {
                                        value /= 1000;
                                        value += 'k';
                                    }
                                    return 'Rp ' + value;
                                }
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                display: false
                            }
                        }]
                    }
                }
            });
        });
    </script>

    <script>
        var label_donut = `{!! json_encode($label_donut) !!}`;
        var data_donut = `{!! json_encode($data_donut) !!}`;
        var data_bar = `{!! json_encode($data_bar) !!}`;

        $(function() {
            //-------------
            //- DONUT CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
            var donutData = {
                labels: JSON.parse(label_donut),
                datasets: [{
                    data: JSON.parse(data_donut),
                    backgroundColor: ['#343a40', '#007bff', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de',
                        '#81a1c1'
                    ],
                }]
            }

            var donutOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            new Chart(donutChartCanvas, {
                type: 'doughnut',
                data: donutData,
                options: donutOptions
            })

            //-------------
            //- BAR CHART -
            //-------------
            var areaChartData = {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
                    'October', 'November', 'Desember'
                ],
                datasets: JSON.parse(data_bar)
            }
            var barChartCanvas = $('#barChart').get(0).getContext('2d')
            var barChartData = $.extend(true, {}, areaChartData)
            // var temp0 = areaChartData.datasets[0]
            // var temp1 = areaChartData.datasets[1]
            // barChartData.datasets[0] = temp1
            // barChartData.datasets[1] = temp0

            var barChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                datasetFill: false
            }

            new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            })
        })
    </script>



@endsection

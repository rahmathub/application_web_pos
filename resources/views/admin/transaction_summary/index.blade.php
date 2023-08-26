@extends('layouts.admin')
@section('header')

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
                        <p> Customers yang sudah transaksi</p>
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
                        <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
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
                                <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
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
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('js')
    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>

    <script>
        var label_donut = `{!! json_encode($label_donut) !!}`;
        var data_donut = `{!! json_encode($data_donut) !!}`;
        var data_bar = `{!! json_encode($data_bar) !!}`;

        $(function () {
            //-------------
            //- DONUT CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
            var donutData = {
                labels: JSON.parse(label_donut),
                datasets: [
                    {
                        data: JSON.parse(data_donut),
                        backgroundColor: ['#343a40', '#007bff', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', '#81a1c1'],
                    }
                ]
            }

            var donutOptions     = {
                maintainAspectRatio : false,
                responsive : true,
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
                labels : ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'Desember'],
                datasets : JSON.parse(data_bar)
            }
            var barChartCanvas = $('#barChart').get(0).getContext('2d')
            var barChartData = $.extend(true, {}, areaChartData)
            // var temp0 = areaChartData.datasets[0]
            // var temp1 = areaChartData.datasets[1]
            // barChartData.datasets[0] = temp1
            // barChartData.datasets[1] = temp0

            var barChartOptions = {
            responsive              : true,
            maintainAspectRatio     : false,
            datasetFill             : false
            }

            new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
            })
        })
    </script>
@endsection
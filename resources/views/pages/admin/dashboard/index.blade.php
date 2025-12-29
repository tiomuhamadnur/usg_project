@extends('layouts.base')

@section('header')
    <title>Dashboard Klinik USG AJA</title>
@endsection

@section('content')
    <div class="container-fluid py-3">
        <!-- Header -->
        <div class="dashboard-header d-flex flex-wrap justify-content-between align-items-center mb-2">
            <h5 class="fw-bold text-dark m-0 mb-2 mb-md-0">📊 Dashboard Klinik USG AJA</h5>

            <form action="{{ route('dashboard-admin.index') }}" method="GET" class="row g-1 align-items-center">
                <div class="col-auto">
                    <input type="date" class="form-control form-control-sm" name="start_date" id="startDate" value="{{ $start_date }}" required>
                </div>
                <div class="col-auto">
                    <input type="date" class="form-control form-control-sm" name="end_date" id="endDate" value="{{ $end_date }}" required>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-sm btn-primary" title="Search">
                        <i class="fa fa-magnifying-glass"></i>
                    </button>
                </div>
            </form>
        </div>


        <!-- KPI -->
        <div class="row row-cols-2 row-cols-md-4 g-2 mb-2">
            <div class="col">
                <div class="card">
                    <div class="card-body text-center p-2">
                        <h6>🆕 Pasien Baru</h6>
                        <h4>{{ $pasien_baru }}</h4>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card">
                    <div class="card-body text-center p-2">
                        <h6>🔁 Pasien Berulang</h6>
                        <h4>{{ $pasien_berulang }}</h4>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card">
                    <div class="card-body text-center p-2">
                        <h6>🩺 Pemeriksaan USG</h6>
                        <h4>{{ $jumlah_pemeriksaan }}</h4>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card">
                    <div class="card-body text-center p-2">
                        <h6>💰 Pendapatan</h6>
                        <h4>{{ $pendapatan }}</h4>
                    </div>
                </div>
            </div>
            {{-- <div class="col">
                <div class="card">
                    <div class="card-body text-center p-2">
                        <h6>Laba Bersih</h6>
                        <h4 id="labaBersih">Rp 25jt</h4>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body text-center p-2">
                        <h6>ROAS</h6>
                        <h4 id="roas">3.5</h4>
                    </div>
                </div>
            </div> --}}
        </div>

        <!-- Charts -->
        <div class="row g-2">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary text-white fw-bolder">Tren Pasien & Revenue</div>
                    <div class="card-body p-1">
                        <div id="trenPasien" class="chart-box"></div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white fw-bolder">Breakdown Cost</div>
                    <div class="card-body p-2">
                        <div id="breakdownCost" class="chart-box"></div>
                    </div>
                </div>
            </div> --}}
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary text-white fw-bolder">Average Service Time</div>
                    <div class="card-body p-1">
                        <div id="waitingTime" class="chart-box"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary text-white fw-bolder">Jam Datang Pasien</div>
                    <div class="card-body p-1">
                        <div id="heatmap" class="chart-box"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="row g-2 mt-1">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white fw-bolder">Average Waiting Time</div>
                    <div class="card-body p-2">
                        <div id="waitingTime" class="chart-box"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white fw-bolder">Jam Datang Pasien</div>
                    <div class="card-body p-2">
                        <div id="heatmap" class="chart-box"></div>
                    </div>
                </div>
            </div>
        </div> --}}

        {{-- <div class="row g-2 mt-1">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white fw-bolder">Top 5 Campaign</div>
                    <div class="card-body p-2 table-responsive">
                        <table class="table table-sm table-striped m-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Campaign</th>
                                    <th>Leads</th>
                                    <th>Conv</th>
                                </tr>
                            </thead>
                            <tbody id="campaignTable">
                                <tr>
                                    <td>Facebook Ads</td>
                                    <td>200</td>
                                    <td>50%</td>
                                </tr>
                                <tr>
                                    <td>Instagram Ads</td>
                                    <td>150</td>
                                    <td>45%</td>
                                </tr>
                                <tr>
                                    <td>Google Ads</td>
                                    <td>180</td>
                                    <td>40%</td>
                                </tr>
                                <tr>
                                    <td>TikTok Ads</td>
                                    <td>120</td>
                                    <td>35%</td>
                                </tr>
                                <tr>
                                    <td>Billboard</td>
                                    <td>80</td>
                                    <td>25%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white fw-bolder">Stock Forecast Obat</div>
                    <div class="card-body p-2">
                        <div id="stockForecast" class="chart-box"></div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection

@push('styles')
    <style>
        body {
            background: #f8f9fa;
            font-size: 0.9rem;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            background-color: #F60088 !important;
            color: white;
            font-weight: 600;
            padding: .5rem .75rem;
        }

        .form-control-sm {
            max-width: 140px;
            font-size: 0.8rem;
        }

        .chart-box {
            height: 250px;
        }

        h6 {
            font-size: 0.75rem;
            margin-bottom: .25rem;
        }

        h4 {
            font-size: 1.1rem;
        }
    </style>
@endpush

@push('scripts')
    <!-- Highcharts -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/heatmap.js"></script>
    <script src="https://code.highcharts.com/modules/funnel.js"></script>
    <script src="https://code.highcharts.com/modules/gauge.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script>
        // function randomData(len, max = 100) {
        //     return Array.from({
        //         length: len
        //     }, () => Math.floor(Math.random() * max));
        // }

        let trenPasienChart = Highcharts.chart('trenPasien', {
            chart: {
                type: 'line',
                zoomType: 'x',
                height: 300
            },
            title: { text: '' },
            xAxis: { categories: {!! json_encode($dates) !!} },
            yAxis: [
                { title: { text: 'Pasien', style: { fontWeight: 'bold' } } },
                { title: { text: 'Revenue (jt)', style: { fontWeight: 'bold' } }, opposite: true }
            ],
            tooltip: {
                shared: true,
                formatter: function () {
                    let s = '';
                    this.points.forEach(function(point){
                        if(point.series.name === 'Revenue') {
                            s += '<br/>' + point.series.name + ': <b>' + point.y + ' jt</b>';
                        } else {
                            s += '<br/>' + point.series.name + ': <b>' + point.y + '</b>';
                        }
                    });
                    return s;
                }
            },
            series: [
                { name: 'Pasien', data: {!! json_encode($pasienSeries) !!}, color: '#F60088' },
                { name: 'Revenue', data: {!! json_encode($revenueSeries) !!}, yAxis: 1, color: '#00bcd4' }
            ]
        });

        // Highcharts.chart('breakdownCost', {
        //     chart: {
        //         type: 'pie',
        //         height: 250
        //     },
        //     title: {
        //         text: ''
        //     },
        //     series: [{
        //         name: 'Biaya',
        //         data: [{
        //                 name: 'Operasional',
        //                 y: 40
        //             },
        //             {
        //                 name: 'Gaji',
        //                 y: 30
        //             },
        //             {
        //                 name: 'Marketing',
        //                 y: 20
        //             },
        //             {
        //                 name: 'Lain-lain',
        //                 y: 10
        //             }
        //         ]
        //     }],
        //     colors: ['#F60088', '#03a9f4', '#8bc34a', '#ffc107']
        // });

        Highcharts.chart('waitingTime', {
            chart: {
                type: 'gauge',
                height: 300
            },
            title: {
                text: ''
            },
            pane: {
                startAngle: -150,
                endAngle: 150
            },
            yAxis: {
                min: 0,
                max: 180,
                title: {
                    text: 'Menit',
                    style: { fontWeight: 'bold' }
                }
            },
            series: [{
                name: 'Service Time',
                data: [{{ $average_service_time }}],
                tooltip: {
                    valueSuffix: ' menit'
                }
            }]
        });

        let heatmapChart = Highcharts.chart('heatmap', {
            chart: {
                type: 'heatmap',
                height: 300,
                zoomType: 'xy'
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: {!! json_encode($hours) !!},
                title: {
                    text: 'Jam',
                    style: { fontWeight: 'bold' } // label bold
                }
            },
            yAxis: {
                categories: {!! json_encode($days_heatmap) !!},
                title: {
                    text: 'Hari',
                    style: { fontWeight: 'bold' } // label bold
                },
                reversed: true // Senin di atas
            },
            colorAxis: { min: 0, minColor: '#ffffff', maxColor: '#F60088' },
            tooltip: {
                formatter: function() {
                    let jam = this.series.xAxis.categories[this.point.x];
                    let hari = this.series.yAxis.categories[this.point.y];
                    let pasien = this.point.value;
                    return `<b>Hari:</b> ${hari}<br/>
                            <b>Jam:</b> ${jam}:00<br/>
                            <b>Jumlah Pasien:</b> ${pasien}`;
                }
            },
            series: [{
                name: 'Jumlah Pasien',
                borderWidth: 1,
                data: {!! json_encode($heatmapData) !!},
                dataLabels: { enabled: true, color: '#000' }
            }]
        });

        // let stockForecastChart = Highcharts.chart('stockForecast', {
        //     chart: {
        //         type: 'line',
        //         zoomType: 'x',
        //         height: 250
        //     },
        //     title: {
        //         text: ''
        //     },
        //     xAxis: {
        //         categories: ['Sep', 'Okt', 'Nov', 'Des', 'Jan', 'Feb']
        //     },
        //     yAxis: {
        //         title: {
        //             text: 'Jumlah Stok'
        //         }
        //     },
        //     series: [{
        //             name: 'Stok Aktual',
        //             data: [500, 450, 420, 400, 380, 360]
        //         },
        //         {
        //             name: 'Forecast',
        //             data: [360, 340, 320, 300, 280, 250],
        //             dashStyle: 'ShortDash'
        //         }
        //     ],
        //     colors: ['#F60088', '#607d8b']
        // });

        // document.getElementById('endDate').addEventListener('change', () => {
        //     trenPasienChart.series[0].setData(randomData(6, 100));
        //     trenPasienChart.series[1].setData(randomData(6, 30));
        //     stockForecastChart.series[0].setData(randomData(6, 500));
        //     stockForecastChart.series[1].setData(randomData(6, 400));
        //     heatmapChart.series[0].setData(Array.from({
        //         length: 10
        //     }, (_, i) => [i % 5, Math.floor(i / 5), Math.floor(Math.random() * 20)]));
        //     document.getElementById('pasienUnique').textContent = Math.floor(Math.random() * 200);
        //     document.getElementById('pasienBerulang').textContent = Math.floor(Math.random() * 100);
        //     document.getElementById('usgCount').textContent = Math.floor(Math.random() * 300);
        //     document.getElementById('pendapatan').textContent = 'Rp ' + Math.floor(Math.random() * 100) + 'jt';
        //     // document.getElementById('labaBersih').textContent = 'Rp ' + Math.floor(Math.random() * 50) + 'jt';
        //     // document.getElementById('roas').textContent = (Math.random() * 5).toFixed(2);
        // });
    </script>
@endpush

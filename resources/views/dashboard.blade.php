@extends('layouts/main')
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        var maxCircleCount = Math.max({{ $circleCount }}, {{ $activeCircle1 }});
        var langkahActive = "{{ $langkahActive }}";
        var options = {
            chart: {
                type: 'area',
                height: 350,
                zoom: {
                    enabled: false
                }
            },
            xaxis: {
                categories: ['Langkah 1', 'Langkah 2', 'Langkah 3', 'Langkah 4', 'Langkah 5', 'Langkah 6', 'Langkah 7',
                    'Langkah 8', 'NQI'
                ],
                labels: {
                    style: {
                        fontSize: '12px' // Atur ukuran font label x-axis
                    }
                }
            },
            yaxis: {
                tickAmount: 1, // Set jumlah tanda sumbu Y ke 1 (kelipatan 1)
                min: 0, // Set nilai minimum sumbu Y menjadi 0
                labels: {
                    style: {
                        fontSize: '12px' // Atur ukuran font label y-axis
                    }
                }
            },
            series: [{
                name: 'Sudah Register',
                data: [{{ $circleCount }}, {{ $circleCount }}, {{ $circleCount }}, {{ $circleCount }},
                    {{ $circleCount }}, {{ $circleCount }}, {{ $circleCount }}, {{ $circleCount }},
                    {{ $circleCount }},
                ]
            }, {
                name: 'Sudah Absen',
                data: [{{ $activeCircle1 }}, {{ $activeCircle2 }}, {{ $activeCircle3 }},
                    {{ $activeCircle4 }}, {{ $activeCircle5 }}, {{ $activeCircle6 }},
                    {{ $activeCircle7 }}, {{ $activeCircle8 }}, {{ $activeCircle9 }}
                ]
            }],
            colors: ['#94eb90', '#1b35ad'],
            annotations: {
                xaxis: [{
                    x: langkahActive, // Indeks dimulai dari 0, jadi langkah 4 memiliki indeks 3
                    borderColor: '#ff0000', // Warna garis
                    label: {
                        style: {
                            color: '#fff', // Warna teks
                            background: '#FF4560', // Warna latar belakang teks
                            fontSize: '14px'
                        },
                        orientation: "vertical",
                        text: 'Masa Pengisian Saat Ini' // Teks yang akan ditampilkan
                    }
                }]
            } // Warna untuk masing-masing series
        };




        var chart = new ApexCharts(document.querySelector("#chart1"), options);
        chart.render();
        console.log(langkahActive);
    </script>
    <script>
        var maxCircleCount = Math.max({{ $circleCount }}, {{ $activeCircle1 }});
        var options = {
            chart: {
                type: 'area',
                height: 350,
                zoom: {
                    enabled: false
                }
            },
            xaxis: {
                categories: ['Langkah 1', 'Langkah 2', 'Langkah 3', 'Langkah 4', 'Langkah 5', 'Langkah 6', 'Langkah 7',
                    'Langkah 8', 'NQI'
                ],
                labels: {
                    style: {
                        fontSize: '12px' // Atur ukuran font label x-axis
                    }
                }
            },
            yaxis: {
                tickAmount: 1, // Set jumlah tanda sumbu Y ke 1 (kelipatan 1)
                min: 0, // Set nilai minimum sumbu Y menjadi 0
                labels: {
                    style: {
                        fontSize: '12px' // Atur ukuran font label y-axis
                    }
                }
            },
            series: [{
                name: 'Sudah Register',
                data: [10, 10, 10, 10, 10, 10, 10, 10]
            }, {
                name: 'Sudah Absen',
                data: [1, 2, 3, 4, 5, 6, 7, 8]

            }],
            colors: ['#ebb890', '#eb90e6'] // Warna untuk masing-masing series
        };




        var chart = new ApexCharts(document.querySelector("#chart2"), options);
        chart.render();
    </script>
    <script>
        var maxCircleCount = Math.max({{ $circleCount }}, {{ $activeCircle1 }});
        var options = {
            chart: {
                type: 'area',
                height: 350,
                zoom: {
                    enabled: false
                }
            },
            xaxis: {


                categories: ['Langkah 1', 'Langkah 2', 'Langkah 3', 'Langkah 4', 'Langkah 5', 'Langkah 6', 'Langkah 7',
                    'Langkah 8', 'NQI'
                ],
                labels: {
                    style: {
                        fontSize: '12px' // Atur ukuran font label x-axis
                    }
                }
            },
            yaxis: {
                tickAmount: 1, // Set jumlah tanda sumbu Y ke 1 (kelipatan 1)
                min: 0, // Set nilai minimum sumbu Y menjadi 0
                labels: {
                    style: {
                        fontSize: '12px' // Atur ukuran font label y-axis
                    }
                }
            },
            series: [{
                name: 'Sudah Register',
                data: [10, 10, 10, 10, 10, 10, 10, 10]
            }, {
                name: 'Sudah Absen',
                data: [1, 2, 3, 4, 5, 6, 7, 8]

            }],
            colors: ['#90e2eb', '#eb9090'] // Warna untuk masing-masing series

        };




        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
@endsection
@section('content')
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            @include('alert')
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Dashboard</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bi bi-house"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- [ variant-chart ] start -->

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Quality Control Circle</h5>
                        </div>
                        <div class="card-body">
                            <div id="chart1" class="w-100" width="100" height="20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Design Thinking</h5>
                        </div>
                        <div class="card-body">
                            <div id="chart2" class="w-100" width="100" height="20"></div>



                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>CBI</h5>
                        </div>
                        <div class="card-body">
                            <div id="chart" class="w-100"></div>
                        </div>
                    </div>
                </div>

                <!-- [ variant-chart ] end -->

            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
@endsection

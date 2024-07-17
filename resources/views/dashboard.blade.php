@extends('layouts/main')
@section('script')
    <script>
        function setFilter(value) {
            filterCategory(value);
        }

        function filterCategory(value) {

            location.href = `?filter=${value}`;
        }
    </script>
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
                categories: ['L1 - Menentukan Tema', 'L2 - Menetapkan Target', 'L3 - Analisa Masalah',
                    'L4 - Rencana Perbaikan', 'L5 - Implementasi Perbaikan',
                    'L6 - Evaluasi Hasil', 'L7 - Standarisasi',
                    'L8 - Rencana Berikut', 'NQI'
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
            colors: ['#94eb90', '#2C4E80'],
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
                categories: ['L1 -  Empathy : Background', 'L1 - Empathy : Empathy Map',
                    'L1 - Empathy : Customer Journey', 'L2 - Define', 'L3 - Ideate',
                    'L4 - Prototype', 'L5 - Customer Feedback',
                    'L5 - Test Performance', 'Project Overview'
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
                data: [{{ $circleCountDt }}, {{ $circleCountDt }}, {{ $circleCountDt }},
                    {{ $circleCountDt }},
                    {{ $circleCountDt }}, {{ $circleCountDt }}, {{ $circleCountDt }},
                    {{ $circleCountDt }},
                    {{ $circleCountDt }},
                ]
            }, {
                name: 'Sudah Absen',
                data: [{{ $activeCircleDt1 }}, {{ $activeCircleDt2 }}, {{ $activeCircleDt3 }},
                    {{ $activeCircleDt4 }}, {{ $activeCircleDt5 }}, {{ $activeCircleDt6 }},
                    {{ $activeCircleDt7 }}, {{ $activeCircleDt8 }}, {{ $activeCircleDt9 }}
                ]
            }],
            colors: ['#FC4100', '#2C4E80'], // Warna untuk masing-masing series
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
            }
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
                categories: ['L1 -  Empathy : Background', 'L1 - Empathy : Empathy Map',
                    'L1 - Empathy : Customer Journey', 'L2 - Define', 'L3 - Ideate',
                    'L4 - Prototype', 'L5 - Customer Feedback',
                    'L5 - Test Performance', 'Project Overview'
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
                data: [{{ $circleCountCbi }}, {{ $circleCountCbi }}, {{ $circleCountCbi }},
                    {{ $circleCountCbi }},
                    {{ $circleCountCbi }}, {{ $circleCountCbi }}, {{ $circleCountCbi }},
                    {{ $circleCountCbi }},
                    {{ $circleCountCbi }},
                ]
            }, {
                name: 'Sudah Absen',
                data: [{{ $activeCircleCbi1 }}, {{ $activeCircleCbi2 }}, {{ $activeCircleCbi3 }},
                    {{ $activeCircleCbi4 }}, {{ $activeCircleCbi5 }}, {{ $activeCircleCbi6 }},
                    {{ $activeCircleCbi7 }}, {{ $activeCircleCbi8 }}, {{ $activeCircleCbi9 }}
                ]
            }],
            colors: ['#F27BBD', '#10439F'], // Warna untuk masing-masing series
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
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart3"), options);
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
            @if ($periodes->count() > 0 and $activePeriode)
                <div class="row">
                    <!-- [ variant-chart ] start -->

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Quality Control Circle</h5>
                            </div>
                            <div class="card-body">
                                <div class="dropdown col-4 col-lg-3">
                                    <button class="btn btn-light border-dark col-auto text-left" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Periode {{ $filter == '' ? $activePeriode->periode : ucfirst($filter) }}
                                    </button>
                                    <ul class="dropdown-menu">
                                        @foreach ($periodes as $item)
                                            <li><a class="dropdown-item px-0" href="#"
                                                    onclick="setFilter({{ $item->periode }})">{{ $item->periode }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
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
                                <div class="dropdown col-4 col-lg-3">
                                    <button class="btn btn-light border-dark col-auto text-left" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Periode {{ $filter == '' ? $activePeriode->periode : ucfirst($filter) }}
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item px-0" href="#" onclick="setFilter('all')">All</a>
                                        </li>
                                        @foreach ($periodes as $item)
                                            <li><a class="dropdown-item px-0" href="#"
                                                    onclick="setFilter({{ $item->periode }})">{{ $item->periode }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
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
                                <div class="dropdown col-4 col-lg-3">
                                    <button class="btn btn-light border-dark col-auto text-left" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Periode {{ $filter == '' ? $activePeriode->periode : ucfirst($filter) }}
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item px-0" href="#" onclick="setFilter('all')">All</a>
                                        </li>
                                        @foreach ($periodes as $item)
                                            <li><a class="dropdown-item px-0" href="#"
                                                    onclick="setFilter({{ $item->periode }})">{{ $item->periode }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div id="chart3" class="w-100"></div>
                            </div>
                        </div>
                    </div>

                    <!-- [ variant-chart ] end -->

                </div>
                <!-- [ Main Content ] end -->
            @else
                <i class="text-danger">Periode belum dibuat...</i>
            @endif
        </div>
    </div>
@endsection

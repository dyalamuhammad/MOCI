@extends('layouts/main')
@section('content')
    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Dashboard </h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#!">Dashboard QCC</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>ACHIEVEMENT QCC BODY DIVISION PERIODE 40 </h4>
                            <span class="d-block m-t-5">Update data pengumpulan notulen QCC</span>
                        </div>
                        <div id="chart"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        var options = {
            chart: {
                type: 'bar',
                height: 350,
            },
            xaxis: {
                categories: ['Langkah 1', 'Langkah 2', 'Langkah 3', 'Langkah 4', 'Langkah 5', 'Langkah 6', 'Langkah 7',
                    'Langkah 8', 'NQI'
                ],
            },
            yaxis: {
                tickAmount: 1, // Set jumlah tanda sumbu Y ke 1 (kelipatan 1)
                min: 0, // Set nilai minimum sumbu Y menjadi 0
            },
            series: [{
                name: 'Circle Aktif',
                // type: 'bar',
                data: 1,
            }, {
                name: 'Circle Register',
                data: 2,
                // type: 'line',
                color: 'red', // Warna target

            }, {
                colors: ['orange'] // Mengubah warna batang
            }],
        };



        var chart = new ApexCharts(document.querySelector("#chart"), options);

        chart.render();
    </script>
@endsection

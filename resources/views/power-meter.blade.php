@extends('layouts.main')
@section('content')
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h3>Apex Js</h3>
                            <p id="car"></p>
                            <p id="car"></p>
                        </div>
                        <div class="card-body">
                            <div id="chart" class="w-100" width="100" height="20"></div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h3>Chart Js</h3>
                            <p id="car"></p>
                        </div>
                        <div class="card-body">
                            <canvas id="test"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h3>Chart Js</h3>
                            <p id="car"></p>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart" class="w-100"></canvas>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        function loadAchievement() {
            // Mengambil CSRF token dari meta tag
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '{{ route('getPowerMeter') }}',
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Menambahkan CSRF token ke header
                },
                data: {
                    "pk": 0,
                },
                success: function(data) {
                    var result = JSON.parse(data);
                    $('#car').html(result[1]);
                    $('#endUpdate').html(result[2]);
                    console.log(result);
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        }

        //Interval waktu yang diharapkan
        setInterval(function() {
            loadAchievement();
        }, 3000); // 3 seconds = 3000 ms (Set 3 sec)
    </script>

    {{-- apex --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var maxCircleCount = 10;
            var options = {
                chart: {
                    type: 'line',
                    height: 350
                },
                series: [{
                    name: 'Voltase',
                    data: []
                }, {
                    name: 'Daya',
                    data: []
                }, ],
                xaxis: {
                    categories: ['Voltase', 'Daya']
                },

                colors: ['#F27BBD', '#10439F'], // Warna untuk masing-masing series

            };

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();

            function loadAchievement() {
                // Mengambil CSRF token dari meta tag
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: '{{ route('getPowerMeter') }}',
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Menambahkan CSRF token ke header
                    },
                    data: {
                        "pk": 0,
                    },
                    success: function(data) {
                        var result = JSON.parse(data);

                        var voltase = result[1];
                        var daya = result[2];
                        var tanggal = result[3];

                        // Get the current series data and categories
                        var currentData = chart.w.globals.series[0].data || [];
                        var currentCategories = chart.w.globals.labels || [];

                        // Update chart data
                        chart.updateSeries([{
                            name: 'Voltase',
                            data: [...currentData, voltase] // Append new data
                        }, {
                            name: 'Daya',
                            data: [...currentData, daya]
                        }]);



                        console.log(result);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                    }
                });
            }

            //Interval waktu yang diharapkan
            setInterval(function() {
                loadAchievement();
            }, 6000); // 6 seconds = 6000 ms
        });
    </script>


    {{-- chart js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function() {
            var ctx = document.getElementById('test');
            var powerMeterChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['volt'],
                    datasets: [{
                        label: 'Volt',
                        data: [1],
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        fill: true
                    }]
                },
                options: {
                    scales: {
                        x: {
                            type: 'category', // Use 'category' instead of 'time'
                            title: {
                                display: true,
                                text: 'Time'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                // Ensure that small values are properly displayed
                                stepSize: 0.1,

                            }
                        }
                    }
                }
            });

            function loadChartData() {
                $.ajax({
                    url: '{{ route('getPowerMeter') }}',
                    method: 'POST',
                    data: {
                        "pk": 0,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        var result = JSON.parse(data);

                        var labels = result[1];
                        var data = result[3];
                        console.log('ini adalah labels' + labels)
                        console.log('ini adalah datas' + data)

                        powerMeterChart.data.labels = data;
                        powerMeterChart.data.datasets[0].data = labels;
                        powerMeterChart.update();


                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                    }
                });
            }

            // Initial load
            loadChartData();

            // Update every 5 seconds
            setInterval(function() {
                loadChartData();
            }, 5000);
        });
    </script>

    <script>
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection

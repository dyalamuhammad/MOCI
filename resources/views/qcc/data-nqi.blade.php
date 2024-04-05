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
                                <h5 class="m-b-10">Dashboard Analytics</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bi bi-house"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#!">Data NQI</a></li>
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
                            <h5>Monitoring Data NQI</h5>
                            <span class="d-block m-t-5">Hallo sahabat <code>Berikut data monitoring NQI</span>
                        </div>
                        <div class="card-body table-border-style">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Periode</th>
                                            <th>Circle</th>
                                            <th>Npk Fasilitator</th>
                                            <th>Nama Fasilitator </th>
                                            <th>Npk Tema Leader</th>
                                            <th>Nama Tema Leader</th>
                                            <th>Judul</th>
                                            <th>Manfaat Finansial</th>
                                            <th>Manfaat Non Finansial</th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- table card-1 start -->
            <!-- Warning Section Ends -->

            <!-- Required Js -->
            <script src="assets/js/vendor-all.min.js"></script>
            <script src="assets/js/plugins/bootstrap.min.js"></script>
            <script src="assets/js/pcoded.min.js"></script>

            <!-- Apex Chart -->
            <!-- <script src="assets/js/plugins/apexcharts.min.js"></script> -->


            <!-- custom-chart js -->
            <!-- <script src="assets/js/pages/dashboard-main.js"></script> -->

            <script>
                // Set waktu timeout sesi dalam milidetik (misal: 15 menit)
                const sessionTimeout = 5 * 60 * 1000; // 15 menit dalam milidetik

                // Fungsi untuk logout otomatis
                function autoLogout() {
                    window.location.href = 'element/logout.php'; // Ganti dengan URL halaman logout Anda
                }
                setTimeout(autoLogout, sessionTimeout);
            </script>
        @endsection

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
                                <li class="breadcrumb-item"><a href="#!">Data Circle</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row">
                <i>Halaman sudah tidak aktif...</i>
            </div>



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

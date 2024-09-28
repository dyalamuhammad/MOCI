<!DOCTYPE html>
<html lang="en">
<!-- [ navigation menu ] end -->
<!-- [ Header ] start -->

<head>
    <title>MOCI - Monitoring Continuous Improvement</title>
    <link rel="icon" href="{{ asset('images/favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Phoenixcoded" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- include libraries(jQuery, bootstrap) -->
    <script type="text/javascript" src="//code.jquery.com/jquery-3.6.0.min.js"></script>


    <!-- include summernote css/js-->
    <link href="{{ asset('plugins/summernote/summernote-lite.min.css') }}" rel="stylesheet">
    <script src="{{ asset('plugins/summernote/summernote-lite.min.js') }}"></script>

    <!-- vendor css -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('daterangepicker.css') }}" />

    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-5@11/dist/sweetalert2.min.css"
        rel="stylesheet">



</head>
@yield('style')

<body>
    <!-- [ Header ] end -->
    <nav class="pcoded-navbar z-2 navbar-collapsed">
        <div class="navbar-wrapper">
            <div class="navbar-content scroll-div">
                <div class="collapse mt-5" id="nav-user-link">
                    <ul class="list-unstyled">
                        <!-- <li class="list-group-item"><a href="user-profile.html"><i class="feather icon-user m-r-5"></i>View Profile</a></li>
       <li class="list-group-item"><a href="#!"><i class="feather icon-settings m-r-5"></i>Settings</a></li> -->
                        <li class="list-group-item"><a href="login"><i
                                    class="feather icon-log-out m-r-5"></i>Logout</a>
                        </li>
                    </ul>
                </div>

                <ul class="nav pcoded-inner-navbar pt-3">
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link mt-2"><span class="pcoded-micon"><i
                                    class="bi bi-house icon-layout"></i></span><span
                                class="pcoded-mtext">Dashboard</span></a>
                    </li>
                    @if (auth()->user()->jabatan == 'Superadmin')
                        <li class="nav-item pcoded-menu-caption my-0">
                            <label>Register</label>
                        </li>
                        <li class="nav-item pcoded-hasmenu">
                            <a href="#!" class="nav-link "><span class="pcoded-micon"><i
                                        class="bi bi-pencil-square icon-layout"></i></span><span
                                    class="pcoded-mtext">Register
                                </span></a>
                            <ul class="pcoded-submenu">
                                <li class="nav-item">
                                    <a href="{{ route('registerQcc') }}" class="nav-link">Register QCC</a>
                                </li>
                                <li>
                                    <a href="{{ route('registerDt') }}" class="nav-link">Register DT/CBI</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item pcoded-menu-caption my-0">
                            <label>QCC</label>
                        </li>
                        <li class="nav-item pcoded-hasmenu">
                            <a href="#!" class="nav-link "><span class="pcoded-micon"><i
                                        class="bi-journal-text icon-layout"></i></span><span class="pcoded-mtext">QCC
                                </span></a>
                            <ul class="pcoded-submenu">
                                <li class="nav-item"><a href="{{ route('monitorQcc') }}" target=""
                                        class="nav-link">Monitoring QCC</a>
                                </li>
                                <li class="nav-item"><a href="{{ route('absensiQcc') }}" target=""
                                        class="nav-link">Absensi QCC</a></li>
                                <li class="nav-item"><a href="{{ route('resumeQcc') }}" target=""
                                        class="nav-link">Resume Absensi</a></li>
                            </ul>
                        </li>
                        <li class="nav-item pcoded-menu-caption my-0">
                            <label>Design Thinking</label>
                        </li>
                        <li class="nav-item pcoded-hasmenu">
                            <a href="#!" class="nav-link "><span class="pcoded-micon"><i
                                        class="bi-journal-text icon-layout"></i></span><span
                                    class="pcoded-mtext">Design
                                    Thinking</span></a>
                            <ul class="pcoded-submenu">

                                <li><a href="{{ route('monitorDt') }}" target="" class="nav-link">Monitoring
                                        DT</a></li>
                                <li><a href="{{ route('absensiDt') }}" target="" class="nav-link">Absensi
                                        DT</a></li>
                                <li><a href="{{ route('resumeDt') }}" target="" class="nav-link">Resume
                                        Absensi</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item pcoded-menu-caption my-0">
                            <label>CBI</label>
                        </li>
                        <li class="nav-item pcoded-hasmenu">
                            <a href="#!" class="nav-link "><span class="pcoded-micon"><i
                                        class="bi-journal-text icon-layout"></i></span><span
                                    class="pcoded-mtext">CBI</span></a>
                            <ul class="pcoded-submenu">

                                <li><a href="{{ route('monitorCbi') }}" target="" class="nav-link">Monitoring
                                        CBI</a></li>
                                <li><a href="{{ route('absensiCbi') }}" target="" class="nav-link">Absensi
                                        CBI</a></li>
                                <li><a href="{{ route('resumeCbi') }}" target="" class="nav-link">Resume
                                        Absensi</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item pcoded-menu-caption my-0">
                            <label>SS</label>
                        </li>
                        <li class="nav-item pcoded-hasmenu">
                            <a href="#!" class="nav-link "><span class="pcoded-micon"><i
                                        class="bi-journal-text icon-layout"></i></span><span
                                    class="pcoded-mtext">SS</span></a>
                            <ul class="pcoded-submenu">

                                <li><a href="{{ route('ss') }}" target="" class="nav-link">Rekap Tahunan</a>
                                </li>
                                <li><a href="{{ route('ssBulanan') }}" target="" class="nav-link">Rekap
                                        Bulanan</a></li>

                        </li>
                </ul>
                </li>
                <li class="nav-item pcoded-menu-caption my-0">
                    <label>Administrator</label>
                </li>
                <li class="nav-item w-100 pcoded-hasmenu">
                    <a href="#!" class="nav-link w-100"><span class="pcoded-micon"><i
                                class="bi bi-journal-text icon-layout"></i></span><span
                            class="text-truncate px-0 pcoded-mtext" style="width: 130px !important">Admin
                            Control</span></a>
                    <ul class="pcoded-submenu">
                        <li><a href="{{ route('karyawan') }}" target="" class="nav-link">Manpower</a>
                        </li>
                        <li><a href="{{ route('controlPeriod') }}" target="" class="nav-link">Register
                                Periode</a></li>
                        <li><a href="{{ route('controlStep') }}" target="" class="nav-link">Control
                                Periode</a></li>
                        <li><a href="{{ route('control-member') }}" target="" class="nav-link">Control
                                Member</a></li>
                        <li><a href="{{ route('control-leader') }}" target="" class="nav-link">Control
                                Leader</a></li>
                        <li class="nav-item"><a href="{{ route('dataNqiQcc') }}" target=""
                                class="nav-link">Data
                                NQI</a></li>
                        <li class="nav-item"><a href="{{ route('group') }}" target=""
                                class="nav-link">Group</a></li>
                        <li class="nav-item"><a href="{{ route('section') }}" target=""
                                class="nav-link">Section</a></li>
                        <li class="nav-item"><a href="{{ route('department') }}" target=""
                                class="nav-link">Department</a></li>
                    </ul>
                </li>
            @elseif(auth()->user()->jabatan == 'TL')
                <li class="nav-item pcoded-menu-caption my-0">
                    <label>Register</label>
                </li>
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i
                                class="bi bi-pencil-square icon-layout"></i></span><span class="pcoded-mtext">Register
                        </span></a>
                    <ul class="pcoded-submenu">
                        <li class="nav-item">
                            <a href="{{ route('registerQcc') }}" class="nav-link">Register QCC</a>
                        </li>
                        <li>
                            <a href="{{ route('registerDt') }}" class="nav-link">Register DT/CBI</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item pcoded-menu-caption pt-1 my-0">
                    <label>QCC</label>
                </li>
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i
                                class="bi-journal-text icon-layout"></i></span><span class="pcoded-mtext">QCC
                        </span></a>
                    <ul class="pcoded-submenu">
                        <li class="nav-item"><a href="{{ route('monitorQcc') }}" target=""
                                class="nav-link">Monitoring QCC</a>
                        </li>
                        <li class="nav-item"><a href="{{ route('absensiQcc') }}" target=""
                                class="nav-link">Absensi QCC</a></li>

                        <li class="nav-item"><a href="{{ route('resumeQcc') }}" target=""
                                class="nav-link">Resume Absensi</a></li>
                    </ul>
                </li>
                <li class="nav-item pcoded-menu-caption my-0">
                    <label>Design Thinking</label>
                </li>
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i
                                class="bi-journal-text icon-layout"></i></span><span class="pcoded-mtext">Design
                            Thinking</span></a>
                    <ul class="pcoded-submenu">

                        <li><a href="{{ route('monitorDt') }}" target="" class="nav-link">Monitoring
                                DT</a></li>
                        <li><a href="{{ route('absensiDt') }}" target="" class="nav-link">Absensi
                                DT</a></li>
                        <li><a href="{{ route('resumeDt') }}" target="" class="nav-link">Resume
                                Absensi</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item pcoded-menu-caption my-0">
                    <label>CBI</label>
                </li>
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i
                                class="bi-journal-text icon-layout"></i></span><span
                            class="pcoded-mtext">CBI</span></a>
                    <ul class="pcoded-submenu">

                        <li><a href="{{ route('monitorCbi') }}" target="" class="nav-link">Monitoring
                                CBI</a></li>
                        <li><a href="{{ route('absensiCbi') }}" target="" class="nav-link">Absensi
                                CBI</a></li>
                        <li><a href="{{ route('resumeCbi') }}" target="" class="nav-link">Resume
                                Absensi</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item pcoded-menu-caption my-0">
                    <label>SS</label>
                </li>
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i
                                class="bi-journal-text icon-layout"></i></span><span
                            class="pcoded-mtext">SS</span></a>
                    <ul class="pcoded-submenu">

                        <li><a href="{{ route('ss') }}" target="" class="nav-link">Rekap Tahunan</a>
                        </li>
                        <li><a href="{{ route('ssBulanan') }}" target="" class="nav-link">Rekap
                                Bulanan</a></li>

                </li>
            @elseif(auth()->user()->jabatan == 'SUPERVISOR' or 'DH' or 'MNG')
                <li class="nav-item pcoded-menu-caption pt-1 my-0">
                    <label>QCC</label>
                </li>
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i
                                class="bi-journal-text icon-layout"></i></span><span class="pcoded-mtext">QCC
                        </span></a>
                    <ul class="pcoded-submenu">
                        <li class="nav-item"><a href="{{ route('monitorQcc') }}" target=""
                                class="nav-link">Monitoring QCC</a>
                        </li>
                        <li class="nav-item"><a href="{{ route('resumeQcc') }}" target=""
                                class="nav-link">Resume Absensi</a></li>
                    </ul>
                </li>
                <li class="nav-item pcoded-menu-caption my-0">
                    <label>Design Thinking</label>
                </li>
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i
                                class="bi-journal-text icon-layout"></i></span><span class="pcoded-mtext">Design
                            Thinking</span></a>
                    <ul class="pcoded-submenu">
                        <li><a href="{{ route('monitorDt') }}" target="" class="nav-link">Monitoring
                                DT</a></li>
                        <li><a href="{{ route('resumeDt') }}" target="" class="nav-link">Resume
                                Absensi</a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item pcoded-menu-caption my-0">
                    <label>CBI</label>
                </li>
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i
                                class="bi-journal-text icon-layout"></i></span><span
                            class="pcoded-mtext">CBI</span></a>
                    <ul class="pcoded-submenu">

                        <li><a href="{{ route('monitorCbi') }}" target="" class="nav-link">Monitoring
                                CBI</a></li>
                        <li><a href="{{ route('resumeCbi') }}" target="" class="nav-link">Resume
                                Absensi</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item pcoded-menu-caption my-0">
                    <label>SS</label>
                </li>
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i
                                class="bi-journal-text icon-layout"></i></span><span
                            class="pcoded-mtext">SS</span></a>
                    <ul class="pcoded-submenu">

                        <li><a href="{{ route('ss') }}" target="" class="nav-link">Rekap Tahunan</a>
                        </li>
                        <li><a href="{{ route('ssBulanan') }}" target="" class="nav-link">Rekap
                                Bulanan</a></li>

                </li>
            @elseif(auth()->user()->jabatan == 'FRM')
                <li class="nav-item pcoded-menu-caption pt-1 my-0">
                    <label>QCC</label>
                </li>
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i
                                class="bi-journal-text icon-layout"></i></span><span class="pcoded-mtext">QCC
                        </span></a>
                    <ul class="pcoded-submenu">
                        <li class="nav-item"><a href="{{ route('resumeQcc') }}" target=""
                                class="nav-link">Resume Absensi</a></li>
                        <li class="nav-item"><a href="{{ route('dataCircleQcc') }}" target=""
                                class="nav-link">Data Circle</a></li>
                        <li class="nav-item"><a href="{{ route('dataNqiQcc') }}" target=""
                                class="nav-link">Data
                                NQI</a></li>
                    </ul>
                </li>
                <li class="nav-item pcoded-menu-caption my-0">
                    <label>Design Thinking</label>
                </li>
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i
                                class="bi-journal-text icon-layout"></i></span><span class="pcoded-mtext">Design
                            Thinking</span></a>
                    <ul class="pcoded-submenu">
                        <li><a href="{{ route('monitorDt') }}" target="" class="nav-link">Monitoring
                                DT</a>
                        </li>
                        <li><a href="{{ route('resumeDt') }}" target="" class="nav-link">Resume
                                Absensi</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item pcoded-menu-caption my-0">
                    <label>CBI</label>
                </li>
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i
                                class="bi-journal-text icon-layout"></i></span><span
                            class="pcoded-mtext">CBI</span></a>
                    <ul class="pcoded-submenu">

                        <li><a href="{{ route('monitorCbi') }}" target="" class="nav-link">Monitoring
                                CBI</a></li>
                        <li><a href="{{ route('resumeCbi') }}" target="" class="nav-link">Resume
                                Absensi</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item pcoded-menu-caption my-0">
                    <label>SS</label>
                </li>
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i
                                class="bi-journal-text icon-layout"></i></span><span
                            class="pcoded-mtext">SS</span></a>
                    <ul class="pcoded-submenu">

                        <li><a href="{{ route('ss') }}" target="" class="nav-link">Rekap Tahunan</a>
                        </li>
                        <li><a href="{{ route('ssBulanan') }}" target="" class="nav-link">Rekap
                                Bulanan</a></li>

                </li>
                @endif
                </ul>


                <!-- Menampilkan session 'info' untuk sweat alert -->

            </div>
        </div>
    </nav>
    <!-- [ Header ] start -->
    <header class="navbar pcoded-header navbar-expand navbar-light header-dark sticky-top z-3">


        <div class="m-header sticky-top">
            <a class="mobile-menu fs-3" id="mobile-collapse" href="#"><span></span></a>
            <a href="" class="b-brand">
                <!-- ========   change your logo hear   ============ -->
                <a href="{{ route('dashboard-home') }}"> <img src="{{ asset('assets/images/adm.png') }}"
                        alt="" class="logo" width="100px">
                </a>
                <img src="{{ asset('assets/images/logo-icon.png') }}" alt="" class="logo-thumb">
            </a>
            <a href="{{ route('doLogout') }}" class="mob-toggler">
                <i class="bi bi-box-arrow-right me-2"></i>
            </a>
        </div>
        <div class="collapse navbar-collapse">

            <ul class="navbar-nav mr-auto d-none d-lg-block">
                <li>
                    <i class="bi bi-calendar4 me-2"></i>
                    <h6 id="date" class="py-0 my-0 d-inline"></h6>
                </li>
                <li>
                    <i class="bi bi-clock me-2"></i>
                    <h6 id="clock" class="py-0 my-0 d-inline"></h6>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto d-none d-lg-block">

                <li class="d-flex gap-4">


                    <div class="dropdown">
                        <i class="bi bi-list fs-2" type="button" data-bs-toggle="dropdown"
                            aria-expanded="true"></i>
                        <ul class="dropdown-menu dropdown-menu-lg-end py-0">
                            <li class="dropdown-itemm"><a class="dropdown-item fs-6" style="padding-right: 200px"
                                    href="{{ route('dashboard-home') }}"><i class="bi bi-house me-2"></i>Home</a>
                            </li>
                            <li class="dropdown-itemm"><a href="{{ route('profile') }}"
                                    class="dropdown-item fs-6"><i class="bi bi-person-fill me-2"></i>Profile</a>
                            </li>
                            <li class="dropdown-itemm"><a class="dropdown-item fs-6" style="padding-right: 200px"
                                    href="{{ route('doLogout') }}"><i
                                        class="bi bi-box-arrow-left me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>


    </header>
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    @yield('content')
    @yield('script')

    <!-- [ Header ] end -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('assets/js/vendor-all.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/pcoded.min.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/chart-apex.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
    {{-- <script>
        console.log(alerts);
        // Ambil semua elemen alert
        var alerts = document.querySelectorAll('.alert-hilang');

        // Untuk setiap elemen alert
        alerts.forEach(function(alert) {
            // Jeda selama 3 detik, kemudian sembunyikan alert
            setTimeout(function() {
                alert.style.setProperty('display', 'none', 'important');
            }, 15000);
        });
    </script> --}}
    <script>
        function updateClock() {
            var currentTime = new Date();
            var hours = currentTime.getHours();
            var minutes = currentTime.getMinutes();
            var seconds = currentTime.getSeconds();

            // Tambahkan angka 0 di depan jika nilai jam, menit, atau detik kurang dari 10
            hours = (hours < 10 ? "0" : "") + hours;
            minutes = (minutes < 10 ? "0" : "") + minutes;
            seconds = (seconds < 10 ? "0" : "") + seconds;

            // Update teks pada elemen <p>
            document.getElementById('clock').innerText = hours + ":" + minutes + ":" + seconds;
        }

        // Panggil fungsi updateClock setiap detik
        setInterval(updateClock, 1000);
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Dapatkan elemen h6 yang menampilkan tanggal
            var dateElement = document.getElementById('date');

            // Buat objek tanggal
            var today = new Date();

            // Format tanggal ke format yang diinginkan (misalnya: "21 March 2024")
            var options = {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            };

            var formattedDate = today.toLocaleDateString('en-US', options);

            // Atur teks pada elemen h6 menjadi tanggal hari ini
            dateElement.textContent = formattedDate;
        });
    </script>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>INSIGNIA - Admin Dashboard</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link rel="icon" href="{{ asset('images/favicon.ico') }}">

    <!-- Favicons -->
    <link href="assets/HomeAdmin/img/favicon.png" rel="icon">
    <link href="assets/HomeAdmin/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.8/semantic.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.semanticui.min.css">

    <link href="{{ asset('assets/HomeAdmin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/HomeAdmin/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/HomeAdmin/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/HomeAdmin/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/HomeAdmin/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/HomeAdmin/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/HomeAdmin/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/HomeAdmin/css/style.css') }}" rel="stylesheet">

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="#" class="logo d-flex align-items-center">
                <img src="assets/HomeAdmin/img/logo.png" alt="">
                <span class="d-none d-lg-block">Komite Body</span>
            </a>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->




                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                        data-bs-toggle="dropdown">
                        <img src="{{ asset('images/profile.jpg') }}" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ $user->name }}</span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>{{ $user->name }}</h6>
                            <span>{{ $user->npk }}</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('dashboard-home') }}">
                                <i class="bi bi-house"></i>
                                <span>Home</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('home') }}">
                                <i class="bi bi-pencil-square"></i>
                                <span>MOCI</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('home-ks') }}">
                                <i class="bi bi-collection"></i>
                                <span>Knowledge Management</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('doLogout') }}">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar collapsed">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link " href="{{ route('adminHome') }}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{ route('adminSlides') }}">
                    <i class="bi bi-chevron-double-right"></i>
                    <span>Slides</span>
                </a>
            </li>
        </ul>
    </aside>

    @yield('content')
    @yield('script')

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer" style="position: relative; bottom: 0;">
        <div class="copyright">
            &copy; Copyright <strong><span>Komite</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
            Designed by <a href="#">Komite</a>
        </div>
    </footer><!-- End Footer -->
    <script>
        function previewFile() {
            const preview = document.getElementById('previewImage');
            const file = document.getElementById('formFile').files[0];
            const reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
                preview.style.display = 'block';
            };

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        }
    </script>
    <script>
        function previewFile2() {
            const preview = document.getElementById('previewImage2');
            const file = document.getElementById('formFile2').files[0];
            const reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
                preview.style.display = 'block';
            };

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        }
    </script>
    <script>
        function previewFile3() {
            const preview = document.getElementById('previewImage3');
            const file = document.getElementById('formFile3').files[0];
            const reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
                preview.style.display = 'block';
            };

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        }
    </script>
    <script>
        function previewFile4() {
            const preview = document.getElementById('previewImage4');
            const file = document.getElementById('formFile4').files[0];
            const reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
                preview.style.display = 'block';
            };

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        }
    </script>

    <!-- HomeAdmin/Vendor JS Files -->
    <script src="{{ asset('assets/HomeAdmin/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/HomeAdmin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="assets/HomeAdmin/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/HomeAdmin/vendor/echarts/echarts.min.js"></script>
    <script src="assets/HomeAdmin/vendor/quill/quill.js"></script>
    <script src="assets/HomeAdmin/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/HomeAdmin/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/HomeAdmin/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/HomeAdmin/js/main.js') }}"></script>

</body>

</html>

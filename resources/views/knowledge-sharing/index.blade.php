<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('images/favicon.ico') }}">

    <title>MOCI - Monitoring Continuous Improvement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('daterangepicker.css') }}" />
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    {{-- <link href="assets/KnowShare/aos/aos.css" rel="stylesheet"> --}}
    <link href="assets/KnowShare/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/KnowShare/swiper/swiper-bundle.min.css" rel="stylesheet">
    {{-- main css --}}
    <link href="assets/KnowShare/main.css" rel="stylesheet">

</head>

<body class="bg-light">
    @include('alert')
    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container position-relative d-flex align-items-center justify-content-between">
            <a href="{{ route('dashboard-home') }}" class="navbar-brand mt-2"><img src="assets/images/adm.png"
                    alt="" width="100px"></a>
            @if (!$search and !$filter)
                <nav id="navmenu" class="navmenu">
                    <ul>
                        <li><a href="{{ route('dashboard-home') }}" class="fw-bold">HOME</a></li>
                        <li class="nav-link"><a href="{{ route('home-ks') }}" class="fw-bold"
                                style="color: #6420aa !important;">KNOWLEDGE
                                MANAGEMENT</a>
                        </li>
                        <li><a href="{{ route('home') }}" class="fw-bold">MOCI</a></li>
                        @if ($userRole == 'Superadmin')
                            <li><a href="#" onclick="setFilter('safety')" class="fw-bold">ADMIN</a></li>
                        @endif
                    </ul>
                </nav>
                <a class="btn btn-getstarted py-2 mt-2" href="{{ route('doLogout') }}"><i
                        class="bi bi-box-arrow-left me-2"></i>Logout</a>
            @elseif($filter or $search)
                <div class="row col-6">
                    <form action="#" class="sign-up-form d-flex">

                        <div class="input-group w-100">
                            <input class="form-control text-dark col-6" type="search" placeholder="Search"
                                aria-label="Search" name="search" value="{{ $search }}">
                            {{-- <input type="submit" class="btn btn-primary" value="Cari"> --}}
                            <button class="btn btn-primary py-2" type="submit"><i class="bi bi-search"></i></button>
                        </div>

                    </form>

                </div>
                <div class="dropdown">
                    {{-- <button class="btn btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-list"></i>
                    </button> --}}
                    <i class="bi bi-list fs-2" type="button" data-bs-toggle="dropdown" aria-expanded="false"></i>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item fs-6" style="padding-right: 200px"
                                href="{{ route('dashboard-home') }}"><i class="bi bi-house me-2"></i>Home</a></li>
                        <li><a class="dropdown-item fs-6" style="padding-right: 200px" href="{{ route('home') }}"><i
                                    class="bi bi-pencil-square me-2"></i>Moci</a>
                        </li>
                        <li><a class="dropdown-item fs-6" style="padding-right: 200px"
                                href="{{ route('doLogout') }}"><i class="bi bi-box-arrow-left me-2"></i>Logout</a></li>
                    </ul>
                </div>
            @endif

            {{-- <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0"> --}}
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <!-- <img src="assets/img/logo.png" alt=""> -->
            {{-- <h1 class="sitename">Append</h1><span>.</span> --}}
            {{-- </a> --}}




        </div>
    </header>
    <div class="border-bottom pt-2 bg-white ">
        <nav class="navmenu mx-auto container">
            <ul class="nav">
                <li class="nav-link px-3 py-0">
                    <a href="#knowledge" onclick="setFilter('safety')" class="nav-item py-2 px-0"
                        id="filter-safety">Safety</a>
                </li>
                <li class="nav-link px-3 py-0">
                    <a href="#knowledge" onclick="setFilter('quality')" class="nav-item py-2 px-0"
                        id="filter-quality">Quality</a>
                </li>
                <li class="nav-link px-3 py-0">
                    <a href="#knowledge" onclick="setFilter('cost')" class="nav-item py-2 px-0"
                        id="filter-cost">Cost</a>
                </li>
                <li class="nav-link px-3 py-0">
                    <a href="#knowledge" onclick="setFilter('delivery')" class="nav-item py-2 px-0"
                        id="filter-delivery">Delivery</a>
                </li>
                <li class="nav-link px-3 py-0">
                    <a href="#knowledge" onclick="setFilter('morale')" class="nav-item py-2 px-0"
                        id="filter-morale">Morale</a>
                </li>
                <li class="nav-link px-3 py-0">
                    <a href="#knowledge" onclick="setFilter('environment')" class="nav-item py-2 px-0"
                        id="filter-environment">Environment</a>
                </li>
            </ul>
        </nav>
    </div>



    @if ($search or $filter)
        <div class="container min-vh-100 bg-light" id="knowledge">
            <div class="container section-title mt-5 py-5" data-aos="fade-up">
                <h2>Knowledge Management</h2>
                {{-- <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p> --}}
            </div>

            <div class="card my-0 row">

                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <H1 class="mt-2">
                            @if ($search)
                                Result for '{{ $search }}'
                            @endif
                        </H1>
                        @if ($userRole == 'Superadmin')
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-purple col-auto text-center my-3 mb-md-3 px-2"
                                    data-bs-target="#exampleModal" data-bs-toggle="modal">Upload File</button>
                                <form action="{{ route('clean-files') }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete all files?');">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-outline-danger col-auto text-center my-3 mb-md-3 px-2">Clean
                                        File</button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Upload File</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <form method="POST" action="{{ route('uploadFileKs') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <select class="form-select mb-3" aria-label="Default select example"
                                            name="category">
                                            <option selected>Select Category...</option>
                                            <option value="safety">Safety</option>
                                            <option value="quality">Quality</option>
                                            <option value="cost">Cost</option>
                                            <option value="delivery">Delivery</option>
                                            <option value="morale">Morale</option>
                                            <option value="environment">Environment</option>
                                        </select>
                                        <input type="text" class="form-control mb-3" name="problem"
                                            placeholder="Isi Problem Disini..." required>
                                        <input type="text" class="form-control mb-3" name="improvement"
                                            placeholder="Isi Improvement Disini..." required>
                                        <input type="file" class="form-control mb-3" name="file" required>

                                        <button type="submit" class="btn btn-primary col-12">SUBMIT</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Section Title -->
                    @if ($files->isEmpty())
                        <div class="d-flex justify-content-center flex-column gap-1">
                            <img src="{{ asset('images/no-results.png') }}" alt=""
                                class="mx-auto text-center mb-3 opacity-50" width="100px">
                            <i class="mx-auto text-center">Tidak ada file...</i>
                        </div>
                    @else
                        <table class="table table-hover">
                            <thead class="table-light">

                            </thead>
                            <tbody>
                                @foreach ($files as $item)
                                    <tr onclick="openPDF('{{ asset($item->file) }}')" style="cursor: pointer;">
                                        <td colspan="2">{{ $item->file }} </td>
                                        <td class="col-2 text-center">{{ $item->created_at->format('j F Y') }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    @elseif(!$search or !$filter)
        <!-- Hero Section -->
        <section id="hero" class="hero section py-1">
            <img src="images/Daihatsu.png" alt="">
            <div class="container" data-aos="fade-right">
                <div class="row">
                    <div class="col-lg-10">
                        <h2>Welcome To Knowledge Management</h2>
                        <p>Membantu sahabat dalam mencari pengetahuan</p>
                    </div>
                    <div class="col-lg-5">
                        <form action="#" class="sign-up-form d-flex">
                            <input class="form-control text-dark" type="search" placeholder="Search"
                                aria-label="Search" name="search" value="{{ $search }}">
                            {{-- <input type="submit" class="btn btn-primary" value="Cari"> --}}
                            <button class="btn btn-primary" type="submit">Cari</button>

                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Hero Section -->
    @endif

    {{-- <div id="preloader">
        <div class="line"></div>
    </div> --}}

    <script>
        // Fungsi untuk mengambil nilai parameter dari URL
        function getQueryParam(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        // Fungsi untuk menambahkan kelas aktif pada elemen yang sesuai
        function setActiveFilter() {
            const filter = getQueryParam('filter');

            // Hapus kelas aktif dari semua elemen nav-item
            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.remove('active');
            });

            // Tambahkan kelas aktif pada elemen yang sesuai
            if (filter) {
                const activeElement = document.getElementById(`filter-${filter}`);
                if (activeElement) {
                    activeElement.classList.add('active');
                }
            }
        }

        // Panggil fungsi untuk mengatur kelas aktif saat halaman dimuat
        window.onload = setActiveFilter;
    </script>

    <script>
        function openPDF(pdfUrl) {
            // Mendapatkan nama file dari URL
            var fileName = pdfUrl.substring(pdfUrl.lastIndexOf('/') + 1);
            // Membuat URL baru dengan menambahkan nama direktori "KnowledgeSharing" dan nama file
            var newPdfUrl = '{{ asset('KnowledgeSharing') }}/' + fileName;
            // Membuka file PDF di jendela baru
            window.open(newPdfUrl, '_blank');
        }
    </script>
    <script>
        function setFilter(value) {
            filterCategory(value);
        }

        function filterCategory(value) {
            location.href = `?filter=${value}`;
        }

        function setSearch(value) {
            filterCategory(value);
        }

        function searchCategory(value) {
            location.href = `?search=${value}`;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>


    <!-- Vendor JS Files -->
    <script src="assets/KnowShare/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/KnowShare/php-email-form/validate.js"></script>
    <script src="assets/KnowShare/aos/aos.js"></script>
    <script src="assets/KnowShare/glightbox/js/glightbox.min.js"></script>
    <script src="assets/KnowShare/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/KnowShare/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="assets/KnowShare/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/KnowShare/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="assets/KnowShare/main.js"></script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>

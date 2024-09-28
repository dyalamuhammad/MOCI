<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>INSIGNIA - Home</title>
    <link rel="icon" href="{{ asset('images/favicon.ico') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">


    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}"> --}}
    <!-- Icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fonts/line-icons.css') }}">
    <!-- Slicknav -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/slicknav.css') }}">
    <!-- Nivo Lightbox -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/nivo-lightbox.css') }}">
    <!-- Animate -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/animate.css') }}">
    <!-- Main Style -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/main.css') }}">
    <!-- Responsive Style -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
    {{-- manrope font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->




</head>

<body>
    @include('alert')
    <!-- Header Area wrapper Starts -->
    <header id="header-wrap" data-bs-theme='dark'>
        <!-- Navbar Start -->
        <header id="header" class="header d-flex align-items-center fixed-top bg-light">
            <div class="container position-relative d-flex align-items-center justify-content-between">
                <a href="#" class="navbar-brand"><img src="assets/images/adm.png" alt=""
                        width="100px"></a>
                <nav id="navmenu" class="navmenu">
                    <ul>
                        <li><a href="#main-slide" class="fw-bold nav-link">HOME</a></li>
                        <li><a href="#about" class="fw-bold nav-link">APPLICATION</a></li>
                        <li><a href="#team" class="fw-bold nav-link">ABOUT</a>

                            @auth
                                @if (auth()->user()->jabatan == 'Superadmin')
                            <li><a href="{{ route('adminHome') }}" class="fw-bold nav-link">ADMIN</a></li>
                            @endif
                        @endauth

                    </ul>
                </nav>
                @if (auth()->check())
                    <a class="btn btn-gradient rounded-2 fw-bold px-4 py-2" href="{{ route('doLogout') }}"><i
                            class="bi bi-box-arrow-left me-2"></i>LOGOUT</a>
                @else
                    <a class="btn btn-gradient rounded-2 fw-bold px-4 py-2" href="{{ route('doLogin') }}"><i
                            class="bi bi-box-arrow-in-right me-2"></i>LOGIN</a>
                @endif

            </div>
        </header>

        <!-- Navbar End -->

        <!-- Main Carousel Section Start -->
        <div id="main-slide" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                @foreach ($slides as $index => $slide)
                    <li data-target="#main-slide" data-slide-to="{{ $index }}"
                        class="{{ $index == 0 ? 'active' : '' }}"></li>
                @endforeach
            </ol>
            <div class="carousel-inner">
                @foreach ($slides as $index => $slide)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <img class="d-block w-100" src="{{ asset($slide->img_url) }}" alt="Slide {{ $index + 1 }}"
                            loading="lazy" style="filter: brightness(80%); object-fit: cover">
                        <div class="carousel-caption d-md-block">
                            <p class="fadeInUp wow" data-wow-delay=".6s">{{ $slide->description }}</p>
                            <h1 class="wow fadeInDown heading" data-wow-delay=".4s">{{ $slide->title }}</h1>
                            <a href="{{ $slide->link }}" class="fadeInRight wow btn btn-border btn-lg"
                                data-wow-delay=".6s" target="blank">Explore
                                More</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#main-slide" role="button" data-slide="prev">
                <span class="carousel-control" aria-hidden="true"><i class="bi bi-chevron-left"></i></span>
            </a>
            <a class="carousel-control-next" href="#main-slide" role="button" data-slide="next">
                <span class="carousel-control" aria-hidden="true"><i class="bi bi-chevron-right"></i></span>
            </a>
        </div>

        <!-- Main Carousel Section End -->

    </header>
    <!-- Header Area wrapper End -->
    <div class="background-wrapper">
        <!-- About Section Start -->
        <section id="about" class="section-padding">
            <div class="container">
                <div class="row" data-aos="fade-down">
                    <div class="col-12">
                        <div class="section-title-header text-center">
                            <h1 class="section-title">Application</h1>
                        </div>
                    </div>
                </div>
                <div class="row" data-aos="fade-up">
                    <div class="col-xs-12 col-md-6 col-lg-6">
                        <div class="about-item app" onclick="window.location.href='{{ route('pra-moci') }}'"
                            style="cursor: pointer">
                            <img class="w-100" src="images/bg-1.jpg" alt="" loading="lazy">
                            <div class="about-text">
                                <h3 class="fw-bold"><a href="{{ route('pra-moci') }}">MOCI</a></h3>
                                <p>Monitoring Continous Improvement </p>
                                <!-- <a class="btn btn-common btn-rm" href="#">Read More</a> -->
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-6 col-lg-6">
                        <div class="about-item app" onclick="window.location.href='{{ route('home-ks') }}'"
                            style="cursor: pointer">
                            <img class="w-100" src="images/bg.jpg" alt="" loading="lazy">
                            <div class="about-text">
                                <h3 class="fw-bold"><a href="{{ route('home-ks') }}">KNOWLEDGE MANAGEMENT</a></h3>
                                <p>Menampilkan data informasi reporting problem proses manufacture</p>
                                <!-- <a class="btn btn-common btn-rm" href="#">Read More</a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- About Section End -->

        @if ($fyAdm && $fyBody && $bodyMaps && $structure)
            <!-- Team Section Start -->
            <section id="team" class="section-padding text-center" data-aos="fade-up">
                <div class="container mb-5">
                    <div class="row">
                        <div class="col-12">
                            <div class="section-title-header text-center">
                                <h1 class="section-title wow fadeInUp" data-wow-delay="0.2s">FY ADM
                                    {{ now()->year }}
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div class="row" data-aos="fade-up">
                        <div class="col-lg-8 col-12 mx-auto">
                            <div class="about-item">
                                <img class="w-100 rounded-2" src="{{ asset($fyAdm) }}" alt=""
                                    data-bs-toggle="modal" data-bs-target="#modalAdm" loading="lazy">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container mb-5">
                    <div class="row">
                        <div class="col-12">
                            <div class="section-title-header text-center">
                                <h1 class="section-title wow fadeInUp" data-wow-delay="0.2s">FY BODY
                                    {{ now()->year }}
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div class="row" data-aos="fade-up">
                        <div class="col-lg-8 col-12 mx-auto">
                            <div class="about-item">
                                <img class="w-100 rounded-2" src="{{ asset($fyBody) }}" alt=""
                                    data-bs-toggle="modal" data-bs-target="#modalFy" loading="lazy">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container mb-5">
                    <div class="row">
                        <div class="col-12">
                            <div class="section-title-header text-center">
                                <h1 class="section-title wow fadeInUp" data-wow-delay="0.2s">BODY MAPS
                                    {{ now()->year }}
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div class="row" data-aos="fade-up">
                        <div class="col-lg-8 col-12 mx-auto">
                            <div class="about-item">
                                <img class="w-100 rounded-2" src="{{ asset($bodyMaps) }}" alt=""
                                    data-bs-toggle="modal" data-bs-target="#modalBody" loading="lazy">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container mb-5">
                    <div class="row">
                        <div class="col-12">
                            <div class="section-title-header text-center">
                                <h1 class="section-title wow fadeInUp" data-wow-delay="0.2s">STRUCTURE BODY
                                    {{ now()->year }}
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div class="row" data-aos="fade-up">
                        <div class="col-lg-8 col-12 mx-auto">
                            <div class="about-item">
                                <img class="w-100 rounded-2" src="{{ asset($structure) }}" alt=""
                                    data-bs-toggle="modal" data-bs-target="#modalStructure">
                            </div>
                        </div>
                    </div>




                </div>
            </section>
            <!-- Team Section End -->
        @endif
    </div>

    <!-- Modal -->
    <!-- Modal Fy Adm-->
    <div class="modal fade" id="modalAdm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-uppercase" id="exampleModalLabel">Fy ADM
                        {{ now()->year }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img class="w-100 rounded-2" src="{{ asset($fyAdm) }}" alt="">
                </div>

            </div>
        </div>
    </div>
    <!-- Modal Fy Body-->
    <div class="modal fade" id="modalFy" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-uppercase" id="exampleModalLabel">Fy Body
                        {{ now()->year }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img class="w-100 rounded-2" src="{{ asset($fyBody) }}" alt="">
                </div>

            </div>
        </div>
    </div>
    <!-- Modal Body Map-->
    <div class="modal fade" id="modalBody" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-uppercase" id="exampleModalLabel">Body Maps
                        {{ now()->year }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img class="w-100 rounded-2" src="{{ asset($bodyMaps) }}" alt="">
                </div>

            </div>
        </div>
    </div>
    <!-- Modal Structure -->
    <div class="modal fade" id="modalStructure" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-uppercase" id="exampleModalLabel">Stucture Body
                        {{ now()->year }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img class="w-100 rounded-2" src="{{ asset($structure) }}" alt="">
                </div>

            </div>
        </div>
    </div>

    <footer>
        <div class="sticky-bottom py-5">
            <p class="text-center fs-6">Created with ❤️ By <b>Committe Body Division</b></p>
        </div>
    </footer>

    <!-- Go to Top Link -->
    <a href="#" class="back-to-top">
        <i class="bi bi-chevron-up"></i>
    </a>

    <div id="preloader">
    </div>



    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('assets/js/jquery-min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nav.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('assets/js/nivo-lightbox.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="assets/js/form-validator.min.js"></script>
    <script src="assets/js/contact-form-script.min.js"></script>
    <script src="assets/js/map.js"></script>
    <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=AIzaSyCsa2Mi2HqyEcEnM1urFSIGEpvualYjwwM">
    </script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
</body>

</html>

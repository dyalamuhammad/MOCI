<!DOCTYPE html>
<html lang="en">

<head>

    <title>{{ env('APP_NAME') }}-login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Phoenixcoded" />
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- vendor css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">





</head>
<style>
    .bg-green {
        background: linear-gradient(to top right, rgba(16, 16, 139, 1), rgba(26, 188, 156, 1));
        position: relative;
        overflow: hidden;
    }
</style>

<body data-bs-theme="light">

    <!-- [ auth-signin ] start -->

    <div class="row mx-auto vh-100 mx-0 auth-wrapper" data-aos="fade-up" data-aos-duration="1000">
        <div class="d-flex mt-0 justify-content-end position-absolute top-0 p-5">
            <img src="https://th.bing.com/th/id/R.490295d463b3f017b8c36eb8ff3a74c6?rik=HvPzJ4cPo%2fPDDw&riu=http%3a%2f%2fwww.daihatsukediri.id%2fwp-content%2fuploads%2f2017%2f10%2fDaihatsu-logo-1.png&ehk=uwjdVHeP%2bOep2gmz8X8fWiroP0v3sJLNKnBr1zT65Yo%3d&risl=&pid=ImgRaw&r=0"
                alt="" width="150px">
            <img src="https://adm-hrd.daihatsu.astra.co.id/PM2/Assets/images/Icare.png" alt=""
                style="width: 150px">
        </div>
        <div class="col-12 col-sm-5 position-absolute top-0 mt-2">

            @include('alert')
        </div>
        <div class="col-sm-10 d-flex justify-content-center justify-content-md-end me-5">
            <div class="auth-content">
                <h6 class="text-center fw-bold fs-1 text-blue">MOCI</h6>
                <div class="card card-primary border-0"
                    style="background: white; box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.24);
					-webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.24);
					-moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.24);">
                    <div class="row">
                        <div class="col-12">

                            <div class="card-body" data-aos="fade-up">

                                <form action="{{ route('doLogin') }}" method="post">
                                    @csrf
                                    <div class="form-floating mb-3">
                                        <input type="number" name="npk"
                                            class="form-control border-0 rounded-0 border-bottom border-dark pb-2 bg-opacity-10 input-login"
                                            id="floatingInput" placeholder="npk" required>
                                        <label for="floatingInput">NPK</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="password" name="password"
                                            class="form-control border-0 rounded-0 border-bottom border-dark pb-2 bg-opacity-10 input-login"
                                            id="floatingInput" placeholder="npk" required>
                                        <label for="floatingInput">Password</label>
                                    </div>
                                    <button class="btn col-12 btn-green rounded-3 mt-2" type="submit">Sign in</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- [ auth-signin ] end -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>

    <script>
        console.log(alerts);
        // Ambil semua elemen alert
        var alerts = document.querySelectorAll('.alert');

        // Untuk setiap elemen alert
        alerts.forEach(function(alert) {
            // Jeda selama 3 detik, kemudian sembunyikan alert
            setTimeout(function() {
                alert.style.setProperty('display', 'none', 'important');
            }, 5000);
        });
    </script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>

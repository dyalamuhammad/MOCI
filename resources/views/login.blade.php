<!DOCTYPE html>
<html lang="en">

<head>

    <title>ADM - Login</title>
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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- vendor css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    {{-- bootstrap 5.3 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{-- bootstrap icon --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    {{-- font awesome icon --}}
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">





</head>
<style>
    .login-wrapper {
        background: url(images/bg-login.jpg);
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
    }

    .bg-green {
        background: linear-gradient(to top right, rgba(16, 16, 139, 1), rgba(26, 188, 156, 1));
        position: relative;
        overflow: hidden;
    }

    #video {
        width: 100%;
        max-width: 600px;
        border: 2px solid #000;
    }
</style>

<body data-bs-theme="light">
    @include('alert')
    <!-- [ auth-signin ] start -->
    <div class=" vh-100 login-wrapper">
        <div class="d-flex mt-0 justify-content-end position-absolute top-0 p-5 w-100" data-aos="fade-left">
            <img src="https://th.bing.com/th/id/R.490295d463b3f017b8c36eb8ff3a74c6?rik=HvPzJ4cPo%2fPDDw&riu=http%3a%2f%2fwww.daihatsukediri.id%2fwp-content%2fuploads%2f2017%2f10%2fDaihatsu-logo-1.png&ehk=uwjdVHeP%2bOep2gmz8X8fWiroP0v3sJLNKnBr1zT65Yo%3d&risl=&pid=ImgRaw&r=0"
                alt="" height="48px" class="align-bottom">
            <img src="https://adm-hrd.daihatsu.astra.co.id/PM2/Assets/images/Icare.png" alt=""
                style="height: 48px" class="align-bottom">
            <img src="{{ asset('images/logo_body.jpg') }}" alt="" style="height: 68px">
        </div>
        <div class="container pt-5">
            <div class="row gap-5">
                <div class="col-12 col-xl-6 align-content-center" data-aos='fade-up'>
                    <img src="{{ asset('images/login-1.png') }}" alt="" class="w-100">
                </div>
                <div class="col-12 col-xl-5 align-content-center px-5" data-aos='fade-up'>
                    <h1 class="fw-bold mb-3">Login</h1>
                    {{-- form login --}}
                    <form action="{{ route('doLogin') }}" method="post">
                        @csrf
                        <div class="d-flex gap-3">
                            <i class="fa fa-user fs-4 my-auto"></i>
                            <div class="form-floating mb-3 col-11">
                                <input type="number" name="npk"
                                    class="form-control border-0 rounded-0 border-bottom border-dark pb-2 input-login"
                                    id="floatingInput" placeholder="npk" required>
                                <label for="floatingInput" class="fw-normal">NPK</label>
                            </div>
                        </div>
                        <div class="d-flex gap-3">
                            <i class="fa fa-lock fs-4 my-auto"></i>
                            <div class="form-floating mb-3 col-11">
                                <input type="password" name="password"
                                    class="form-control border-0 rounded-0 border-bottom border-dark pb-2 input-login"
                                    id="floatingInput" placeholder="npk" required>
                                <label for="floatingInput" class="fw-normal">Password</label>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-5 gap-3">

                            <button class="btn col-6 btn-purple rounded-3" type="submit">Sign
                                in</button>
                            <button class="btn col-6 btn-purple rounded-3" type="button" id="startScanButton">Scan
                                Face</button>
                        </div>
                    </form>
                    {{-- form login --}}

                    <!-- Bootstrap Modal -->
                </div>
                <div class="modal fade" id="faceScanModal" tabindex="-1" aria-labelledby="faceScanModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="faceScanModalLabel">Scanning Wajah</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <img id="video" width="100%" height="auto" alt="Streaming Video">
                                <canvas id="canvas" style="display:none;"></canvas>
                                <p id="status" class="mt-3"></p>
                                <p id="auth-message" class="text-danger"></p>
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const faceScanModal = new bootstrap.Modal(document.getElementById("faceScanModal"));
            const videoElement = document.getElementById("video");
            let intervalId = null;
            let timeoutId = null; // Untuk menyimpan ID timeout

            function startFaceScan() {
                videoElement.src = "http://127.0.0.1:5000/video_feed"; // Mulai streaming video
                faceScanModal.show(); // Tampilkan modal
                intervalId = setInterval(checkFaceStatus, 3000); // Cek status wajah setiap 2 detik

                // Set timeout untuk 10 detik
                timeoutId = setTimeout(() => {
                    stopFaceScan(); // Hentikan scan
                    Swal.fire({
                        icon: 'error',
                        title: 'Deteksi Wajah Gagal',
                        text: 'Wajah tidak dikenali!',
                    });
                }, 10000); // 10 detik
            }

            function stopFaceScan() {
                clearInterval(intervalId); // Hentikan interval polling
                clearTimeout(timeoutId); // Hentikan timeout
                videoElement.src = "";
                faceScanModal.hide(); // Tutup modal
            }

            function checkFaceStatus() {
                console.log("📢 Memanggil /face_status..."); // Debug log di browser
                fetch('http://127.0.0.1:5000/face_status')
                    .then(response => {
                        console.log("📢 Received response:", response);
                        return response.text(); // Ambil response dalam bentuk teks dulu
                    })
                    .then(text => {
                        console.log("📢 Raw response dari server:", text);
                        return JSON.parse(text); // Ubah ke JSON manual
                    })
                    .then(data => {
                        console.log("📢 Response dari server:", data); // Debug response dari server
                        document.getElementById("status").innerHTML = data.message;
                        if (data.redirect) {
                            console.log("📢 melakukan fetch ke /set-face-auth");
                            fetch('/login-face', {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                            .getAttribute('content')
                                    },
                                    body: JSON.stringify({
                                        npk: data.npk
                                    })
                                })
                                .then(response => response.json())
                                .then(sessionData => {
                                    if (sessionData.success) {
                                        clearInterval(intervalId);
                                        clearTimeout(timeoutId);
                                        stopFaceScan(); // Hentikan polling setelah sukses
                                        window.location.href =
                                            "/dashboard-moci"; // Redirect ke halaman home
                                    } else {
                                        document.getElementById("auth-message").innerText =
                                            "Autentikasi gagal!";
                                    }
                                });
                        }
                    })
                    .catch(error => console.error("Error:", error));
            }

            // Panggil startFaceScan saat scan wajah dimulai
            document.getElementById("startScanButton").addEventListener("click", startFaceScan);

            // Tambahkan logika untuk menutup modal setelah scan selesai
            document.getElementById("faceScanModal").addEventListener("hidden.bs.modal", stopFaceScan);
        });
    </script>

</body>

</html>

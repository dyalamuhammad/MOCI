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
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            @include('alert')
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Register Face</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i
                                            class="bi bi-house"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#!">Register Face</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row gap-1 justify-content-between">

                <div class="card col-12">
                    <div class="card-body">
                        <form action="{{ route('storeFace') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="user_id" class="form-label">User ID</label>
                                <input type="text" id="user_id" class="form-control" name="user_id" required>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" class="form-control" name="name" required>
                            </div>
                            <div class="mb-3 d-flex">
                                <div class="col-6">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" id="image" class="form-control mb-3 col-6" name="image"
                                        accept="image/*" required>
                                </div>
                                <h5 class="px-5 my-auto">or</h5>
                                <div class="col-6">
                                    <label for="image" class="form-label d-block">Capture Photo</label>
                                    <button id="captureButton" class="btn btn-primary" type="button">Capture</button>
                                </div>


                                <div id="preview" class="mt-3"></div>

                            </div>
                            <button class="btn btn-green" type="submit">Submit</button>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        const captureButton = document.getElementById('captureButton');
        const imageInput = document.getElementById('image');
        const preview = document.getElementById('preview');

        // Event listener for the file input
        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML =
                        `<img src="${e.target.result}" alt="Image Preview" class="img-fluid" />`;
                };
                reader.readAsDataURL(file);
            }
        });

        // Event listener for the capture button
        captureButton.addEventListener('click', function() {
            // Check if the device supports getUser Media
            if (navigator.mediaDevices && navigator.mediaDevices.getUser Media) {
                navigator.mediaDevices.getUser Media({
                        video: true
                    })
                    .then(function(stream) {
                        const video = document.createElement('video');
                        video.srcObject = stream;
                        video.play();
                        document.body.appendChild(video);

                        const capturePhoto = document.createElement('button');
                        capturePhoto.innerText = 'Take Photo';
                        document.body.appendChild(capturePhoto);

                        capturePhoto.addEventListener('click', function() {
                            const canvas = document.createElement('canvas');
                            canvas.width = video.videoWidth;
                            canvas.height = video.videoHeight;
                            const context = canvas.getContext('2d');
                            context.drawImage(video, 0, 0);
                            const imageData = canvas.toDataURL('image/png');

                            // Stop the video stream
                            stream.getTracks().forEach(track => track.stop());
                            document.body.removeChild(video);
                            document.body.removeChild(capturePhoto);

                            // Display the captured image
                            preview.innerHTML =
                                `<img src="${imageData}" alt="Captured Image" class="img-fluid" />`;
                        });
                    })
                    .catch(function(err) {
                        console.error("Error accessing camera: " + err);
                    });
            } else {
                alert("Camera not supported on this device.");
            }
        });
    </script>
</body>

</html>

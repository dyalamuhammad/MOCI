<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Face Recognition</title>
    <style>
        #video {
            display: none;
            width: 100%;
            max-width: 600px;
            border: 2px solid #000;
        }
    </style>
</head>

<body>
    <h1>Face Recognition</h1>
    <button onclick="startScanFace()" id="startScanFaceBtn">Scan Face</button>
    <button onclick="stopScanFace()" id="stopScanFaceBtn">Stop Scan Face</button>
    <img id="video" alt="Video Feed">

    <script>
        const startScanFaceBtn = document.getElementById('startScanFaceBtn');
        const stopScanFaceBtn = document.getElementById('stopScanFaceBtn');
        const video = document.getElementById('video');
        let intervalId = null;

        // Fungsi untuk memulai streaming kamera
        startScanFaceBtn.addEventListener('click', () => {
            video.src = 'http://127.0.0.1:5001/video_feed'; // Ganti dengan URL Flask API untuk streaming kamera
            video.style.display = 'block';
        });

        // Fungsi untuk memeriksa status pengenalan wajah
        function checkFaceStatus() {
            fetch('http://127.0.0.1:5001/face_status') // Ganti dengan URL Flask API untuk status wajah
                .then(response => response.json())
                .then(data => {
                    if (data.redirect) {
                        const name = encodeURIComponent(data.name); // Encode name untuk URL
                        window.location.href = `/home?name=${name}`; // Redirect ke halaman Laravel
                    } else {
                        alert(data.message);
                    }
                })
                .catch(err => console.error(err));
        }

        // Mulai pemindaian wajah dengan interval
        function startScanFace() {
            intervalId = setInterval(checkFaceStatus, 5000);
        }

        // Hentikan pemindaian wajah
        function stopScanFace() {
            video.src = ''; // Hentikan streaming kamera
            video.style.display = 'none';
            clearInterval(intervalId);
            intervalId = null;
        }
    </script>
</body>

</html>

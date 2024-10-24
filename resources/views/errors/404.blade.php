<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #FFF0F5;
        }
        .text-pink {
            color: #FF69B4;
        }
        .btn-pink {
            background-color: #FF69B4;
            border-color: #FF69B4;
        }
        .btn-pink:hover {
            background-color: #FF1493;
            border-color: #FF1493;
        }
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: .5;
            }
        }
        #loading-bar {
            width: 0;
            height: 4px;
            background-color: #FF69B4;
            position: fixed;
            top: 0;
            left: 0;
            transition: width 0.5s ease;
        }
    </style>
</head>
<body>
    <div id="loading-bar"></div>
    <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center">
        <div class="text-center">
            <h1 class="display-1 fw-bold text-pink animate-pulse">404</h1>
            <h2 class="display-4 text-pink mb-4">Oops! Halaman tidak ditemukan</h2>
            <p class="lead text-pink mb-5">
                Maaf, halaman yang Anda cari tidak dapat ditemukan atau telah dipindahkan.
            </p>
            <p class="text-pink mb-3">Anda akan diarahkan ke halaman yang ada dalam <span id="countdown">5</span> detik.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let timeLeft = 5;
        const countdownElement = document.getElementById('countdown');
        const loadingBar = document.getElementById('loading-bar');

        function updateCountdown() {
            countdownElement.textContent = timeLeft;
            timeLeft -= 1;
            if (timeLeft < 0) {
                window.location.href = "{{ url('/login') }}";
            } else {
                setTimeout(updateCountdown, 1000);
            }
        }

        function updateLoadingBar() {
            const progress = (5 - timeLeft) * 20;
            loadingBar.style.width = `${progress}%`;
            if (timeLeft >= 0) {
                requestAnimationFrame(updateLoadingBar);
            }
        }

        updateCountdown();
        updateLoadingBar();
    </script>
</body>
</html>

<!doctype html>
<html lang="en">

<head>
    <title>Masuk</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.2/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Preloader and Title Animation CSS -->
    <style>
        body {
            background: rgb(34, 242, 187);
            background: radial-gradient(circle, rgba(34, 242, 187, 1) 24%, rgba(34, 148, 242, 1) 86%);
            width: 100%;
            height: 100vh;
            margin: 0;
        }

        .bookshelf_wrapper {
            position: relative;
            top: 60%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .books_list {
            margin: 0 auto;
            width: 300px;
            padding: 0;
        }

        .book_item {
            position: absolute;
            top: -120px;
            list-style: none;
            width: 40px;
            height: 120px;
            background-color: #1e6cc7;
            border: 5px solid white;
            transform-origin: bottom left;
            transform: translateX(300px);
            opacity: 0;
            animation: travel 3s linear infinite;
        }

        .book_item.first {
            top: -140px;
            height: 140px;
        }

        .book_item.second {
            top: -120px;
            height: 120px;
        }

        .book_item.third {
            top: -100px;
            height: 100px;
        }

        .book_item.fourth {
            top: -130px;
            height: 130px;
        }

        .book_item.fifth {
            top: -110px;
            height: 110px;
        }

        .book_item.sixth {
            top: -140px;
            height: 140px;
        }

        .book_item:before,
        .book_item:after {
            content: "";
            position: absolute;
            top: 10px;
            left: 0;
            width: 100%;
            height: 5px;
            background-color: white;
        }

        .shelf {
            width: 300px;
            height: 5px;
            margin: 0 auto;
            background-color: white;
            position: relative;
        }

        /* Adjust animation for smoother sequential appearance */
        .book_item:nth-child(1) {
            animation-delay: 0s;
        }

        .book_item:nth-child(2) {
            animation-delay: 0.5s;
        }

        .book_item:nth-child(3) {
            animation-delay: 1s;
        }

        .book_item:nth-child(4) {
            animation-delay: 1.5s;
        }

        .book_item:nth-child(5) {
            animation-delay: 2s;
        }

        .book_item:nth-child(6) {
            animation-delay: 2.5s;
        }

        /* Animation keyframes */
        @keyframes travel {
            0% {
                opacity: 0;
                transform: translateX(300px) rotateZ(0deg) scaleY(1);
            }

            10% {
                opacity: 1;
                transform: translateX(270px) rotateZ(0deg);
            }

            25% {
                transform: translateX(200px) rotateZ(-30deg);
            }

            50% {
                transform: translateX(100px) rotateZ(-45deg);
            }

            75% {
                transform: translateX(50px) rotateZ(-60deg);
                opacity: 1;
            }

            100% {
                opacity: 0;
                transform: translateX(0px) rotateZ(-90deg);
            }
        }

        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #1e6cc7;
            z-index: 9999;
            text-align: center;
        }

        #content {
            display: none;
        }

        /* Title style */
        #preloader-title,#logoLoader {
            color: white;
            font-size: 2rem;
            opacity: 0;
            margin-top: 20px;
            animation: fadeInUp 2s ease-in-out forwards;
            animation-delay: 1.5s;
            /* Delay so it appears after books start */
        }

        #preloader-subtitle {
            color: white;
            font-size: 1rem;
            opacity: 0;
            margin-top: 10px;
            animation: fadeInUp 2s ease-in-out forwards;
            animation-delay: 1.5s;
            /* Delay so it appears after books start */
        }

        /* Title animation */
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .blink {
            animation: blink-animation 1s steps(5, start) infinite;
        }

        @keyframes blink-animation {
            to {
                visibility: hidden;
            }
        }
    </style>
</head>

<body>

    <!-- Preloader -->
    <div id="preloader">
        <div class="bookshelf_wrapper">
            <ul class="books_list">
                <li class="book_item first"></li>
                <li class="book_item second"></li>
                <li class="book_item third"></li>
                <li class="book_item fourth"></li>
                <li class="book_item fifth"></li>
                <li class="book_item sixth"></li>
            </ul>
            <div class="shelf"></div>
            <img id="logoLoader" src="Assets/img/fileSphere.png" alt="" style="height: 200px;">
            <div id="preloader-title">Pengelola Berkas Digital</div>
            <div id="preloader-subtitle">©2024 Muhammad Yusril romadhoni RGI 31</div>
        </div>
    </div>

    <!-- Animated title under preloader -->


    <!-- Content -->
    <div id="content">
        <section class="vh-100">
            <div class="container py-5 h-100">
                <div class="row d-flex align-items-center justify-content-center h-100">
                    <div class="col-md-8 col-lg-7 col-xl-6">
                        <img src="Assets/img/Masuk.png" class="img-fluid" alt="Phone image" height="300px" width="600px">
                    </div>
                    <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                        <form action="login.php" method="post">
                            <p class="text-center h1 fw-bold mb-4 mx-1 mx-md-3 mt-3 blink">Selamat Datang</p>
                            <p class="text-center h3 fw-bold mb-4 mx-1 mx-md-3 mt-3 blink">di Halaman Masuk 😇✨</p>

                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <label class="form-label " for="form1Example13"><i class="bi bi-person-circle"></i> Surat Elektronik</label>
                                <input type="email" id="form1Example13" class="form-control form-control-lg py-3" name="username" autocomplete="off" placeholder="Masukkan Alamat Surat Elektronik Anda disini!" style="border-radius:25px;" />
                            </div>

                            <!-- Password input -->
                            <div class="form-outline mb-4 position-relative">
                                <label class="form-label " for="form1Example23">
                                    <i class="bi bi-chat-left-dots-fill"></i> Kata Sandi
                                </label>

                                <!-- Input password -->
                                <input type="password" id="form1Example23" class="form-control form-control-lg py-3" name="password" autocomplete="off" placeholder="Masukkan Kata Sandi Anda disini!" style="border-radius:25px;" />

                                <!-- Icon Mata -->
                                <span class="position-absolute text-primary" style="top: 50%; right: 15px; cursor: pointer;">
                                    <i id="togglePassword" class="bi bi-eye-fill fs-4"></i>
                                </span>
                            </div>
                            <!-- Dropdown Level Akun -->
                            <div class="form-outline mb-4">
                                <label class="form-label" for="accountLevel"><i class="bi bi-person-badge-fill"></i> Pilih Hak Akses</label>
                                <select id="accountType" name="account_type" class="form-select form-control-lg py-3" style="border-radius:25px;">
                                    <option value="public">Public</option>
                                    <option value="private">Private</option>
                                    <option value="protected">Protected</option>
                                </select>

                            </div>
                            <!-- Submit button -->
                            <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                <input type="submit" value="Masuk" name="login" class="btn btn-success btn-lg  my-2 py-3" style="width:100%; border-radius: 30px; font-weight:600;" />
                            </div>
                        </form><br>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Preloader Script -->
    <script>
        window.onload = function() {
            setTimeout(function() {
                document.getElementById('preloader').style.display = 'none';
                document.getElementById('content').style.display = 'block';
            }, 7000); // 3-second delay
        };
        const passwordInput = document.getElementById('form1Example23');
        const togglePassword = document.getElementById('togglePassword');

        // Event listener untuk klik pada icon mata
        togglePassword.addEventListener('click', function() {
            // Toggle jenis input (password/text)
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Toggle icon mata (bi-eye-fill / bi-eye-slash-fill)
            this.classList.toggle('bi-eye-fill');
            this.classList.toggle('bi-eye-slash-fill');
        });
    </script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"></script>
    <!-- Custom JS -->
    <script src="Assets/js/script.js"></script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Head section remains the same -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- ... other meta tags ... -->
    <title>ToS - Login</title>
    <!-- Custom fonts for this template-->
    <link href="{{ asset('/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <!-- ... other stylesheets ... -->
    <link href="{{ asset('/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/custom.css') }}" rel="stylesheet">
</head>

<body id="body_login">
    <!-- Background Video and other content remains the same -->
    <video id="bg-video" autoplay muted loop class="bg-video">
        <source src="{{ asset('videos/background.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="container overlay-container" id="login_wrapper">
        <!-- Outer Row -->
        <div class="row justify-content-center" id="login_container">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5 transparent-card" id="login_border">
                    <div class="card-body p-0" id="body_login">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image">
                                <img src="{{ asset('img/opening.png') }}" alt="logo">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h1 mb-4" style="color: #ef8345;">Sign In</h1>
                                    </div>
                                    <form action="{{ route('login.action') }}" method="POST" class="user" id="loginForm">
                                        @csrf
                                        @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endif
                                        <!-- Email input -->
                                        <div class="form-group">
                                            <label for="exampleInputEmail">
                                                <img src="{{ asset('img/email1.png') }}" alt="email" style="width: 20px; height: auto;"> 
                                                <span style="color: #ef8345;">Email</span>
                                            </label>
                                            <input name="email" type="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Enter Email Address...">
                                        </div>
                                        <!-- Password input -->
                                        <div class="form-group position-relative">
                                            <label for="exampleInputPassword">
                                                <img src="{{ asset('img/password.png') }}" alt="password" style="width: 20px; height: auto;"> <span style="color: #ef8345;">Password</span>
                                            </label>
                                            <input name="password" type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                                            <!-- Icon mata untuk toggle visibility -->
                                            <span class="position-absolute" onclick="togglePasswordVisibility()" style="top: 45px; right: 20px; cursor: pointer;">
                                                <i id="passwordIcon" class="fas fa-eye"></i>
                                            </span>
                                        </div>
                                        <!-- Tipe Akun (Account Type) select -->
                                        <div class="form-group">
                                            <label for="accountType">
                                                <img src="{{ asset('img/user2.png') }}" alt="tipe akun" style="width: 20px; height: auto;"><span style="color: #ef8345;">Tipe Akun</span>
                                            </label>
                                            <select id="accountType" name="account_type" class="custom-select" style="border-radius:25px; height:50px;">
                                                <option value="guru">Guru</option>
                                                <option value="murid">Murid</option>
                                                <option value="orang_tua">Orang Tua</option>
                                            </select>
                                        </div>

                                        <!-- Remember Me checkbox -->
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input name="remember" type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck" style="color: #ef8345;">Remember Me</label>
                                            </div>
                                        </div>
                                        <!-- Submit button -->
                                        <button type="submit" class="btn btn-block btn-user text-white" id="btn_login" style="background-color: #ef8345;">Login</button>
                                    </form>
                                    <hr>
                                    <div class="text-center"><span class="text-center" style="color: #ef8345; text-align:center;">Copyright © ToS 2024</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CSS Bookshelf Loader -->
    <div id="loader" style="display: none;">
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
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ... other scripts ... -->
    <script src="{{ asset('/js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('/js/script.js') }}"></script>

    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById("exampleInputPassword");
            const passwordIcon = document.getElementById("passwordIcon");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                passwordIcon.classList.remove("fa-eye");
                passwordIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                passwordIcon.classList.remove("fa-eye-slash");
                passwordIcon.classList.add("fa-eye");
            }
        }
    </script>
</body>

</html>
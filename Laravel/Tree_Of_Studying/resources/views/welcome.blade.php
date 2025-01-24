<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- 
    - primary meta tag
  -->
  <title>ToS - Rapor Digital Terbaik</title>
  <meta name="title" content="EduWeb - The Best Program to Enroll for Exchange">
  <meta name="description" content="This is an education html template made by codewithsadee">

  <!-- 
    - custom css link
  -->
  <link href="{{ asset('/css/style.css') }}" rel="stylesheet">

  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;500;600;700;800&family=Poppins:wght@400;500&display=swap"
    rel="stylesheet">

</head>

<body id="top">

  <!-- 
    - #HEADER
  -->

  <header class="header" data-header>
    <div class="container">

      <a href="#" class="logo">
        <img src="{{ asset('img/Logo2.png') }}" width="150" height="auto" alt="Tos_logo">
      </a>

      <nav class="navbar" data-navbar>

        <div class="wrapper">
          <a href="#" class="logo">
            <img src="{{ asset('img/Logo2.png') }}" width="150" height="auto" alt="Tos_logo">
          </a>

          <button class="nav-close-btn" aria-label="close menu" data-nav-toggler>
            <ion-icon name="close-outline" aria-hidden="true"></ion-icon>
          </button>
        </div>

        <ul class="navbar-list">

          <li class="navbar-item">
            <a href="#home" class="navbar-link" data-nav-link>Beranda</a>
          </li>

          <li class="navbar-item">
            <a href="#features" class="navbar-link" data-nav-link>Fitur</a>
          </li>

          <li class="navbar-item">
            <a href="#about" class="navbar-link" data-nav-link>Tentang</a>
          </li>

          <li class="navbar-item">
            <a href="#webinar" class="navbar-link" data-nav-link>Webinar</a>
          </li>

          <li class="navbar-item">
            <a href="#blog" class="navbar-link" data-nav-link>Lini Masa</a>
          </li>

          <li class="navbar-item">
            <a href="#kontak" class="navbar-link" data-nav-link>Kontak</a>
          </li>

        </ul>

      </nav>

      <div class="header-actions">

        <button class="header-action-btn" aria-label="toggle search" title="Search">
          <ion-icon name="search-outline" aria-hidden="true"></ion-icon>
        </button>

        <button class="header-action-btn" aria-label="cart" title="Cart">
          <ion-icon name="cart-outline" aria-hidden="true"></ion-icon>

          <span class="btn-badge">0</span>
        </button>

        <a href="{{ route('login_page') }}" class="btn has-before">
          <span class="span">Demo Gratis</span>

          <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
        </a>

        <button class="header-action-btn" aria-label="open menu" data-nav-toggler>
          <ion-icon name="menu-outline" aria-hidden="true"></ion-icon>
        </button>

      </div>

      <div class="overlay" data-nav-toggler data-overlay></div>

    </div>
  </header>





  <main>
    <article>

      <!-- 
        - #HERO
      -->

      <section class="section hero has-bg-image" id="home" aria-label="home"
        style="background-image: url('./img/hero-bg.png')">
        <div class="container">

          <div class="hero-content">

            <h1 class="h1 section-title">
              Mari wujudkan Visualisasi Evaluasi Murid <span class="span">Terbaik</span> Anda bersama ToS 🙌
            </h1>

            <p class="hero-text">
              Dengan ToS, setiap langkah belajar siswa anda akan menjadi nyata. Kolaborasi siswa, guru, dan orang tua dalam satu platform.
            </p>

            <a href="#features" class="btn has-before">
              <span class="span">Temukan Fitur</span>

              <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
            </a>

          </div>

          <figure class="hero-banner">

            <div class="img-holder one" style="--width: 270; --height: 300;">
              <img src="{{ asset('img/hero-banner-1.jpg') }}" width="270" height="300" alt="hero banner" class="img-cover">
            </div>

            <div class="img-holder two" style="--width: 240; --height: 370;">
              <img src="{{ asset('img/hero-banner-2.jpg') }}" width="240" height="370" alt="hero banner" class="img-cover">
            </div>

            <img src="{{ asset('img/hero-shape-2.png') }}" width="622" height="551" alt="" class="shape hero-shape-2">

          </figure>

        </div>
      </section>





      <!-- 
        - #Fitur
      -->

      <section class="section category" id="features" aria-label="category">
        <div class="container">

          <p class="section-subtitle">FITUR</p>

          <h2 class="h2 section-title">
            Fitur <span class="span">Unggulan</span> Tree of Studying
          </h2>

          <p class="section-text">
            Simbolisme setiap langkah perkembangan dan pertumbuhan belajar murid
          </p>

          <ul class="grid-list">

            <li>
              <div class="category-card" style="--color: 170, 75%, 41%">

                <div class="card-icon">
                  <img src="{{ asset('img/seed2.png') }}" width="40" height="40" loading="lazy"
                    alt="Online Degree Programs" class="img">
                </div>

                <h3 class="h3">
                  <a href="#" class="card-title">Biji Ide</a>
                </h3>

                <p class="card-text">
                  Awal dari seluruh proses pembelajaran
                </p>

                <span class="card-badge">11 Aspek</span>

              </div>
            </li>

            <li>
              <div class="category-card" style="--color: 351, 83%, 61%">

                <div class="card-icon">
                  <img src="{{ asset('img/akar2.png') }}" width="40" height="40" loading="lazy"
                    alt="Non-Degree Programs" class="img">
                </div>

                <h3 class="h3">
                  <a href="#" class="card-title">Akar Diagnostik</a>
                </h3>

                <p class="card-text">
                  Fondasi yang mendukung pertumbuhan pohon, namun sering tersembunyi
                </p>

                <span class="card-badge">4 Aspek</span>

              </div>
            </li>

            <li>
              <div class="category-card" style="--color: 229, 75%, 58%">

                <div class="card-icon">
                  <img src="{{ asset('img/trunk2.png') }}" width="40" height="40" loading="lazy"
                    alt="Off-Campus Programs" class="img">
                </div>

                <h3 class="h3">
                  <a href="#" class="card-title">Batang Metode</a>
                </h3>

                <p class="card-text">
                  Penopang yang menghubungkan akar (tantangan) dengan daun dan bunga (pencapaian)
                </p>

                <span class="card-badge">2 Aspek</span>

              </div>
            </li>

            <li>
              <div class="category-card" style="--color: 42, 94%, 55%">

                <div class="card-icon">
                  <img src="{{ asset('img/leaf2.png') }}" width="40" height="40" loading="lazy"
                    alt="Hybrid Distance Programs" class="img">
                </div>

                <h3 class="h3">
                  <a href="#" class="card-title">Daun Formatif</a>
                </h3>

                <p class="card-text">
                  Representasi pertumbuhan dan perkembangan siswa secara bertahap
                </p>

                <span class="card-badge">2 Aspek</span>

              </div>
            </li>

            <li>
              <div class="category-card" style="--color: 170, 75%, 41%">

                <div class="card-icon">
                  <img src="{{ asset('img/bugs.png') }}" width="40" height="40" loading="lazy"
                    alt="Online Degree Programs" class="img">
                </div>

                <h3 class="h3">
                  <a href="#" class="card-title">Hama Hambatan</a>
                </h3>

                <p class="card-text">
                  Hambatan personal dalam belajar baik dari penilaian guru maupun dari siswa melalui hasil tes psychology meter
                </p>

                <span class="card-badge">2 Aspek</span>

              </div>
            </li>

            <li>
              <div class="category-card" style="--color: 351, 83%, 61%">

                <div class="card-icon">
                  <img src="{{ asset('img/hibiscus.png') }}" width="40" height="40" loading="lazy"
                    alt="Non-Degree Programs" class="img">
                </div>

                <h3 class="h3">
                  <a href="#" class="card-title">Bunga Prestasi</a>
                </h3>

                <p class="card-text">
                  Capaian yang lebih indah dan bermakna di luar ekspektasi
                </p>

                <span class="card-badge">4 Aspek</span>

              </div>
            </li>

            <li>
              <div class="category-card" style="--color: 229, 75%, 58%">

                <div class="card-icon">
                  <img src="{{ asset('img/apple.png') }}" width="40" height="40" loading="lazy"
                    alt="Off-Campus Programs" class="img">
                </div>

                <h3 class="h3">
                  <a href="#" class="card-title">Buah Sumatif</a>
                </h3>

                <p class="card-text">
                  Hasil akhir dari proses pembelajaran yang matang dan berdampak
                </p>

                <span class="card-badge">4 Aspek</span>

              </div>
            </li>


          </ul>

        </div>
      </section>





      <!-- 
        - #ABOUT
      -->

      <section class="section about" id="about" aria-label="about">
        <div class="container">

          <figure class="about-banner">

            <div class="img-holder" style="--width: 520; --height: 370;">
              <img src="{{ asset('img/about.jpg')}}" width="520" height="370" loading="lazy" alt="about banner"
                class="img-cover">
            </div>




            <img src="{{ asset('img/about-shape-3.png')}}" width="722" height="528" loading="lazy" alt=""
              class="shape about-shape-3">

          </figure>

          <div class="about-content">

            <p class="section-subtitle">Tentang Kita</p>

            <h2 class="h2 section-title">
              Lebih dari 2 tahun <span class="span">berpengalaman</span> dalam bidang pendidikan non-formal
            </h2>

            <p class="section-text">
              ToS adalah bagian dari platform Adicita, sebuah sistem pembelajaran digital berbasis story-driven games dan tematik yang menggabungkan semua mata pelajaran sesuai kurikulum Indonesia. Adicita bertujuan untuk menyediakan pengalaman belajar yang holistik dan menyenangkan bagi siswa, dengan ToS sebagai fitur unggulan untuk pelacakan dan evaluasi pembelajaran.
            </p>

            <ul class="about-list">

              <li class="about-item">
                <ion-icon name="checkmark-done-outline" aria-hidden="true"></ion-icon>

                <span class="span">Fleksibelitas</span>
              </li>

              <li class="about-item">
                <ion-icon name="checkmark-done-outline" aria-hidden="true"></ion-icon>

                <span class="span">Efisiensi</span>
              </li>

              <li class="about-item">
                <ion-icon name="checkmark-done-outline" aria-hidden="true"></ion-icon>

                <span class="span">Akses Berlangganan Bulanan</span>
              </li>

            </ul>


          </div>

        </div>
      </section>





      <!-- 
        - #COURSE
      -->

      <section class="section course" id="webinar" aria-label="course">
        <div class="container">

          <p class="section-subtitle">WEBINAR</p>

          <h2 class="h2 section-title">Mari ikuti Jejak Langkah Kami dalam Bermitra dengan Para Lembaga Pendidikan</h2>

          <ul class="grid-list">

            <li>
              <div class="course-card">

                <figure class="card-banner img-holder" style="--width: 370; --height: 220;">
                  <img src="{{ asset('img/webinar-1.jpg')}}" width="100" height="auto" loading="lazy"
                    alt="Build Responsive Real- World Websites with HTML and CSS" class="img-cover">
                </figure>

                <div class="abs-badge">
                  <ion-icon name="browsers-outline" aria-hidden="true"></ion-icon>

                  <span class="span">Webinar-1</span>
                </div>

                <div class="card-content">

                  <img src="{{ asset('img/logo_adicita.png') }}" width="50" height="auto" alt="adicita_logo">
                  <h3 class="h3">
                    <a href="https://www.instagram.com/adi.cita_/" class="card-title">Bimbel Adicita</a>
                  </h3>



                </div>

              </div>
            </li>

            <li>
              <div class="course-card">

                <figure class="card-banner img-holder" style="--width: 370; --height: 220;">
                  <img src="{{ asset('img/webinar-2.jpg')}}" width="100" height="auto" loading="lazy"
                    alt="Java Programming Masterclass for Software Developers" class="img-cover">
                </figure>

                <div class="abs-badge">
                  <ion-icon name="browsers-outline" aria-hidden="true"></ion-icon>

                  <span class="span">Webinar-2</span>
                </div>

                <div class="card-content">
                  <img src="{{ asset('img/logo_smm.png') }}" width="50" height="auto" alt="smm_logo">
                  <h3 class="h3">
                    <a href="https://www.sekolahmuridmerdeka.id/daring-rutin/?utm_source=sekolah%20murid%20merdeka%20online&utm_medium=googleadsta2425&utm_campaign=smm_conv_brand_dr&gad_source=1&gclid=Cj0KCQiAo5u6BhDJARIsAAVoDWtGn1iYnbA0bVoJKZ2slwuWsMbF9X1n9ZJumCr5K5jbx5fTItxCB4QaAgArEALw_wcB" class="card-title">Sekolah Murid Merdeka</a>
                  </h3>



                </div>

              </div>
            </li>

            <li>
              <div class="course-card">

                <figure class="card-banner img-holder" style="--width: 370; --height: 220;">
                  <img src="{{ asset('img/webinar-3.jpg')}}" width="370" height="220" loading="lazy"
                    alt="The Complete Camtasia Course for Content Creators" class="img-cover">
                </figure>

                <div class="abs-badge">
                  <ion-icon name="browsers-outline" aria-hidden="true"></ion-icon>

                  <span class="span">Webinar-3</span>
                </div>

                <div class="card-content">
                  <img src="{{ asset('img/logo_cikal.png') }}" width="50" height="auto" alt="cikal_logo">
                  <h3 class="h3">
                    <a href="https://www.cikal.co.id/site?id=sekolah-cikal-surabaya" class="card-title">Sekolah Cikal Surabaya </a>
                  </h3>


                </div>

              </div>
            </li>

          </ul>

          <a href="#" class="btn has-before">
            <span class="span">Jelajahi lebih banyak lagi</span>

            <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
          </a>

        </div>
      </section>





      <!-- 
        - #VIDEO
      -->


      <section class="video has-bg-image" aria-label="video">

        <div class="container">

          <div class="video-card">

            <div class="video-banner">
              <video id="video" class="video" muted>
                <source src="{{ asset('videos/video-intro.mp4') }}" type="video/mp4">
                Your browser does not support the video tag.
              </video>
              <div id="play-btn" class="play-btn">▶</div>
            </div>



            <img src="{{ asset('img/video-shape-1.png')}}" width="1089" height="605" loading="lazy" alt=""
              class="shape video-shape-1">

            <img src="{{ asset('img//video-shape-2.png')}}" width="158" height="174" loading="lazy" alt=""
              class="shape video-shape-2">

          </div>

        </div>
      </section>





      <!-- 
        - #STATE
      -->

      <section class="section stats" aria-label="stats">
        <div class="container">

          <ul class="grid-list">

            <li>
              <div class="stats-card" style="--color: 170, 75%, 41%">
                <h3 class="card-title">29.3k</h3>

                <p class="card-text">Lembaga Pendidikan Terdaftar</p>
              </div>
            </li>

            <li>
              <div class="stats-card" style="--color: 351, 83%, 61%">
                <h3 class="card-title">32.4K</h3>

                <p class="card-text">Guru Terbantu</p>
              </div>
            </li>

            <li>
              <div class="stats-card" style="--color: 260, 100%, 67%">
                <h3 class="card-title">100%</h3>

                <p class="card-text">Tingkat Kepuasan</p>
              </div>
            </li>

            <li>
              <div class="stats-card" style="--color: 42, 94%, 55%">
                <h3 class="card-title">354+</h3>

                <p class="card-text">Top Investor Bergabung</p>
              </div>
            </li>

          </ul>

        </div>
      </section>





      <!-- 
        - #BLOG
      -->

      <section class="section blog has-bg-image" id="blog" aria-label="blog">
        <div class="container">

          <p class="section-subtitle">Lini Masa</p>

          <h2 class="h2 section-title">Mari Tumbuh Bersama dan Menikmati Perjalanan Bersama ToS</h2>

          <ul class="grid-list">

            <li>
              <div class="blog-card">

                <figure class="card-banner img-holder has-after">
                  <img src="{{ asset('img/blog-1.png')}}" width="370" height="370" loading="lazy"
                    alt="Become A Better Blogger: Content Planning" class="img-cover">
                </figure>

                <div class="card-content">

                  <a href="#" class="card-btn" aria-label="read more">
                    <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
                  </a>

                  <h3 class="h3">
                    <a href="#" class="card-title">Inisialisasi Proyek: Pengembangan Landing Web dan Design 3D</a>
                  </h3>

                  <ul class="card-meta-list">

                    <li class="card-meta-item">
                      <ion-icon name="calendar-outline" aria-hidden="true"></ion-icon>

                      <span class="span">27 Nov, 2024</span>
                    </li>

                    <li class="card-meta-item">
                      <ion-icon name="chatbubbles-outline" aria-hidden="true"></ion-icon>

                      <span class="span">Com 10</span>
                    </li>

                  </ul>

                  <p class="card-text">
                    Sebagai karya Tugas Akhir di Rumah Gemilang Indonesia Angkatan 31
                  </p>

                </div>

              </div>
            </li>

            <li>
              <div class="blog-card">

                <figure class="card-banner img-holder has-after" style="--width: 370; --height: 370;">
                  <img src="{{ asset('img/blog-2.jpg')}}" width="370" height="370" loading="lazy"
                    alt="Become A Better Blogger: Content Planning" class="img-cover">
                </figure>

                <div class="card-content">

                  <a href="#" class="card-btn" aria-label="read more">
                    <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
                  </a>


                  <h3 class="h3">
                    <a href="#" class="card-title">Pengembangan Fitur Lanjutan</a>
                  </h3>

                  <ul class="card-meta-list">

                    <li class="card-meta-item">
                      <ion-icon name="calendar-outline" aria-hidden="true"></ion-icon>

                      <span class="span">Januari, 2025</span>
                    </li>

                    <li class="card-meta-item">
                      <ion-icon name="chatbubbles-outline" aria-hidden="true"></ion-icon>

                      <span class="span">Com 15</span>
                    </li>

                  </ul>

                  <p class="card-text">
                    Pengembangan fitur pada menu bilah sisi beranda ToS
                  </p>

                </div>

              </div>
            </li>

            <li>
              <div class="blog-card">

                <figure class="card-banner img-holder has-after" style="--width: 370; --height: 370;">
                  <img src="{{ asset('img/blog-3.jpg')}}" width="370" height="370" loading="lazy"
                    alt="Become A Better Blogger: Content Planning" class="img-cover">
                </figure>

                <div class="card-content">

                  <a href="#" class="card-btn" aria-label="read more">
                    <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
                  </a>

                  <h3 class="h3">
                    <a href="#" class="card-title">Integrasi AI</a>
                  </h3>

                  <ul class="card-meta-list">

                    <li class="card-meta-item">
                      <ion-icon name="calendar-outline" aria-hidden="true"></ion-icon>

                      <span class="span">Maret, 2025</span>
                    </li>

                    <li class="card-meta-item">
                      <ion-icon name="chatbubbles-outline" aria-hidden="true"></ion-icon>

                      <span class="span">Com 09</span>
                    </li>

                  </ul>

                  <p class="card-text">
                    Pengembanngan Fitur AI Pendeteksi Autisme dan Pengkategori Tingkat Literasi
                  </p>

                </div>

              </div>
            </li>

          </ul>

          <img src="{{ asset('img/blog-shape.png')}}" width="186" height="186" loading="lazy" alt=""
            class="shape blog-shape">

        </div>
      </section>

    </article>
  </main>





  <!-- 
    - #FOOTER
  -->

  <footer class="footer" id="kontak">

    <div class="footer-top section">
      <div class="container grid-list">

        <div class="footer-brand">

          <a href="#" class="logo">
            <img src=" {{ asset('img/Logo2.png') }} " width="150" height="auto" alt="EduWeb logo">
          </a>

          <div class="wrapper">

            <address class="address">Jl. Tugu Semar No.08 RT 03 RW 19 Dusun Baran, Desa Wajak</address>
          </div>

          <div class="wrapper">
            <span class="span">No. Telp:</span>

            <a href="tel:+011234567890" class="footer-link">+62 857-7509-3865</a>
          </div>

          <div class="wrapper">
            <span class="span">Email:</span>

            <a href="mailto:muhammadyusril.wit@gmail.com" class="footer-link">muhammadyusril.wit@gmail.com</a>
          </div>

        </div>

        <ul class="footer-list">

          <li>
            <p class="footer-list-title">Platform Daring</p>
          </li>

          <li>
            <a href="#home" class="footer-link">Beranda</a>
          </li>

          <li>
            <a href="#features" class="footer-link">Fitur</a>
          </li>

          <li>
            <a href="#about" class="footer-link">Tentang</a>
          </li>

          <li>
            <a href="#webinar" class="footer-link">Webinar</a>
          </li>

          <li>
            <a href="#blog" class="footer-link">Lini Masa</a>
          </li>

          <li>
            <a href="#kontak" class="footer-link">Panduan Berlangganan</a>
          </li>

        </ul>

        <ul class="footer-list">

          <li>
            <p class="footer-list-title">Pranala</p>
          </li>

          <li>
            <a href="#kontak" class="footer-link">Hubungi Kita</a>
          </li>

          <li>
            <a href="#" class="footer-link">Galeri</a>
          </li>

          <li>
            <a href="#" class="footer-link">Berita & Artikel</a>
          </li>

          <li>
            <a href="#" class="footer-link">SSD (Soal Sering Ditanya)</a>
          </li>

          <li>
            <a href="#" class="footer-link">Masuk/Registrasi</a>
          </li>

          <li>
            <a href="#" class="footer-link">Segera Hadir</a>
          </li>

        </ul>

        <div class="footer-list">

          <p class="footer-list-title">Kontak</p>

          <p class="footer-list-text">
            Masukkan e-mail Anda untuk Registrasi Berlangganan Nawala Kami
          </p>

          <form action="" class="newsletter-form">
            <input type="email" name="email_address" placeholder="email Anda" required class="input-field">

            <button type="submit" class="btn has-before">
              <span class="span">Berlangganan</span>

              <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
            </button>
          </form>

          <ul class="social-list">

            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-facebook"></ion-icon>
              </a>
            </li>

            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-linkedin"></ion-icon>
              </a>
            </li>

            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-instagram"></ion-icon>
              </a>
            </li>

            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-twitter"></ion-icon>
              </a>
            </li>

            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-youtube"></ion-icon>
              </a>
            </li>

          </ul>

        </div>

      </div>
    </div>

    <div class="footer-bottom">
      <div class="container">

        <p class="copyright">
          &copy;2024 All Rights Reserved by <a href="#" class="copyright-link">ToS</a> Supported By : <a href="https://rumahgemilang.com/" class="copyright-link">Rumah Gemilang Indonesia</a>
        </p>

      </div>
    </div>

  </footer>





  <!-- 
    - #BACK TO TOP
  -->

  <a href="#top" class="back-top-btn" aria-label="back top top" data-back-top-btn>
    <ion-icon name="chevron-up" aria-hidden="true"></ion-icon>
  </a>





  <!-- 
    - custom js link
  -->
  <script src="{{ asset('/js/script-welcome.js') }}"></script>

  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>
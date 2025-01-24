<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('img/Logo.png') }}" alt="Logo ToS" style="width: auto; height: 150px;">
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0 bg-white">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route(auth()->user()->role . '.dashboard') }}">
            <img src="{{ asset('img/dashboard.png') }}" alt="dashboard" style="width: 20px; height: auto;">
            <span class="nav-text">Dashboard</span>
        </a>
    </li>


    <!-- Dropdown Menu for Rapor -->
    <li class="nav-item">
        <a href="#rapor" data-toggle="collapse" aria-expanded="false" class="nav-link dropdown-toggle">
            <img src="{{ asset('img/report.png') }}" alt="rapor" style="width: 20px; height: auto;">
            <span class="nav-text">Rapor</span>
        </a>
        <ul class="collapse list-unstyled" id="rapor">
            <li class="nav-item">
                <a class="nav-link" href="@if(auth()->user()->role == 'guru')
            {{ route('guru.biji-ide') }}
        @elseif(auth()->user()->role == 'murid')
            {{ route('murid.create-biji') }}
        @elseif(auth()->user()->role == 'orang_tua')
            {{ route('orangtua.biji-ide') }}
        @endif">
                    <img src="{{ asset('img/seed.png') }}" alt="seed" style="width: 20px; height: auto;">
                    <span class="nav-text">Biji Ide</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <img src="{{ asset('img/akar.png') }}" alt="root" style="width: 20px; height: auto;">
                    <span  class="nav-text">Akar Diagnostik</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <img src="{{ asset('img/trunk.png') }}" alt="trunk" style="width: 20px; height: auto;">
                    <span  class="nav-text">Batang Metode</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <img src="{{ asset('img/insect.png') }}" alt="insect" style="width: 20px; height: auto;">
                    <span  class="nav-text">Hama Hambatan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <img src="{{ asset('img/leaf.png') }}" alt="leaf" style="width: 20px; height: auto;">
                    <span  class="nav-text">Daun Formatif</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <img src="{{ asset('img/flower.png') }}" alt="flower" style="width: 20px; height: auto;">
                    <span  class="nav-text">Bunga Prestasi</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <img src="{{ asset('img/fruit.png') }}" alt="fruit" style="width: 20px; height: auto;">
                    <span  class="nav-text">Buah Sumatif</span>
                </a>
            </li>
        </ul>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block bg-white">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
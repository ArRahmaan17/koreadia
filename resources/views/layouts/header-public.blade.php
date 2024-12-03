<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

        <a href="{{ route('fe-home') }}" class="logo d-flex align-items-center me-auto">
            <img src="{{ asset('frontend') }}/assets/img/logo.png" alt="">
            <h1 class="sitename">QuickStart</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a  href="{{ route('fe-home') }}">Home</a></li>
                <li><a href="#about">Tentang Kami</a></li>
                <li><a href="#features">Fitur</a></li>
                <li><a href="{{ route('sendMail') }}">Kirim Surat</a></li>
                <li><a href="{{ route('tracking') }}">Lacak Surat</a></li>
                <li><a href="#contact">Kontak Kami</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <a class="btn-getstarted" href="{{ route('login') }}">{{ auth()->user() ? 'Dashboard' : 'Login' }}</a>

    </div>
</header>
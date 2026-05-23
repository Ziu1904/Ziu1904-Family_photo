<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a href="/" class="logo d-flex align-items-center" style="text-decoration: none;">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" style="height: 40px; margin-right: 10px; filter: brightness(0) invert(1);">
            <span class="logo-text">Family<span class="highlight">Photo</span></span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="nav-links navbar-nav ms-auto">
                <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                    <a class="nav-link" href="/">Trang chủ</a>
                </li>
                <li class="nav-item {{ request()->is('albums*') ? 'active' : '' }}">
                    <a class="nav-link" href="/albums">Bộ sưu tập</a>
                </li>
                <li class="nav-item {{ request()->is('reviews*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('reviews') }}">Đánh giá</a>
                </li>

                @auth
                    @if(in_array(auth()->user()->role, ['admin', 'manager']))
                        <li class="nav-item">
                            <a class="nav-link text-primary fw-bold" href="{{ route('admin.dashboard') }}">Admin Panel</a>
                        </li>
                    @endif
                    <li class="nav-item {{ request()->is('account*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('account') }}"><i class="fas fa-user-circle me-1"></i> {{ auth()->user()->name }}</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn-link border-0 bg-transparent" style="cursor: pointer;">Thoát</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item {{ request()->is('login') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('login') }}">Đăng nhập</a>
                    </li>
                    <li class="nav-item {{ request()->is('register') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('register') }}">Đăng ký</a>
                    </li>
                @endauth
            </ul>

            <div class="nav-cta ms-lg-3">
                <a href="{{ route('booking') }}" class="btn btn-primary">Tư vấn ngay</a>
            </div>
        </div>
    </div>
</nav>

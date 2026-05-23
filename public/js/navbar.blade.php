<nav class="navbar">
    <div class="container">
        <a href="/" class="logo">
            <span class="logo-text">Family<span class="highlight">Photo</span></span>
        </a>
        
        <ul class="nav-links">
            <li class="{{ request()->is('/') ? 'active' : '' }}">
                <a href="/">Trang chủ</a>
            </li>
            <li class="{{ request()->is('albums*') ? 'active' : '' }}">
                <a href="/albums">Bộ sưu tập</a>
            </li>
            <li class="{{ request()->is('booking*') ? 'active' : '' }}">
                <a href="{{ route('booking') }}">Đặt lịch</a>
            </li>
            <li class="{{ request()->is('reviews*') ? 'active' : '' }}">
                <a href="{{ route('reviews') }}">Đánh giá</a>
            </li>
        </ul>

        <div class="nav-cta">
            <a href="{{ route('booking') }}" class="btn btn-primary">Tư vấn ngay</a>
        </div>
    </div>
</nav>
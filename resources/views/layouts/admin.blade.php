<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bảng Điều Khiển')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/admin-layout.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
    @stack('styles')
</head>
 
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-brand">
                <img src="{{ asset('img/logo.png') }}" alt="Logo">
                <h5>FamilyPhoto</h5>
            </div>

            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link @if(Route::currentRouteName() === 'admin.dashboard') active @endif" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-chart-line"></i> Bảng Điều Khiển
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(Str::startsWith(Route::currentRouteName(), 'admin.reviews')) active @endif" href="{{ route('admin.reviews.index') }}">
                        <i class="fas fa-star"></i> Đánh Giá
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(Str::startsWith(Route::currentRouteName(), 'admin.packages')) active @endif" href="{{ route('admin.packages.index') }}">
                        <i class="fas fa-box"></i> Gói Dịch Vụ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(Str::startsWith(Route::currentRouteName(), 'admin.consultations')) active @endif" href="{{ route('admin.consultations.index') }}">
                        <i class="fas fa-comments"></i> Tư Vấn
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(Str::startsWith(Route::currentRouteName(), 'admin.albums')) active @endif" href="{{ route('admin.albums.index') }}">
                        <i class="fas fa-images"></i> Album
                    </a>
                </li>
                @if(Auth::user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link @if(Str::startsWith(Route::currentRouteName(), 'admin.users')) active @endif" href="{{ route('admin.users.index') }}">
                            <i class="fas fa-users"></i> Users
                        </a>
                    </li>
                @endif
                <li class="nav-item logout-nav">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Đăng Xuất
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-content" style="width: 100%;">
            <!-- Top Navigation -->
            <div class="navbar-admin d-flex justify-content-between align-items-center">
                <h1>@yield('page_title', 'Dashboard')</h1>
                <div class="navbar-user">
                    <span style="color: #666;">{{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})</span>
                    <div class="user-avatar">{{ Auth::user()->name[0] }}</div>
                </div>
            </div>

            <!-- Alerts -->
            @if ($errors->any())
                <div class="alert alert-danger alert-custom">
                    <strong>Lỗi:</strong>
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-custom">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-custom">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

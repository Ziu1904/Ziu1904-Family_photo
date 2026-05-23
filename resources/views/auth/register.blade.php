<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký | FamilyMedia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('css/web.css') }}" rel="stylesheet">
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
</head>
    
<body>
    <div class="register-card">
        <h2>Đăng Ký Tài Khoản</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">Họ và tên</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nhập lại mật khẩu</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Trường học</label>
                    <input type="text" name="school" class="form-control" value="{{ old('school') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Lớp</label>
                    <input type="text" name="class" class="form-control" value="{{ old('class') }}">
                </div>
            </div>
            <button type="submit" class="btn btn-register">Đăng Ký</button>
        </form>

        <div class="auth-links">
            <p>Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a></p>
            <p><a href="/">Quay về trang chủ</a></p>
        </div>
    </div>
</body>
</html>

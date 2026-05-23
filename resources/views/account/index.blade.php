<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài Khoản Của Tôi | FamilyMedia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('css/web.css') }}" rel="stylesheet">
    <link href="{{ asset('css/account.css') }}" rel="stylesheet">
</head>
<body>
    @include('components.navbar')

    <header class="account-header">
        <div class="container">
            <h1>Xin chào, {{ $user->name }}!</h1>
            <p>Quản lý thông tin cá nhân và theo dõi yêu cầu tư vấn của bạn.</p>
        </div>
    </header>

    <div class="container mb-5">
        <div class="row">
            <div class="col-lg-4">
                <div class="profile-card text-center">
                    <div class="profile-img mx-auto">
                        <i class="fas fa-user"></i>
                    </div>
                    <h4>{{ $user->name }}</h4>
                    <p class="text-muted">{{ $user->email }}</p>
                    <hr>
                    <div class="text-start">
                        <p><strong><i class="fas fa-phone me-2"></i></strong> {{ $user->phone ?? 'Chưa cập nhật' }}</p>
                        <p><strong><i class="fas fa-school me-2"></i></strong> {{ $user->school ?? 'Chưa cập nhật' }}</p>
                        <p><strong><i class="fas fa-graduation-cap me-2"></i></strong> {{ $user->class ?? 'Chưa cập nhật' }}</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100">Đăng Xuất</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="orders-card">
                    <h5 class="mb-4">Yêu Cầu Tư Vấn Của Bạn</h5>
                    @if($user->consultations->count() > 0)
                        @foreach($user->consultations as $item)
                            <div class="consultation-card mb-4 p-4 border rounded shadow-sm">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-1">Yêu cầu #{{ $item->id }}</h6>
                                        <small class="text-muted">{{ $item->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <span class="badge badge-status badge-{{ $item->status }}">
                                        @switch($item->status)
                                            @case('pending') Chờ xử lý @break
                                            @case('in-progress') Đang xử lý @break
                                            @case('contacted') Đã phản hồi @break
                                            @case('confirmed') Đã xác nhận booking @break
                                            @case('completed') Hoàn thành @break
                                            @case('rejected') Bị từ chối @break
                                            @case('cancelled') Đã hủy @break
                                            @default {{ ucfirst($item->status) }}
                                        @endswitch
                                    </span>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                                <p><strong>Lớp:</strong> {{ $item->class_name ?? '—' }}</p>
                                                <p><strong>Khu vực:</strong> {{ $item->area ?? '—' }}</p>
                                                <p><strong>Số học sinh:</strong> {{ $item->student_count ?? '—' }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Thời gian dự kiến:</strong> {{ $item->time ?? '—' }}</p>
                                                <p><strong>Điện thoại:</strong> {{ $item->phone ?? $user->phone ?? '—' }}</p>

                                <div class="mb-3">
                                    <p><strong>Ghi chú của bạn:</strong></p>
                                    <div class="p-3 bg-light rounded">{{ $item->note ?? '(Không có ghi chú)' }}</div>
                                </div>

                                <div class="mb-3">
                                    <p><strong>Phản hồi từ Manager:</strong></p>
                                    <div class="p-3 bg-light rounded">{{ $item->manager_response ?? 'Chưa có phản hồi.' }}</div>
                                </div>

                                <div class="d-flex gap-2 flex-wrap">
                                    @if(in_array($item->status, ['pending', 'in-progress'], true))
                                        <form action="{{ route('consultations.cancel', $item->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-sm">Hủy yêu cầu</button>
                                        </form>
                                    @endif

                                    @if(in_array($item->status, ['in-progress', 'contacted'], true))
                                        <form action="{{ route('consultations.confirm', $item->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Xác nhận booking chính thức</button>
                                        </form>
                                    @endif

                                    @if($item->status === 'confirmed')
                                        <span class="badge bg-success">Booking chính thức đã được xác nhận</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <p>Bạn chưa gửi yêu cầu tư vấn nào.</p>
                            <a href="/booking" class="btn btn-primary">Đặt lịch ngay</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('components.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

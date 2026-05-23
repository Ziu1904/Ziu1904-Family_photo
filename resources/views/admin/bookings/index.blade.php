@extends('layouts.admin')

@section('title', 'Quản Lý Đặt Lịch')
@section('page_title', 'Quản Lý Đặt Lịch')

@section('content')
<div style="margin-bottom: 20px;">
    <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary-admin">
        <i class="fas fa-plus"></i> Đặt Lịch Mới
    </a>
</div>

<div class="table-admin">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Người Dùng</th>
                <th>Gói</th>
                <th>Trường</th>
                <th>Lớp</th>
                <th>Ngày</th>
                <th>Trạng Thái</th>
                <th>Giá (VND)</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
                <tr>
                    <td>#{{ $booking->id }}</td>
                    <td>{{ $booking->user->name ?? 'N/A' }}</td>
                    <td>{{ $booking->package->name ?? 'N/A' }}</td>
                    <td>{{ $booking->school }}</td>
                    <td>{{ $booking->class }}</td>
                    <td>{{ optional($booking->booking_date)->format('d/m/Y') ?? 'N/A' }}</td>
                    <td>
                        <span class="badge-status badge-{{ strtolower($booking->status) }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                    <td>{{ number_format($booking->total_price, 0, ',', '.') }} VND</td>
                    <td>
                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-primary btn-sm-admin">Xem</a>
                        <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-sm btn-warning btn-sm-admin">Sửa</a>
                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger btn-sm-admin" onclick="return confirm('Bạn có chắc chắn?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center; padding: 30px; color: #999;">
                        Chưa có đặt lịch nào. <a href="{{ route('admin.bookings.create') }}">Tạo đặt lịch ngay</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div style="margin-top: 20px;">
    {{ $bookings->links() }}
</div>
@endsection

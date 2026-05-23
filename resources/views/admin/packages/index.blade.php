@extends('layouts.admin')

@section('title', 'Quản Lý Gói Dịch Vụ')
@section('page_title', 'Quản Lý Gói Dịch Vụ')

@section('content')
<div style="margin-bottom: 20px;">
    <a href="{{ route('admin.packages.create') }}" class="btn btn-primary-admin">
        <i class="fas fa-plus"></i> Gói Mới
    </a>
</div>

<div class="table-admin">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Gói</th>
                <th>Giá (VND)</th>
                <th>Ảnh</th>
                <th>Video</th>
                <th>Concept</th>
                <th>Trạng Thái</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($packages as $package)
                <tr>
                    <td>#{{ $package->id }}</td>
                    <td>{{ $package->name }}</td>
                    <td>{{ number_format($package->price, 0, ',', '.') }} VND</td>
                    <td>{{ $package->photos_count ?? '-' }}</td>
                    <td>{{ $package->videos_count ?? '-' }}</td>
                    <td>{{ $package->concepts_count ?? '-' }}</td>
                    <td>
                        @if($package->is_active)
                            <span class="badge" style="background: #28a745; color: white;">Hoạt Động</span>
                        @else
                            <span class="badge" style="background: #ccc; color: white;">Không Hoạt Động</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.packages.show', $package->id) }}" class="btn btn-sm btn-primary btn-sm-admin">Xem</a>
                        <a href="{{ route('admin.packages.edit', $package->id) }}" class="btn btn-sm btn-warning btn-sm-admin">Sửa</a>
                        <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger btn-sm-admin" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 30px; color: #999;">
                        Không tìm thấy gói nào. <a href="{{ route('admin.packages.create') }}">Tạo gói mới ngay</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div style="margin-top: 20px;">
    {{ $packages->links() }}
</div>
@endsection

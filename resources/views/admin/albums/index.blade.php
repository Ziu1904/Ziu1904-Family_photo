@extends('layouts.admin')

@section('title', 'Quản Lý Album')
@section('page_title', 'Quản Lý Album')

@section('content')
<div style="margin-bottom: 20px;">
    <a href="{{ route('admin.albums.create') }}" class="btn btn-primary-admin">
        <i class="fas fa-plus"></i> Album Mới
    </a>
</div>

<div style="background: white; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        <strong style="color: #667eea;">Album Nổi Bật:</strong> 
</div>

<div class="table-admin">
    <table class="table">
        <thead>
            <tr>
                <th style="width: 80px;">Ảnh Bìa</th>
                <th>ID</th>
                <th>Tên</th>
                <th>Concept</th>
                <th>Ảnh</th>
                <th>Nổi Bật</th>
                <th>Đã Xuất Bản</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($albums as $album)
                <tr>
                    <td>
                        @if($album->cover_image_url)
                            <img src="{{ $album->cover_image_url }}" alt="{{ $album->name }}" style="width: 70px; height: 70px; object-fit: cover; border-radius: 6px;">
                        @else
                            <div style="width: 70px; height: 70px; background: #e9ecef; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-image" style="color: #999;"></i>
                            </div>
                        @endif
                    </td>
                    <td>#{{ $album->id }}</td>
                    <td>{{ $album->name }}</td>
                    <td>{{ $album->concept }}</td>
                    <td>{{ $album->photos_count ?? '0' }}</td>
                    <td>
                        @if($album->is_featured)
                            <span class="badge" style="background: #28a745; color: white;">Có</span>
                        @else
                            <span class="badge" style="background: #6c757d; color: white;">Không</span>
                        @endif
                    </td>
                    <td>
                        @if($album->is_published)
                            <span class="badge" style="background: #17a2b8; color: white;">Có</span>
                        @else
                            <span class="badge" style="background: #6c757d; color: white;">Không</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.albums.show', $album->id) }}" class="btn btn-sm btn-primary">Xem</a>
                        <a href="{{ route('admin.albums.edit', $album->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                        
                        <form action="{{ route('admin.albums.toggle-featured', $album->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-info">
                                {{ $album->is_featured ? 'Bỏ Nổi Bật' : 'Nổi Bật' }}
                            </button>
                        </form>

                        <form action="{{ route('admin.albums.destroy', $album->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Bạn có chắc muốn xóa album này?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 40px; color: #999;">
                        Chưa có album nào.
                        <a href="{{ route('admin.albums.create') }}">Tạo album ngay</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $albums->links() }}
@endsection
@extends('layouts.admin')

@section('title', 'Bảng Điều Khiển')
@section('page_title', 'Tổng Quan')

@section('content')
<div class="row">
    <!-- Key Metrics -->
    <div class="col-md-3 col-sm-6">
        <div class="card-stat">
            <h5><i class="fas fa-comments" style="color: #667eea; margin-right: 8px;"></i>Tổng Tư Vấn</h5>
            <div class="value">{{ $stats['total_consultations'] ?? 0 }}</div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card-stat">
            <h5><i class="fas fa-clock" style="color: #ffc107; margin-right: 8px;"></i>Tư Vấn Đang Chờ</h5>
            <div class="value">{{ $stats['pending_consultations'] ?? 0 }}</div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card-stat">
            <h5><i class="fas fa-star" style="color: #667eea; margin-right: 8px;"></i>Tổng Đánh Giá</h5>
            <div class="value">{{ $stats['total_reviews'] ?? 0 }}</div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card-stat">
            <h5><i class="fas fa-star-solid" style="color: #ffc107; margin-right: 8px;"></i>Đánh Giá Nổi Bật</h5>
            <div class="value">{{ $stats['featured_reviews'] ?? 0 }}</div>
        </div>
    </div>
</div>

<div class="row" style="margin-top: 20px;">
    <div class="col-md-3 col-sm-6">
        <div class="card-stat">
            <h5><i class="fas fa-images" style="color: #667eea; margin-right: 8px;"></i>Tổng Album</h5>
            <div class="value">{{ $stats['total_albums'] ?? 0 }}</div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card-stat">
            <h5><i class="fas fa-image" style="color: #28a745; margin-right: 8px;"></i>Album Nổi Bật</h5>
            <div class="value">{{ $stats['featured_albums'] ?? 0 }}</div>
        </div>
    </div>
</div>

<!-- Recent Consultations -->
<div class="row" style="margin-top: 30px;">
    <div class="col-md-6">
        <h5 style="margin-bottom: 20px; font-weight: 600; color: #333;">
            <i class="fas fa-list" style="color: #667eea; margin-right: 10px;"></i>Recent Consultations
        </h5>
        <div class="table-admin">
            <table class="table" style="margin: 0;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Khách Hàng</th>
                        <th>Điện Thoại</th>
                        <th>Số Học Sinh</th>
                        <th>Trạng Thái</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_consultations as $consultation)
                        <tr>
                            <td>#{{ $consultation->id }}</td>
                            <td>{{ $consultation->user?->name ?? 'N/A' }}</td>
                            <td>
                                @if($consultation->user?->phone)
                                    <a href="tel:{{ $consultation->user->phone }}">{{ $consultation->user->phone }}</a>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>{{ $consultation->student_count ?? '—' }}</td>
                            <td>
                                <span class="badge-status badge-{{ strtolower($consultation->status) }}">
                                    {{ ucfirst($consultation->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.consultations.show', $consultation->id) }}" class="btn btn-sm btn-primary" style="font-size: 11px;">Xem</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 20px; color: #999;">Chưa có tư vấn nào</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Reviews -->
    <div class="col-md-6">
        <h5 style="margin-bottom: 20px; font-weight: 600; color: #333;">
            <i class="fas fa-star" style="color: #667eea; margin-right: 10px;"></i>Đánh Giá Gần Đây
        </h5>
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05); padding: 20px;">
            @forelse($recent_reviews as $review)
                <div style="padding-bottom: 15px; border-bottom: 1px solid #e9ecef; margin-bottom: 15px;">
                    <div style="font-weight: 600; color: #333; font-size: 14px;">{{ $review->name }}</div>
                    <div style="color: #666; font-size: 12px; margin: 5px 0;">
                        <i class="fas fa-star" style="color: #ffc107;"></i> {{ $review->rating }}/5
                    </div>
                    <div style="color: #666; font-size: 12px; font-style: italic;">{{ Str::limit($review->quote, 80) }}</div>
                    <a href="{{ route('admin.reviews.show', $review->id) }}" style="color: #667eea; font-size: 11px; text-decoration: none; margin-top: 8px; display: inline-block;">Xem →</a>
                </div>
            @empty
                <p style="text-align: center; color: #999; font-size: 14px;">Chưa có đánh giá nào</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Recent Albums -->
<div class="row" style="margin-top: 30px;">
    <div class="col-md-12">
        <h5 style="margin-bottom: 20px; font-weight: 600; color: #333;">
            <i class="fas fa-images" style="color: #667eea; margin-right: 10px;"></i>Album Gần Đây
        </h5>
        <div class="table-admin">
            <table class="table" style="margin: 0;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ảnh Bìa</th>
                        <th>Tên</th>
                        <th>Concept</th>
                        <th>Ảnh</th>
                        <th>Nổi Bật</th>
                        <th>Đã Xuất Bản</th>
                        <th>Ngày</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_albums as $album)
                        <tr>
                            <td>#{{ $album->id }}</td>
                            <td>
                                @if($album->cover_image)
                                    <img src="{{ $album->cover_image_url }}" alt="Cover" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                                @else
                                    <i class="fas fa-image" style="color: #999;"></i>
                                @endif
                            </td>
                            <td>{{ $album->name }}</td>
                            <td>{{ $album->concept }}</td>
                            <td>{{ $album->photos_count ?? 0 }}</td>
                            <td>
                                @if($album->is_featured)
                                    <i class="fas fa-star" style="color: #ffc107;"></i>
                                @else
                                    <i class="fas fa-star" style="color: #ddd;"></i>
                                @endif
                            </td>
                            <td>
                                @if($album->is_published)
                                    <span class="badge bg-success">Đã Xuất Bản</span>
                                @else
                                    <span class="badge bg-warning">Draft</span>
                                @endif
                            </td>
                            <td>{{ $album->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.albums.show', $album->id) }}" class="btn btn-sm btn-primary" style="font-size: 11px;">Xem</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align: center; padding: 20px; color: #999;">No albums yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

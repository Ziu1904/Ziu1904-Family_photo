@extends('layouts.admin')

@section('title', 'Đặt Lịch #' . $booking->id)
@section('page_title', 'Đặt Lịch #' . $booking->id)

@section('content')
<div style="background: white; border-radius: 8px; padding: 30px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);">
    <div class="row">
        <div class="col-md-6">
            <h5 style="margin-bottom: 20px; font-weight: 600; color: #333;">Chi Tiết Đặt Lịch</h5>
            
            <div style="margin-bottom: 15px;">
                <label style="color: #999; font-size: 12px; text-transform: uppercase; font-weight: 600;">Người Dùng</label>
                <div style="color: #333; font-size: 16px;">{{ $booking->user->name ?? 'N/A' }}</div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="color: #999; font-size: 12px; text-transform: uppercase; font-weight: 600;">Email</label>
                <div style="color: #333; font-size: 16px;">{{ $booking->user->email ?? 'N/A' }}</div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="color: #999; font-size: 12px; text-transform: uppercase; font-weight: 600;">Package</label>
                <div style="color: #333; font-size: 16px;">{{ $booking->package->name ?? 'N/A' }}</div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="color: #999; font-size: 12px; text-transform: uppercase; font-weight: 600;">School</label>
                <div style="color: #333; font-size: 16px;">{{ $booking->school }}</div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="color: #999; font-size: 12px; text-transform: uppercase; font-weight: 600;">Class</label>
                <div style="color: #333; font-size: 16px;">{{ $booking->class }}</div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="color: #999; font-size: 12px; text-transform: uppercase; font-weight: 600;">Số Học Sinh</label>
                <div style="color: #333; font-size: 16px;">{{ $booking->students_count }}</div>
            </div>
        </div>

        <div class="col-md-6">
            <h5 style="margin-bottom: 20px; font-weight: 600; color: #333;">Thông Tin Đặt Lịch</h5>
            
            <div style="margin-bottom: 15px;">
                <label style="color: #999; font-size: 12px; text-transform: uppercase; font-weight: 600;">Concept</label>
                <div style="color: #333; font-size: 16px;">{{ $booking->concept }}</div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="color: #999; font-size: 12px; text-transform: uppercase; font-weight: 600;">Ngày Đặt</label>
                <div style="color: #333; font-size: 16px;">{{ optional($booking->booking_date)->format('d/m/Y') ?? 'N/A' }}</div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="color: #999; font-size: 12px; text-transform: uppercase; font-weight: 600;">Trạng Thái</label>
                <div>
                    <span class="badge-status badge-{{ strtolower($booking->status) }}" style="font-size: 14px;">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="color: #999; font-size: 12px; text-transform: uppercase; font-weight: 600;">Tiền Cọc</label>
                <div style="color: #333; font-size: 16px;">{{ number_format($booking->deposit, 0, ',', '.') }} VND</div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="color: #999; font-size: 12px; text-transform: uppercase; font-weight: 600;">Tổng Giá</label>
                <div style="color: #333; font-size: 16px; font-weight: 600;">{{ number_format($booking->total_price, 0, ',', '.') }} VND</div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="color: #999; font-size: 12px; text-transform: uppercase; font-weight: 600;">Ghi chú</label>
                <div style="color: #333; font-size: 16px;">{{ $booking->notes ?? 'N/A' }}</div>
            </div>
        </div>
    </div>

    <!-- Reviews and Albums -->
    <hr style="margin: 30px 0;">

    <div class="row">
        <div class="col-md-6">
            <h5 style="margin-bottom: 20px; font-weight: 600; color: #333;">Đánh Giá</h5>
            @if($booking->reviews->count())
                @foreach($booking->reviews as $review)
                    <div style="background: #f8f9fa; padding: 15px; border-radius: 6px; margin-bottom: 10px;">
                        <div style="font-weight: 600; color: #333;">{{ $review->name }}</div>
                        <div style="color: #666; font-size: 12px;">{{ $review->school }} - {{ $review->class }}</div>
                        <div style="color: #ffc107; margin: 5px 0;">
                            @for($i = 0; $i < $review->rating; $i++)
                                <i class="fas fa-star"></i>
                            @endfor
                        </div>
                        <p style="margin: 10px 0 0 0; color: #666; font-size: 13px;">{{ $review->quote }}</p>
                    </div>
                @endforeach
            @else
                <p style="color: #999; text-align: center; padding: 20px;">Chưa có đánh giá</p>
            @endif
        </div>

        <div class="col-md-6">
            <h5 style="margin-bottom: 20px; font-weight: 600; color: #333;">Album</h5>
            @if($booking->albums->count())
                @foreach($booking->albums as $album)
                    <div style="background: #f8f9fa; padding: 15px; border-radius: 6px; margin-bottom: 10px;">
                        <div style="font-weight: 600; color: #333;">{{ $album->name }}</div>
                        <div style="color: #666; font-size: 12px;">Concept: {{ $album->concept }}</div>
                        <div style="color: #666; font-size: 12px;">Số ảnh: {{ $album->photos_count }}</div>
                        <div style="margin-top: 8px;">
                            @if($album->is_featured)
                                <span class="badge" style="background: #28a745; color: white; padding: 4px 8px; font-size: 11px;">Nổi bật</span>
                            @endif
                            @if($album->is_published)
                                <span class="badge" style="background: #17a2b8; color: white; padding: 4px 8px; font-size: 11px;">Đã xuất bản</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <p style="color: #999; text-align: center; padding: 20px;">No albums yet</p>
            @endif
        </div>
    </div>

    <div style="margin-top: 30px; text-align: right;">
        <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-primary-admin">Sửa</a>
        <a href="{{ route('admin.bookings.index') }}" class="btn" style="background: #e9ecef; color: #333; border-radius: 6px; padding: 10px 20px; border: none; cursor: pointer; text-decoration: none;">Quay lại</a>
    </div>
</div>
@endsection

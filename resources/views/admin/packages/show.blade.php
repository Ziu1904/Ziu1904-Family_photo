@extends('layouts.admin')

@section('title', 'Gói: ' . $package->name)
@section('page_title', 'Gói: ' . $package->name)

@push('styles')
    <link href="{{ asset('css/admin-reviews.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="review-panel admin-package-panel">
    @php
        $packageBookings = $package->relationLoaded('bookings') ? $package->bookings : collect();
    @endphp
    <div class="row">
        <div class="col-md-8">
            <h5 class="mb-4 fw-bold text-dark">Thông Tin Gói</h5>

            <div class="review-field">
                <label>Tên Gói</label>
                <div class="review-value">{{ $package->name }}</div>
            </div>

            <div class="review-field">
                <label>Giá</label>
                <div class="review-value" style="font-size: 1.5rem; color: #28a745; font-weight: 700;">{{ number_format($package->price, 0, ',', '.') }} VND</div>
            </div>

            <div class="review-field">
                <label>Mô Tả</label>
                <div class="review-value">{{ $package->description }}</div>
            </div>

            <div class="review-field">
                <label>Bao Gồm</label>
                <div class="review-value" style="background: #f8f9fa; padding: 18px; border-radius: 12px;">
                    <div class="mb-2"><strong>Ảnh:</strong> {{ $package->photos_count ?? '0' }}</div>
                    <div class="mb-2"><strong>Video:</strong> {{ $package->videos_count ?? '0' }}</div>
                    <div><strong>Concept:</strong> {{ $package->concepts_count ?? '0' }}</div>
                </div>
            </div>

            @if($package->features)
                <div class="review-field">
                    <label>Tính Năng</label>
                    <div class="review-value" style="background: #f8f9fa; padding: 18px; border-radius: 12px;">
                        @if(is_array($package->features))
                            <ul style="margin: 0; padding-left: 20px;">
                                @foreach($package->features as $feature)
                                    <li style="margin-bottom: 8px;">{{ $feature }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>{{ $package->features }}</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <div class="col-md-4">
            <h5 class="mb-4 fw-bold text-dark">Trạng Thái & Đặt Lịch</h5>
            
            <div class="review-status-card mb-4">
                <div class="status-group mb-3">
                    <label>Trạng Thái</label>
                    <div class="status-value">
                        @if($package->is_active)
                            <span class="badge bg-success">Hoạt Động</span>
                        @else
                            <span class="badge bg-danger">Không Hoạt Động</span>
                        @endif
                    </div>
                </div>

                <div class="status-group">
                    <label>Tổng Đặt Lịch</label>
                    <div class="status-value" style="font-size: 2rem; font-weight: 700;">{{ $packageBookings->count() }}</div>
                </div>
            </div>

            @if($packageBookings->count())
                <h6 class="fw-bold text-dark mb-3">Đặt Lịch Gần Đây</h6>
                <div class="review-status-card p-3">
                    @foreach($packageBookings->take(5) as $booking)
                        <div class="mb-3 pb-3 border-bottom border-secondary">
                            <div class="fw-bold text-dark">Đặt Lịch #{{ $booking->id }}</div>
                            <div class="text-muted small">{{ $booking->user->name ?? 'N/A' }}</div>
                            <div class="text-muted small">{{ optional($booking->booking_date)->format('d/m/Y') ?? 'N/A' }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div style="margin-top: 30px; text-align: right;">
        <a href="{{ route('admin.packages.edit', $package->id) }}" class="btn btn-primary-admin">Sửa</a>
        <a href="{{ route('admin.packages.index') }}" class="btn" style="background: #e9ecef; color: #333; border-radius: 6px; padding: 10px 20px; border: none; cursor: pointer; text-decoration: none;">Quay Lại</a>
    </div>
</div>
@endsection

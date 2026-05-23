@extends('layouts.admin')

@section('title', isset($booking) ? 'Chỉnh Sửa Đặt Lịch' : 'Tạo Đặt Lịch')
@section('page_title', isset($booking) ? 'Chỉnh Sửa Đặt Lịch #' . $booking->id : 'Tạo Đặt Lịch Mới')

@section('content')
<div style="background: white; border-radius: 8px; padding: 30px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05); max-width: 600px;">
    <form action="{{ isset($booking) ? route('admin.bookings.update', $booking->id) : route('admin.bookings.store') }}" method="POST">
        @csrf
        @if(isset($booking))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">Người dùng</label>
            <select name="user_id" class="form-control-admin" style="width: 100%;" required>
                <option value="">Chọn Người Dùng</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ isset($booking) && $booking->user_id === $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
            @error('user_id') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">Gói</label>
            <select name="package_id" class="form-control-admin" style="width: 100%;" required>
                <option value="">Chọn Gói</option>
                @foreach($packages as $package)
                    <option value="{{ $package->id }}" {{ isset($booking) && $booking->package_id === $package->id ? 'selected' : '' }}>
                        {{ $package->name }} - {{ number_format($package->price, 0, ',', '.') }} VND
                    </option>
                @endforeach
            </select>
            @error('package_id') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">Trường</label>
            <input type="text" name="school" class="form-control-admin" value="{{ $booking->school ?? '' }}" required>
            @error('school') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">Lớp</label>
            <input type="text" name="class" class="form-control-admin" value="{{ $booking->class ?? '' }}" required>
            @error('class') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">Số học sinh</label>
            <input type="number" name="students_count" class="form-control-admin" value="{{ $booking->students_count ?? '' }}" min="1" required>
            @error('students_count') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">Concept</label>
            <input type="text" name="concept" class="form-control-admin" value="{{ $booking->concept ?? '' }}" required>
            @error('concept') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">Ngày đặt</label>
            <input type="date" name="booking_date" class="form-control-admin" value="{{ isset($booking) ? optional($booking->booking_date)->format('Y-m-d') : '' }}" required>
            @error('booking_date') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">Trạng thái</label>
            <select name="status" class="form-control-admin" style="width: 100%;" required>
                <option value="pending" {{ isset($booking) && $booking->status === 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                <option value="confirmed" {{ isset($booking) && $booking->status === 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                <option value="completed" {{ isset($booking) && $booking->status === 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                <option value="cancelled" {{ isset($booking) && $booking->status === 'cancelled' ? 'selected' : '' }}>Hủy</option>
            </select>
            @error('status') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">Tiền cọc</label>
            <input type="number" name="deposit" class="form-control-admin" value="{{ $booking->deposit ?? '' }}" step="0.01" min="0">
            @error('deposit') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">Tổng giá</label>
            <input type="number" name="total_price" class="form-control-admin" value="{{ $booking->total_price ?? '' }}" step="0.01" min="0">
            @error('total_price') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">Ghi chú</label>
            <textarea name="notes" class="form-control-admin" rows="4">{{ $booking->notes ?? '' }}</textarea>
            @error('notes') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div style="text-align: right; margin-top: 30px;">
            <button type="submit" class="btn btn-primary-admin">{{ isset($booking) ? 'Cập nhật' : 'Tạo mới' }}</button>
            <a href="{{ route('admin.bookings.index') }}" class="btn" style="background: #e9ecef; color: #333; border-radius: 6px; padding: 10px 20px; border: none; cursor: pointer; text-decoration: none; margin-left: 10px;">Hủy</a>
        </div>
    </form>
</div>
@endsection

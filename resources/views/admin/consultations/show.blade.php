@extends('layouts.admin')

@section('title', 'Consultation Details')
@section('page_title', 'Consultation Details')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.consultations.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Quay Lại
    </a>
</div>

<div class="card" style="box-shadow: 0 2px 10px rgba(0,0,0,0.1); border: none;">
    <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #dee2e6;">
        <h5 class="mb-0">Thông Tin Tư Vấn #{{ $consultation->id }}</h5>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong>Tên Khách Hàng:</strong> {{ $consultation->user?->name ?? 'N/A' }}</p>
                <p><strong>Số Điện Thoại:</strong>
                    @if($consultation->user?->phone)
                        <a href="tel:{{ $consultation->user->phone }}">{{ $consultation->user->phone }}</a>
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </p>
                <p><strong>Gói Dịch Vụ:</strong> {{ $consultation->package?->name ?? 'N/A' }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Số Học Sinh:</strong> {{ $consultation->student_count ?? '—' }}</p>
                <p><strong>Thời Gian Mong Muốn:</strong> {{ $consultation->time ?? '—' }}</p>
                <p><strong>Khu Vực:</strong> {{ $consultation->area ?? '—' }}</p>
                <p><strong>Ngày Đăng Ký:</strong> {{ $consultation->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <p><strong>Ghi Chú Manager:</strong></p>
                <div class="p-3" style="background-color: #f8f9fa; border-radius: 4px;">
                    {{ $consultation->manager_response ?? '(Không có ghi chú)' }}
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <p><strong>Trạng Thái:</strong></p>
                <form method="POST" action="{{ route('admin.consultations.updateStatus', $consultation->id) }}">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3" style="max-width: 400px;">
                        <select name="status" class="form-control" required>
                            <option value="pending" {{ $consultation->status == 'pending' ? 'selected' : '' }}>Đang Chờ</option>
                            <option value="confirmed" {{ $consultation->status == 'confirmed' ? 'selected' : '' }}>Đã Xác Nhận Booking</option>
                            <option value="completed" {{ $consultation->status == 'completed' ? 'selected' : '' }}>Hoàn Thành</option>
                            <option value="cancelled" {{ $consultation->status == 'cancelled' ? 'selected' : '' }}>Đã Hủy</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="manager_response" class="form-label"><strong>Phản hồi Manager</strong></label>
                        <textarea name="manager_response" id="manager_response" class="form-control" rows="4" placeholder="Nhập phản hồi cho khách hàng">{{ $consultation->manager_response }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <form action="{{ route('admin.consultations.destroy', $consultation->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn chắc chắn muốn xóa tư vấn này?')">
                        <i class="fas fa-trash"></i> Xóa Tư Vấn
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

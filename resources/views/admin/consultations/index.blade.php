@extends('layouts.admin')

@section('title', 'Consultations Management')
@section('page_title', 'Consultations Management')

@section('content')
<div style="margin-bottom: 20px;">
    <h4 class="mb-4">Danh Sách Tư Vấn</h4>
</div>

<div class="table-admin">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Khách Hàng</th>
                <th>Số Điện Thoại</th>
                <th>Số Học Sinh</th>
                <th>Thời Gian</th>
                <th>Trạng Thái</th>
                <th>Ngày Đăng Ký</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($consultations as $consultation)
                <tr>
                    <td>#{{ $consultation->id }}</td>
                    <td>{{ $consultation->user?->name ?? 'N/A' }}</td>
                    <td>
                        @if($consultation->phone)
                            <a href="tel:{{ $consultation->phone }}">{{ $consultation->phone }}</a>
                        @elseif($consultation->user?->phone)
                            <a href="tel:{{ $consultation->user->phone }}">{{ $consultation->user->phone }}</a>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>{{ $consultation->student_count ?? '—' }}</td>
                    <td>{{ $consultation->time ?? '—' }}</td>
                    <td>
                        <span class="badge badge-status badge-{{ strtolower($consultation->status) }}">
                            {{ ucfirst($consultation->status) }}
                        </span>
                    </td>
                    <td>{{ $consultation->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.consultations.show', $consultation->id) }}" class="btn btn-sm btn-primary btn-sm-admin">
                            <i class="fas fa-eye"></i> Xem
                        </a>
                        <button class="btn btn-sm btn-warning btn-sm-admin" data-bs-toggle="modal" 
                                data-bs-target="#statusModal" onclick="setConsultationId({{ $consultation->id }})">
                            <i class="fas fa-edit"></i> Cập Nhật
                        </button>
                        <form action="{{ route('admin.consultations.destroy', $consultation->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger btn-sm-admin" onclick="return confirm('Bạn chắc chắn?')">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center; padding: 30px; color: #999;">
                        Chưa có tư vấn nào.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div style="margin-top: 20px;">
    {{ $consultations->links() }}
</div>

<!-- Status Update Modal -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cập Nhật Trạng Thái</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="statusForm">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Trạng Thái</label>
                        <select name="status" class="form-control" required>
                            <option value="">-- Chọn Trạng Thái --</option>
                            <option value="pending">Đang Chờ</option>
                            <option value="confirmed">Đã Xác Nhận</option>
                            <option value="completed">Hoàn Thành</option>
                            <option value="cancelled">Hủy</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function setConsultationId(id) {
    const form = document.getElementById('statusForm');
    form.action = `/admin/consultations/${id}/status`;
}
</script>

    <link href="{{ asset('css/admin-consultations.css') }}" rel="stylesheet">
@endsection

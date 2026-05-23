<div style="background: white; border-radius: 8px; padding: 30px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05); max-width: 600px;">
    <form action="{{ isset($package) ? route('admin.packages.update', $package->id) : route('admin.packages.store') }}" method="POST">
        @csrf
        @if(isset($package))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">Tên Gói</label>
            <input type="text" name="name" class="form-control-admin" value="{{ old('name', $package->name ?? '') }}" required>
            @error('name') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">Mô Tả</label>
            <textarea name="description" class="form-control-admin" rows="4" required>{{ old('description', $package->description ?? '') }}</textarea>
            @error('description') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">Giá (VND)</label>
            <input type="number" name="price" class="form-control-admin" value="{{ old('price', $package->price ?? '') }}" step="1000" min="0" required>
            @error('price') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">Số Lượng Ảnh</label>
            <input type="number" name="photos_count" class="form-control-admin" value="{{ old('photos_count', $package->photos_count ?? '') }}" min="0">
            @error('photos_count') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">Số Lượng Video</label>
            <input type="number" name="videos_count" class="form-control-admin" value="{{ old('videos_count', $package->videos_count ?? '') }}" min="0">
            @error('videos_count') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">Số Lượng Concept</label>
            <input type="number" name="concepts_count" class="form-control-admin" value="{{ old('concepts_count', $package->concepts_count ?? '') }}" min="0">
            @error('concepts_count') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">Tính Năng (mỗi dòng một tính năng)</label>
            <textarea name="features" class="form-control-admin" rows="3" placeholder="Tính năng 1
Tính năng 2
Tính năng 3">{{ old('features', is_array($package->features ?? null) ? implode("\n", $package->features) : ($package->features ?? '')) }}</textarea>
            <small style="color: #666;">Nhập mỗi tính năng trên một dòng riêng biệt</small>
            @error('features') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div style="background: #f8f9fa; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
            <label style="display: flex; align-items: center; cursor: pointer;">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $package->is_active ?? true) ? 'checked' : '' }} style="margin-right: 10px;">
                <span style="color: #333; font-weight: 500;">Hoạt Động (Có thể đặt lịch)</span>
            </label>
        </div>

        <div style="text-align: right; margin-top: 30px;">
            <button type="submit" class="btn btn-primary-admin">{{ isset($package) ? 'Cập Nhật' : 'Tạo' }} Gói</button>
            <a href="{{ route('admin.packages.index') }}" class="btn" style="background: #e9ecef; color: #333; border-radius: 6px; padding: 10px 20px; border: none; cursor: pointer; text-decoration: none; margin-left: 10px;">Hủy</a>
        </div>
    </form>
</div>

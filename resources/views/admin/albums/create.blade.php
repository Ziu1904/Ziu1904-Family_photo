@extends('layouts.admin')

@section('title', isset($album) ? 'Chỉnh Sửa Album' : 'Tạo Album')
@section('page_title', isset($album) ? 'Chỉnh Sửa: ' . $album->name : 'Tạo Album Mới')

@section('content')
<div style="background: white; border-radius: 8px; padding: 30px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); max-width: 700px; margin: 0 auto;">

    <form action="{{ isset($album) ? route('admin.albums.update', $album->id) : route('admin.albums.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($album))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label class="form-label">Tên Album <span style="color:red">*</span></label>
            <input type="text" name="name" class="form-control" 
                   value="{{ $album->name ?? old('name') }}" required>
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Mô Tả</label>
            <textarea name="description" class="form-control" rows="3">{{ $album->description ?? old('description') }}</textarea>
            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Ý Tưởng <span style="color:red">*</span></label>
            <input type="text" name="concept" class="form-control" 
                   value="{{ $album->concept ?? old('concept') }}" required>
            @error('concept') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Gói Dịch Vụ <span style="color:red">*</span></label>
            <select name="package_id" class="form-control" required>
                <option value="">Chọn gói dịch vụ</option>
                @foreach($packages as $package)
                    <option value="{{ $package->id }}"
                        {{ (isset($album) && $album->package_id == $package->id) || old('package_id') == $package->id ? 'selected' : '' }}>
                        {{ $package->name }}
                    </option>
                @endforeach
            </select>
            @error('package_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Number of Photos</label>
                    <input type="number" name="photos_count" class="form-control" 
                           value="{{ $album->photos_count ?? old('photos_count') }}" min="0">
                    @error('photos_count') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Ảnh Bìa (Avatar Album)</label>
                    <input type="file" id="coverImageInput" name="cover_image" class="form-control" accept="image/*">
                    <small class="text-muted">Ảnh mọi định dạng hợp lệ (Tối đa 1GB)</small>
                    @error('cover_image') <span class="text-danger">{{ $message }}</span> @enderror
                    <div id="coverPreview" style="margin-top: 15px; display: none;">
                        <img id="coverImg" src="" alt="Cover Preview" style="max-width: 150px; max-height: 150px; border-radius: 8px; object-fit: cover; display: block;">
                    </div>
                    @if(isset($album) && $album->cover_image)
                        <div style="margin-top: 15px;">
                            <strong>Current Cover:</strong>
                            <img src="{{ $album->cover_image_url }}" style="max-width: 150px; max-height: 150px; border-radius: 8px; object-fit: cover; display: block; margin-top: 8px;">
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Album Photos Folder Upload -->
        <div class="mb-3">
            <label class="form-label">Tải Lên Ảnh Album (Thư Mục)</label>
            <div style="border: 2px dashed #ddd; border-radius: 8px; padding: 30px; text-align: center; cursor: pointer;" id="dropZone">
                <i class="fas fa-cloud-upload-alt" style="font-size: 40px; color: #667eea; margin-bottom: 10px;"></i>
                <p style="margin: 0; color: #333; font-weight: 500;">Chọn thư mục hoặc kéo thả vào đây</p>
                <small style="color: #999;">Ảnh mọi định dạng hợp lệ (Tối đa 20 ảnh, mỗi ảnh tối đa 1GB)</small>
                <input type="file" name="album_photos[]" id="albumPhotos" multiple webkitdirectory mozdirectory directory accept="image/*" style="display: none;">
            </div>
            <div id="fileList" style="margin-top: 15px;"></div>
            @error('album_photos') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                <input type="checkbox" name="is_featured" value="1" 
                       {{ (isset($album) && $album->is_featured) ? 'checked' : '' }}>
                <strong>Album Nổi Bật</strong>
            </label>
        </div>

        <div class="mb-4">
            <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                <input type="checkbox" name="is_published" value="1" 
                       {{ (isset($album) && $album->is_published) ? 'checked' : '' }}>
                <strong>Đã Xuất Bản (Hiển thị cho người dùng)</strong>
            </label>
        </div>

        <div style="text-align: right; margin-top: 30px;">
            <button type="submit" class="btn btn-primary-admin">
                {{ isset($album) ? 'Cập Nhật Album' : 'Tạo Album' }}
            </button>
            <a href="{{ route('admin.albums.index') }}" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('albumPhotos');
    const fileList = document.getElementById('fileList');

    // Click vào drop zone để chọn folder
    dropZone.addEventListener('click', () => {
        fileInput.click();
    });

    // Xử lý drag & drop
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.style.backgroundColor = '#f0f0f0';
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.style.backgroundColor = 'transparent';
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.style.backgroundColor = 'transparent';
        handleFiles(e.dataTransfer.files);
    });

    // Xử lý khi chọn file
    fileInput.addEventListener('change', (e) => {
        handleFiles(e.target.files);
    });

    function handleFiles(files) {
        fileList.innerHTML = '';
        let validFiles = [];

        Array.from(files).forEach((file) => {
            // Kiểm tra loại file
            if (!file.type || !file.type.startsWith('image/')) {
                return;
            }

            // Kiểm tra kích thước (1GB)
            if (file.size > 1024 * 1024 * 1024) {
                return;
            }

            validFiles.push(file);
        });

        if (validFiles.length > 20) {
            validFiles = validFiles.slice(0, 20);
        }

        // Hiển thị danh sách file
        if (validFiles.length > 0) {
            const ul = document.createElement('ul');
            ul.style.listStyle = 'none';
            ul.style.padding = '0';

            validFiles.forEach(file => {
                const li = document.createElement('li');
                li.style.padding = '8px';
                li.style.backgroundColor = '#f9f9f9';
                li.style.marginBottom = '5px';
                li.style.borderRadius = '4px';
                li.innerHTML = `<i class="fas fa-image"></i> ${file.name} (${(file.size / 1024 / 1024).toFixed(2)}MB)`;
                ul.appendChild(li);
            });

            const summary = document.createElement('p');
            summary.style.color = '#28a745';
            summary.style.fontWeight = 'bold';
            summary.style.marginTop = '10px';
            summary.textContent = `✓ Đã chọn ${validFiles.length} ảnh`;

            fileList.appendChild(summary);
            fileList.appendChild(ul);
        }
    }
});

// Handle cover image preview
document.getElementById('coverImageInput')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('coverPreview');
    const img = document.getElementById('coverImg');
    
    if (file && file.type && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(event) {
            img.src = event.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else if (file) {
        alert('Vui lòng chọn file ảnh hợp lệ');
        e.target.value = '';
    }
});
</script>

@endsection
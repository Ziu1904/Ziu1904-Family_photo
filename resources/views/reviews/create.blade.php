<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Gửi Đánh Giá | FamilyMedia</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/web.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/reviews-create.css') }}" rel="stylesheet">
</head>
        
<body>

@include('components.navbar')

<section class="review-form-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="hero-badge"><i class="fas fa-check-circle"></i> Chia sẻ cảm nhận thật</span>
                <h1>Gửi Đánh Giá và Giúp FamilyMedia Hoàn Thiện Hơn</h1>
                <p>Review của bạn là niềm tin để chúng tôi phát triển. Hãy mô tả trải nghiệm chụp ảnh, chất lượng dịch vụ và cảm nhận của lớp bạn.</p>
            </div>
            <div class="col-lg-5 text-lg-end d-none d-lg-block">
                <a href="{{ route('reviews') }}" class="btn btn-light btn-lg">Xem Tất Cả Review</a>
            </div>
        </div>
    </div>
</section>

<div class="container review-list pb-5">
    <div class="row justify-content-center">
        <div class="col-xl-8">
            <div class="review-card">
                <div class="card-body">
                    <h2>Gửi Đánh Giá Của Bạn</h2>
                    <p class="description">Cung cấp thông tin chính xác và chân thành để chúng tôi tiếp tục mang đến dịch vụ chụp ảnh gia đình, kỷ yếu và sự kiện tốt nhất.</p>

                    <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Tên Của Bạn *</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="school" class="form-label">Trường Học *</label>
                                <input type="text" id="school" name="school" value="{{ old('school') }}" class="form-control @error('school') is-invalid @enderror" required>
                                @error('school')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="class" class="form-label">Lớp *</label>
                                <input type="text" id="class" name="class" value="{{ old('class') }}" class="form-control @error('class') is-invalid @enderror" required>
                                @error('class')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Đánh Giá *</label>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="star-rating" id="rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="star" data-value="{{ $i }}"><i class="fas fa-star"></i></span>
                                        @endfor
                                    </div>
                                    <input type="hidden" id="rating-value" name="rating" value="{{ old('rating', 5) }}" required>
                                    <span id="rating-text" style="color: #667eea; font-weight: 700;">5/5</span>
                                </div>
                                @error('rating')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="quote" class="form-label">Bình Luận *</label>
                                <textarea id="quote" name="quote" rows="5" class="form-control @error('quote') is-invalid @enderror" required>{{ old('quote') }}</textarea>
                                @error('quote')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Ảnh Để Lại (Tùy Chọn)</label>
                                <label for="images" class="upload-box" id="upload-box">
                                    <input type="file" id="images" name="images[]" accept="image/jpeg,image/png,image/jpg" multiple style="display:none;">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <p id="upload-text" style="margin-bottom: 6px;">Chọn ảnh hoặc kéo thả vào đây (Có thể chọn nhiều ảnh)</p>
                                    <small>JPG, PNG | Không giới hạn dung lượng</small>
                                </label>
                                <div id="uploaded-files" class="mt-3"></div>
                                @error('images')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-sm-row gap-3 mt-4">
                            <button type="submit" class="btn btn-send flex-grow-1"> <i class="fas fa-paper-plane me-2"></i> Gửi Đánh Giá</button>
                            <a href="{{ route('reviews') }}" class="btn btn-outline-secondary flex-grow-1">Quay Lại Trang Review</a>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger alert-custom mt-4">
                                <i class="fas fa-exclamation-circle me-2"></i> Vui lòng hoàn thiện các thông tin bắt buộc.
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success alert-custom mt-4">
                                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.star-rating .star');
        const ratingValue = document.getElementById('rating-value');
        const ratingText = document.getElementById('rating-text');
        const uploadBox = document.getElementById('upload-box');
        const uploadText = document.getElementById('upload-text');
        const imagesInput = document.getElementById('images');
        const uploadedFilesDiv = document.getElementById('uploaded-files');

        const setRating = value => {
            stars.forEach((star, index) => {
                star.classList.toggle('active', index < value);
            });
            ratingValue.value = value;
            ratingText.textContent = value + '/5';
        };

        setRating(parseInt(ratingValue.value, 10));

        stars.forEach(star => {
            star.addEventListener('click', () => setRating(Number(star.dataset.value)));
            star.addEventListener('mouseover', () => setRating(Number(star.dataset.value)));
        });

        document.querySelector('.star-rating').addEventListener('mouseleave', () => {
            setRating(Number(ratingValue.value));
        });

        const updateFileList = () => {
            uploadedFilesDiv.innerHTML = '';
            if (imagesInput.files && imagesInput.files.length > 0) {
                const fileList = document.createElement('div');
                fileList.className = 'mt-2';
                
                Array.from(imagesInput.files).forEach((file, index) => {
                    const fileItem = document.createElement('div');
                    fileItem.className = 'alert alert-info d-flex justify-content-between align-items-center mb-2';
                    fileItem.innerHTML = `
                        <span><i class="fas fa-image me-2"></i>${file.name}</span>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-file" data-index="${index}">
                            <i class="fas fa-trash"></i>
                        </button>
                    `;
                    fileList.appendChild(fileItem);
                });
                
                uploadedFilesDiv.appendChild(fileList);
                
                // Thêm sự kiện cho nút xóa
                document.querySelectorAll('.remove-file').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        e.preventDefault();
                        const index = parseInt(btn.dataset.index);
                        const dt = new DataTransfer();
                        
                        Array.from(imagesInput.files).forEach((file, i) => {
                            if (i !== index) {
                                dt.items.add(file);
                            }
                        });
                        
                        imagesInput.files = dt.files;
                        updateFileList();
                    });
                });
                
                uploadText.textContent = `${imagesInput.files.length} ảnh được chọn`;
            } else {
                uploadText.textContent = 'Chọn ảnh hoặc kéo thả vào đây (Có thể chọn nhiều ảnh)';
            }
        };

        uploadBox.addEventListener('dragover', e => {
            e.preventDefault();
            uploadBox.style.borderColor = '#667eea';
            uploadBox.style.background = '#eff4ff';
        });
        uploadBox.addEventListener('dragleave', () => {
            uploadBox.style.borderColor = '#cbd5e1';
            uploadBox.style.background = '#f8fbff';
        });
        uploadBox.addEventListener('drop', e => {
            e.preventDefault();
            uploadBox.style.borderColor = '#cbd5e1';
            uploadBox.style.background = '#f8fbff';
            if (e.dataTransfer.files.length) {
                imagesInput.files = e.dataTransfer.files;
                updateFileList();
            }
        });

        imagesInput.addEventListener('change', updateFileList);
    });
</script>

<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/web.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>

<!-- Footer -->
@include('components.footer')
</body>
</html>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đánh Giá Khách Hàng | FamilyMedia</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/web.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/reviews-index.css') }}" rel="stylesheet">
</head>
       
<body>

@include('components.navbar')

<section class="review-hero">
    <div class="container">
        <span class="hero-badge"><i class="fas fa-star"></i> Review chuyên nghiệp cho FamilyMedia</span>
        <h1>Hành Trình Kỷ Niệm Của Bạn, Được Đánh Giá Bằng Trái Tim</h1>
        <p>Khách hàng của FamilyMedia đã tin tưởng và gửi về những chia sẻ chân thật nhất. Hãy đọc review để thấy phong cách phục vụ chuyên nghiệp, tận tâm và sáng tạo.</p>

        <div class="d-flex flex-wrap gap-3 hero-actions">
            <a href="#submit-review" class="btn btn-primary btn-lg"><i class="fas fa-plus me-2"></i> Gửi Review Ngay</a>
            <a href="#review-list" class="btn btn-light btn-lg">Xem Review</a>
        </div>

        <div class="hero-content">
            <div>
                <div class="review-stats">
                    @php
                        $totalReviews = method_exists($reviews, 'total') ? $reviews->total() : $reviews->count();
                    @endphp
                    <div class="review-stat">
                        <span>Tổng Review</span>
                        <strong>{{ $totalReviews }}</strong>
                    </div>
                    <div class="review-stat">
                        <span>Đánh Giá Trung Bình</span>
                        <strong>{{ round($reviews->avg('rating') ?? 5, 1) }}/5</strong>
                    </div>
                    <div class="review-stat">
                        <span>Phản Hồi Mới Nhất</span>
                        <strong>{{ $reviews->first()?->created_at?->format('d/m/Y') ?? 'N/A' }}</strong>
                    </div>
                </div>
            </div>

            <div class="review-form-card" id="submit-review">
                <h3>Gửi Review Ngay Tại Đây</h3>
                <p>Chia sẻ cảm nhận thật của bạn để FamilyMedia tiếp tục nâng tầm dịch vụ và giữ lại những khoảnh khắc gia đình trọn vẹn.</p>

                <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
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
                        <div class="col-12">
                            <label class="form-label">Đánh Giá *</label>
                            <div class="d-flex align-items-center gap-3">
                                <div class="star-rating" id="rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="star" data-value="{{ $i }}"><i class="fas fa-star"></i></span>
                                    @endfor
                                </div>
                                <input type="hidden" id="rating-value" name="rating" value="{{ old('rating', 5) }}" required>
                                <span id="rating-text" style="color: #fff; font-weight: 700;">{{ old('rating', 5) }}/5</span>
                            </div>
                            @error('rating')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="quote" class="form-label">Bình Luận *</label>
                            <textarea id="quote" name="quote" rows="4" class="form-control @error('quote') is-invalid @enderror" required>{{ old('quote') }}</textarea>
                            @error('quote')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Ảnh Đại Diện (Tùy Chọn)</label>
                            <label for="images" class="upload-box" id="upload-box">
                                <input type="file" id="images" name="images[]" accept="image/jpeg,image/png,image/jpg" multiple style="display:none;">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p id="upload-text" style="margin-bottom: 6px;">Chọn ảnh hoặc kéo thả vào đây (Có thể chọn nhiều ảnh)</p>
                                <small>JPG, PNG | Tối đa 20MB</small>
                            </label>
                            <div id="uploaded-files" class="mt-3"></div>
                            @error('images')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-sm-row gap-3 mt-4">
                        <button type="submit" class="btn btn-send flex-grow-1"><i class="fas fa-paper-plane me-2"></i> Gửi Đánh Giá</button>
                        <a href="#review-list" class="btn btn-light flex-grow-1">Xem Review Hiện Có</a>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-custom mt-4">
                            <i class="fas fa-exclamation-circle me-2"></i> Vui lòng hoàn thiện các thông tin bắt buộc.
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</section>

<section class="review-list" id="review-list">
    <div class="container">
        <div class="row review-grid g-4">
            @forelse($reviews as $review)
                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        @if($review->images && $review->images->count() > 0)
                            <img src="{{ $review->images->first()->image_url }}" alt="{{ $review->name }}" class="card-img-top">
                        @else
                            <div class="card-img-top d-flex align-items-center justify-content-center" style="height:260px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <i class="fas fa-user" style="font-size: 60px; color: rgba(255,255,255,0.35);"></i>
                            </div>
                        @endif
                        <div class="review-card-body">
                            <div class="review-meta">
                                <div>
                                    <div class="review-name">{{ $review->name }}</div>
                                    <div class="review-school">{{ $review->school }} @if($review->class) - {{ $review->class }} @endif</div>
                                </div>
                                <span class="review-status-badge">Khách hàng</span>
                            </div>

                            <div class="review-rating">
                                @for($i = 0; $i < 5; $i++)
                                    @if($i < $review->rating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                                <span>{{ $review->rating }}/5</span>
                            </div>

                            <p class="review-quote">"{{ Str::limit($review->quote, 120) }}"</p>

                            <div class="review-meta">
                                <span class="review-date"><i class="far fa-calendar me-2"></i>{{ $review->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p style="color: #64748b; font-size: 1.1rem;">Chưa có đánh giá nào. Hãy là người đầu tiên chia sẻ cảm nhận của bạn!</p>
                </div>
            @endforelse
        </div>

        @if(method_exists($reviews, 'hasPages') && $reviews->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>
</section>

@include('components.footer')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.review-form-card .star-rating .star');
        const ratingValue = document.getElementById('rating-value');
        const ratingText = document.getElementById('rating-text');
        const uploadBox = document.getElementById('upload-box');
        const uploadText = document.getElementById('upload-text');
        const uploadedFilesDiv = document.getElementById('uploaded-files');
        const imageInput = document.getElementById('images');

        const setRating = value => {
            stars.forEach((star, index) => {
                star.classList.toggle('active', index < value);
            });
            ratingValue.value = value;
            ratingText.textContent = `${value}/5`;
        };

        const updateFileLabel = () => {
            if (!imageInput.files || imageInput.files.length === 0) {
                uploadText.textContent = 'Chọn ảnh hoặc kéo thả vào đây (Có thể chọn nhiều ảnh)';
                uploadedFilesDiv.innerHTML = '';
                return;
            }

            if (imageInput.files.length === 1) {
                uploadText.textContent = imageInput.files[0].name;
            } else {
                uploadText.textContent = `${imageInput.files.length} ảnh được chọn`;
            }

            uploadedFilesDiv.innerHTML = '';
            const fileList = document.createElement('div');
            fileList.className = 'mt-2';

            Array.from(imageInput.files).forEach((file, index) => {
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

            document.querySelectorAll('.remove-file').forEach(btn => {
                btn.addEventListener('click', () => {
                    const index = parseInt(btn.dataset.index, 10);
                    const dt = new DataTransfer();

                    Array.from(imageInput.files).forEach((file, i) => {
                        if (i !== index) {
                            dt.items.add(file);
                        }
                    });

                    imageInput.files = dt.files;
                    updateFileLabel();
                });
            });
        };

        setRating(Number(ratingValue.value || 5));

        stars.forEach(star => {
            star.addEventListener('click', () => setRating(Number(star.dataset.value)));
            star.addEventListener('mouseover', () => setRating(Number(star.dataset.value)));
        });

        document.querySelector('.review-form-card .star-rating').addEventListener('mouseleave', () => {
            setRating(Number(ratingValue.value));
        });

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
                imageInput.files = e.dataTransfer.files;
                updateFileLabel();
            }
        });

        imageInput.addEventListener('change', updateFileLabel);
        updateFileLabel();
    });
</script>
</body>
</html>

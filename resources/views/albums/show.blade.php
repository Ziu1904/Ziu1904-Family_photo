<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $album->name }} - Album</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/web.css') }}" rel="stylesheet">
    <link href="{{ asset('css/albums-show.css') }}" rel="stylesheet">
</head>
      
<body>

@include('components.navbar')

<section class="album-hero">
    <div class="container">
        <div class="hero-grid">
            <div class="hero-copy">
                <span class="hero-badge"><i class="fas fa-book-open"></i> Album Premium</span>
                <h1>{{ $album->name }}</h1>
                <p>Album này được thiết kế cho khoảnh khắc đắt giá nhất của bạn: concept tinh tế, màu ảnh chuẩn mực và cấu trúc trình bày phô diễn sang trọng.</p>

                <div class="hero-actions">
                    <a href="#gallery" class="btn btn-primary"><i class="fas fa-images me-2"></i> Xem Album</a>
                    <a href="{{ route('albums') }}" class="btn btn-light"><i class="fas fa-arrow-left me-2"></i> Quay lại Album</a>
                </div>

                <div class="hero-stats">
                    <div class="hero-stat">
                        <span>Concept chính</span>
                        <strong>{{ $album->concept ?? 'Premium' }}</strong>
                    </div>
                    <div class="hero-stat">
                        <span>Số ảnh</span>
                        <strong>{{ $album->photos_count ?? 0 }}</strong>
                    </div>
                    <div class="hero-stat">
                        <span>Ngày hoàn thành</span>
                        <strong>{{ $album->created_at->format('d/m/Y') }}</strong>
                    </div>
                </div>
            </div>

            <div class="hero-preview">
                <div class="album-avatar">
                    @if($album->cover_image_url)
                        <img src="{{ $album->cover_image_url }}" alt="Avatar {{ $album->name }}">
                    @else
                        <div class="album-avatar-placeholder">
                            <i class="fas fa-camera-retro fa-2x"></i>
                        </div>
                    @endif
                </div>

                @if($album->cover_image_url)
                    <img src="{{ $album->cover_image_url }}" alt="{{ $album->name }}">
                @else
                    <div style="height:520px; display:flex; align-items:center; justify-content:center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fas fa-image" style="font-size: 80px; color: rgba(255,255,255,0.45);"></i>
                    </div>
                @endif

                <div class="album-info-card">
                    <div class="tag-list">
                        <span>Ảnh cao cấp</span>
                        <span>Thiết kế chuyên nghiệp</span>
                        <span>Phù hợp kỷ yếu & gia đình</span>
                    </div>
                    <p>{{ $album->description ?? 'Mô tả album chưa có, nhưng chất lượng FamilyMedia luôn được đảm bảo với concept ảnh sang trọng và trải nghiệm lưu giữ kỷ niệm hoàn hảo.' }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="album-detail-section" id="gallery">
    <div class="container">
        <div class="section-top">
            <div>
                <h2>Bộ Sưu Tập Ảnh</h2>
                <p>Cuộn xuống để trải nghiệm những khoảnh khắc nổi bật từ album, với bố cục sáng tạo và phong cách hình ảnh chuyên nghiệp.</p>
            </div>
            <a href="{{ route('albums') }}" class="back-btn"><i class="fas fa-list me-2"></i> Xem Album Khác</a>
        </div>

        @php
            $photos = $album->photos;
            $photosUrls = $photos; // Already URLs
            $photoIndexes = array_keys($photos); // For JavaScript indexing
        @endphp

        @if(count($photos) > 0)
            <div class="album-gallery">
                @foreach($photos as $index => $photoUrl)
                    <div class="gallery-item" onclick="openGallery({{ $index }})">
                        <img src="{{ $photoUrl }}" alt="{{ $album->name }} photo {{ $index + 1 }}" loading="lazy">
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-gallery">
                <i class="fas fa-images"></i>
                <p>Album này hiện chưa có ảnh. Vui lòng thử lại sau hoặc chọn album khác.</p>
            </div>
        @endif
    </div>
</section>

<div id="galleryModal" class="gallery-modal">
    <div class="gallery-modal-content">
        <span class="modal-close" onclick="closeGallery()">&times;</span>
        <img id="modalImage" src="" alt="Album photo">
        <span class="modal-prev" onclick="prevPhoto()">&#10094;</span>
        <span class="modal-next" onclick="nextPhoto()">&#10095;</span>
        <div class="modal-counter">
            <span id="currentIndex">1</span> / <span id="totalImages">1</span>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const photos = @json($photos ?? []);
    const photosUrls = @json($photosUrls ?? []);
    let currentIndex = 0;

    function setModalImage(index) {
        if (!photosUrls.length) return;
        const img = document.getElementById('modalImage');
        img.src = photosUrls[index];
        document.getElementById('currentIndex').textContent = index + 1;
        document.getElementById('totalImages').textContent = photosUrls.length;
    }

    function openGallery(index) {
        if (!photosUrls.length) return;
        currentIndex = index;
        setModalImage(currentIndex);
        document.getElementById('galleryModal').classList.add('show');
    }

    function closeGallery() {
        document.getElementById('galleryModal').classList.remove('show');
    }

    function nextPhoto() {
        if (!photosUrls.length) return;
        currentIndex = (currentIndex + 1) % photosUrls.length;
        setModalImage(currentIndex);
    }

    function prevPhoto() {
        if (!photosUrls.length) return;
        currentIndex = (currentIndex - 1 + photosUrls.length) % photosUrls.length;
        setModalImage(currentIndex);
    }

    document.addEventListener('keydown', function(event) {
        const modal = document.getElementById('galleryModal');
        if (modal.classList.contains('show')) {
            if (event.key === 'ArrowRight') nextPhoto();
            if (event.key === 'ArrowLeft') prevPhoto();
            if (event.key === 'Escape') closeGallery();
        }
    });

    document.getElementById('galleryModal').addEventListener('click', function(e) {
        if (e.target === this) closeGallery();
    });
</script>

@include('components.footer')
</body>
</html>

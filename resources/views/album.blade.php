
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bộ Sưu Tập Ảnh - BFF Media</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/web.css') }}" rel="stylesheet">
    <link href="{{ asset('css/albums.css') }}" rel="stylesheet">
</head>
       
<body>

@include('components.navbar')

<section class="albums-hero">
    <div class="container">
        <div class="hero-content">
            <span class="hero-badge"><i class="fas fa-palette"></i> Bộ Sưu Tập Premium</span>
            <h1>Bộ Sưu Tập Ảnh</h1>
            <p>Khám phá những khoảnh khắc quý giá được lưu giữ với concept sáng tạo và chất lượng hình ảnh chuyên nghiệp. Mỗi album là một câu chuyện, mỗi bức ảnh là một kỷ niệm.</p>

            <div class="hero-stats">
                <div class="hero-stat">
                    <span>Tổng số album</span>
                    <strong>{{ $albums->total() }}</strong>
                </div>
                <div class="hero-stat">
                    <span>Concept đa dạng</span>
                    <strong>Premium</strong>
                </div>
                <div class="hero-stat">
                    <span>Chất lượng</span>
                    <strong>4K</strong>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="albums-section">
    <div class="container">
        <div class="section-header">
            <div>
                <h2>Khám Phá Bộ Sưu Tập</h2>
                <p>Duyệt qua các album được thiết kế chuyên nghiệp, mỗi album mang một phong cách riêng biệt và chứa đựng những khoảnh khắc đáng nhớ nhất.</p>
            </div>
        </div>

        @if($albums->count() > 0)
            <div class="album-grid">
                @foreach($albums as $album)
                    <a href="{{ route('albums.show', $album->id) }}" class="album-card">
                        
                        <div class="album-cover">
                            @if($album->cover_image)
                                <img src="{{ asset('storage/' . $album->cover_image) }}" alt="{{ $album->name }}">
                            @else
                                <i class="fas fa-camera-retro"></i>
                            @endif
                        </div>

                        <div class="album-info">
                            <div class="album-name">{{ $album->name }}</div>

                            <div class="album-stats">
                                @if($album->photos_count)
                                    <div class="album-stat">
                                        <i class="fas fa-images"></i>
                                        <span>{{ $album->photos_count }} ảnh</span>
                                    </div>
                                @endif

                                @if($album->concept)
                                    <div class="album-stat">
                                        <i class="fas fa-sparkles"></i>
                                        <span>{{ $album->concept }}</span>
                                    </div>
                                @endif
                            </div>

                            @if($album->description)
                                <p class="album-description">
                                    {{ Str::limit($album->description, 120) }}
                                </p>
                            @endif
                        </div>

                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($albums->hasPages())
                <div class="d-flex justify-content-center pagination">
                    {{ $albums->links() }}
                </div>
            @endif

        @else
            <div class="empty-state">
                <i class="fas fa-images"></i>
                <p>
                    Chưa có album nào trong bộ sưu tập.
                    Hãy quay lại sau để khám phá những tác phẩm mới!
                </p>

                <a href="{{ route('home') }}" class="btn">
                    Quay Về Trang Chủ
                </a>
            </div>
        @endif
    </div>
</section>

@include('components.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>


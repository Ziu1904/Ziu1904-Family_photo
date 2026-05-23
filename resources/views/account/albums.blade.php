<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Album Của Tôi | FamilyMedia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('css/web.css') }}" rel="stylesheet">
    <link href="{{ asset('css/account.css') }}" rel="stylesheet">
</head>
<body>
    @include('components.navbar')

    <header class="account-header">
        <div class="container">
            <h1>Album Của Tôi</h1>
            <p>Xem các album từ booking của bạn.</p>
        </div>
    </header>

    <div class="container mb-5">
        <div class="row">
            <div class="col-12">
                @if($albums->count() > 0)
                    <div class="album-grid">
                        @foreach($albums as $album)
                            <a href="{{ route('albums.show', $album->id) }}" class="album-card">
                                <div class="album-cover">
                                    @if($album->cover_image_url)
                                        <img src="{{ $album->cover_image_url }}" alt="{{ $album->name }}">
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
                                        <div class="album-stat">
                                            <i class="fas fa-calendar"></i>
                                            <span>{{ $album->created_at->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                    @if($album->description)
                                        <p class="album-description">{{ Str::limit($album->description, 120) }}</p>
                                    @endif
                                    @if(!$album->is_published)
                                        <span class="badge bg-warning">Chưa xuất bản</span>
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
                        <p>Bạn chưa có album nào. Album sẽ được tạo sau khi booking hoàn thành.</p>
                        <a href="{{ route('booking') }}" class="btn">Đặt Lịch Tư Vấn</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @include('components.footer')
</body>
</html>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt Lịch | FamilyMedia</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/web.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/booking.css') }}">
</head>
<body>

@include('components.navbar')

<section class="booking-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="hero-badge"><i class="fas fa-bolt"></i> Dịch Vụ Booking Cao Cấp</span>
                <h1 class="hero-title">Chụp Ảnh Kỷ Yếu & Sự Kiện Gia Đình Theo Phong Cách FamilyMedia</h1>
                <p class="hero-text">Chúng tôi mang đến trải nghiệm chụp ảnh chuyên nghiệp, concept sáng tạo và phục vụ tận tâm. Hãy để FamilyMedia lưu giữ những khoảnh khắc đáng nhớ nhất của lớp bạn.</p>

                <div class="hero-actions d-flex flex-wrap gap-3">
                    <a href="#consultationForm" class="btn btn-primary btn-lg">Đăng Ký Tư Vấn</a>
                    <a href="#packages" class="btn btn-outline-light btn-lg">Xem Gói Dịch Vụ</a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block">
                <div class="hero-card p-4 rounded-4" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); backdrop-filter: blur(14px);">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div>
                            <p class="mb-1 text-uppercase" style="color: #9bb0d9; letter-spacing: 1px; font-size: 0.82rem;">Gói đề xuất hôm nay</p>
                            <h4 class="mb-0" style="color: #fff; font-weight: 700;">Premium Studio Pack</h4>
                        </div>
                        <div class="badge-popular">Ưu Tiên</div>
                    </div>
                    <div class="mb-4" style="color: rgba(255,255,255,0.8);">
                        <p class="mb-2">- 120 ảnh chỉnh sửa</p>
                        <p class="mb-2">- Phông nền studio, concept sáng tạo</p>
                        <p class="mb-0">- 2 video ngắn highlight</p>
                    </div>
                    <a href="#consultationForm" class="btn btn-light btn-lg w-100">Đặt Ngay</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="packages-section" id="packages">
    <div class="container">
        <div class="section-heading">
            <h2>Các Gói Dịch Vụ Nổi Bật</h2>
            <p>Chọn lựa gói chụp ảnh phù hợp với ngân sách và phong cách của lớp bạn. Mỗi gói đều có đầy đủ concept, hậu kỳ và hỗ trợ tư vấn chuyên nghiệp.</p>
        </div>

        <div class="row g-4">
            @if($packages && $packages->count() > 0)
                @foreach($packages as $package)
                <div class="col-md-6 col-lg-4">
                    <div class="package-card">
                        <div class="package-header">
                            <div class="package-name">{{ $package->name }}</div>
                            @if($loop->first)
                                <span class="badge-popular">Phổ Biến</span>
                            @endif
                            <div class="package-price">{{ number_format($package->price, 0, '.', ',') }} đ</div>
                        </div>
                        <div class="package-body">
                            <ul class="package-features">
                                <li><i class="fas fa-images"></i> <strong>{{ $package->photos_count ?? 0 }}+</strong> Ảnh</li>
                                @if($package->videos_count && $package->videos_count > 0)
                                <li><i class="fas fa-video"></i> <strong>{{ $package->videos_count }}</strong> Video</li>
                                @endif
                                @if($package->concepts_count && $package->concepts_count > 0)
                                <li><i class="fas fa-palette"></i> <strong>{{ $package->concepts_count }}</strong> Concept</li>
                                @endif
                                @if($package->features && is_array($package->features))
                                    @foreach($package->features as $feature)
                                    <li><i class="fas fa-check-circle"></i> {{ $feature }}</li>
                                    @endforeach
                                @endif
                            </ul>
                            @if($package->description)
                                <div class="package-footer">{{ Str::limit($package->description, 90) }}</div>
                            @endif
                            <a href="#consultationForm" class="btn btn-outline-primary btn-book-package w-100 mt-4" data-package-id="{{ $package->id }}">
                                <i class="fas fa-calendar-check me-2"></i>Đặt gói này
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-12 text-center">
                    <p class="text-muted">Hiện chưa có gói dịch vụ nào. Vui lòng quay lại sau.</p>
                </div>
            @endif
        </div>
    </div>
</section>

<section class="consultation-section" id="consultationForm">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h3>Đăng Ký Tư Vấn Miễn Phí</h3>
                <p>Bạn sẽ nhận được cuộc gọi tư vấn nhanh trong vòng 24h. Hỗ trợ chọn gói, xây dựng concept và báo giá trọn gói.</p>
                <div class="d-grid gap-3">
                    <div class="p-4 rounded-4" style="background: #f7f8fd; border: 1px solid #e5e9f5;">
                        <p class="mb-1 text-uppercase" style="font-size: 0.85rem; color: #667eea; letter-spacing: 1px;">Hỗ trợ miễn phí</p>
                        <h5 class="mb-0">Tư vấn concept chuyên sâu</h5>
                    </div>
                    <div class="p-4 rounded-4" style="background: #f7f8fd; border: 1px solid #e5e9f5;">
                        <p class="mb-1 text-uppercase" style="font-size: 0.85rem; color: #667eea; letter-spacing: 1px;">Chuẩn bị nhanh</p>
                        <h5 class="mb-0">Báo giá minh bạch và rõ ràng</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0">
                <form method="POST" action="{{ route('consultation.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-school text-primary me-2"></i>Tên Lớp</label>
                            <input type="text" name="class_name" class="form-control input-custom" placeholder="VD: Lớp 12A1" value="{{ old('class_name') }}" required>
                            @error('class_name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-phone text-primary me-2"></i>Số Điện Thoại</label>
                            <input type="tel" name="phone" class="form-control input-custom" placeholder="0988 850 546" value="{{ old('phone') }}" required>
                            @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-box-open text-primary me-2"></i>Chọn Gói</label>
                            <select name="package_id" class="form-select input-custom">
                                <option value="">-- Chọn Gói (Tùy chọn) --</option>
                                @if($packages && $packages->count() > 0)
                                    @foreach($packages as $package)
                                        <option value="{{ $package->id }}" {{ old('package_id') == $package->id ? 'selected' : '' }}>{{ $package->name }} - {{ number_format($package->price, 0, '.', ',') }} đ</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('package_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-map-marker-alt text-primary me-2"></i>Khu Vực</label>
                            <input type="text" name="area" class="form-control input-custom" placeholder="Hà Nội" value="{{ old('area', 'Hà Nội') }}">
                            @error('area') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-users text-primary me-2"></i>Số Lượng Học Sinh</label>
                            <input type="number" name="student_count" class="form-control input-custom" placeholder="50" value="{{ old('student_count') }}" min="1" required>
                            @error('student_count') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-calendar-alt text-primary me-2"></i>Thời Gian Mong Muốn</label>
                            <select name="time" class="form-select input-custom" required>
                                <option value="">-- Chọn Thời Gian --</option>
                                <option value="Tháng 4-5" {{ old('time') == 'Tháng 4-5' ? 'selected' : '' }}>Tháng 4 - 5/2026</option>
                                <option value="Tháng 6-7" {{ old('time') == 'Tháng 6-7' ? 'selected' : '' }}>Tháng 6 - 7/2026</option>
                                <option value="Tháng 8-9" {{ old('time') == 'Tháng 8-9' ? 'selected' : '' }}>Tháng 8 - 9/2026</option>
                                <option value="Khác" {{ old('time') == 'Khác' ? 'selected' : '' }}>Khác</option>
                            </select>
                            @error('time') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label"><i class="fas fa-comment-dots text-primary me-2"></i>Yêu Cầu / Ghi Chú</label>
                            <textarea name="note" class="form-control input-custom" rows="4" placeholder="Chia sẻ yêu cầu đặc biệt của bạn...">{{ old('note') }}</textarea>
                            @error('note') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-submit mt-4 w-100"><i class="fas fa-paper-plane me-2"></i>GỬI YÊU CẦU TƯ VẤN</button>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-custom mt-4">
                            <i class="fas fa-exclamation-circle me-2"></i> <strong>Lỗi:</strong>
                            <ul class="mb-0 mt-2" style="padding-left: 18px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-custom mt-4">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-custom mt-4">
                            <i class="fas fa-times-circle me-2"></i> {{ session('error') }}
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</section>

<section class="review-cta">
    <div class="container">
        <h2>Bạn Đã Chụp Hình Cùng FamilyMedia?</h2>
        <p>Chia sẻ trải nghiệm của bạn để giúp chúng tôi phục vụ tốt hơn và nhận ưu đãi đặc biệt cho lần tiếp theo.</p>
        <a href="{{ route('reviews.create') }}" class="btn btn-light btn-lg">Gửi Đánh Giá Của Bạn</a>
    </div>
</section>

<section class="reviews-preview">
    <div class="container">
        <div class="section-heading">
            <h2>Khách Hàng Nói Gì Về Chúng Tôi</h2>
            <p>Những phản hồi chân thực từ các lớp đã đồng hành cùng FamilyMedia trong hành trình lưu giữ ký ức.</p>
        </div>
        <div class="row g-4">
            @forelse(\App\Models\Review::where('is_published', true)->latest()->take(3)->get() as $review)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm p-0">
                        @if($review->image)
                            <img src="{{ $review->image_url }}" alt="{{ $review->name }}" class="card-img-top" style="height: 220px; object-fit: cover;">
                        @else
                            <div class="card-img-top d-flex align-items-center justify-content-center" style="height: 220px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <i class="fas fa-user" style="font-size: 60px; color: rgba(255,255,255,0.35);"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $review->name }}</h5>
                            <p class="text-muted small mb-3">{{ $review->school }} - {{ $review->class }}</p>
                            <div class="rating-stars mb-3">
                                @for($i = 0; $i < 5; $i++)
                                    @if($i < $review->rating)
                                        <i class="fas fa-star text-warning"></i>
                                    @else
                                        <i class="far fa-star text-muted"></i>
                                    @endif
                                @endfor
                            </div>
                            <p class="card-text">"{{ Str::limit($review->quote, 90) }}"</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Chưa có đánh giá nào.</p>
                </div>
            @endforelse
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('reviews') }}" class="btn btn-outline-primary section-footer-btn">Xem Tất Cả Đánh Giá</a>
        </div>
    </div>
</section>

@include('components.footer')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-book-package').forEach(function (button) {
            button.addEventListener('click', function () {
                var packageId = this.dataset.packageId;
                var select = document.querySelector('select[name="package_id"]');
                if (select && packageId) {
                    select.value = packageId;
                }
            });
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đánh Giá Khách Hàng - FamilyPhoto Studio</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/web.css') }}" rel="stylesheet">
    <link href="{{ asset('css/reviews.css') }}" rel="stylesheet">
</head>
<body>
    @include('components.navbar')

    <div class="reviews-page-header">
        <h1>Cảm Nhận Của Khách Hàng</h1>
        <p>Những lời đánh giá chân thành từ các lớp đã hợp tác cùng chúng tôi</p>
    </div>

    <div class="container-lg" style="padding: 40px 0;">
        <div class="reviews-filters">
            <div class="filter-group">
                <label for="ratingFilter">Lọc Theo Sao:</label>
                <select id="ratingFilter" onchange="filterReviews(this.value)">
                    <option value="all">Tất Cả</option>
                    <option value="5">5 Sao</option>
                    <option value="4">4 Sao Trở Lên</option>
                </select>
            </div>

            <div class="filters-search">
                <input type="text" id="searchReviews" placeholder="Tìm kiếm theo tên, trường...">
                <button onclick="searchReviews()"><i class="fas fa-search"></i></button>
            </div>
        </div>

        {{-- Render reviews server-side để URL ảnh luôn đúng --}}
        <div class="reviews-grid" id="reviewsContainer">
            @include('reviews._reviews_grid', ['reviews' => $reviews])
        </div>
    </div>

    @include('components.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Tạm bỏ js/reviews.js vì file này dùng mẫu data và có thể ghi đè DOM làm lệch đường dẫn ảnh --}}
</body>
</html>

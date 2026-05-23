<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FamilyPhoto Studio - Chụp Ảnh Kỷ Yếu Chuyên Nghiệp</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="/css/web.css" rel="stylesheet">
</head>
<body>
    @include('components.navbar')

    <!-- CAROUSEL BANNER SECTION -->
    <section class="carousel-section">
        <div class="carousel-wrapper">
            <!-- Slide 1: Thời Thành Xuân -->
            <div class="carousel-slide active">
                <div style="background-image: url('{{ asset('img/1.jpg') }}'); background-size: cover; background-position: center; width: 100%; height: 100%;"></div>
                <div class="carousel-content">
                    <h2>Ảnh Kỷ Yếu Thanh Xuân Cùng Family Media</h2>
                    <p>Những khoảnh khắc thanh xuân tươi đẹp được lưu giữ mãi mãi qua từng bộ ảnh kỷ yếu</p>
                    <a href="/booking" class="carousel-btn">LIÊN HỆ BÁO GIÁ ↗</a>
                </div>
                <div class="carousel-counter">1</div>
            </div>

            <!-- Slide 2: Lớp Ảnh Cờ Việt Nam -->
            <div class="carousel-slide">
                <div style="background-image: url('{{ asset('img/2.jpg') }}'); background-size: cover; background-position: center; width: 100%; height: 100%;"></div>
                <div class="carousel-content">
                    <h2>Ghi Lại Những Khoảnh Khắc Của Hành Trình Yêu Thương</h2>
                    <p>Bạn trao niềm tin chúng tôi trao lại những thước phim đáng nhớ</p>
                    <a href="/booking" class="carousel-btn">LIÊN HỆ BÁO GIÁ ↗</a>
                </div>
                <div class="carousel-counter">2</div>
            </div>

            <!-- Slide 3: Concept Studio -->
            <div class="carousel-slide">
                <div style="background-image: url('{{ asset('img/3.jpg') }}'); background-size: cover; background-position: center; width: 100%; height: 100%;"></div>
                <div class="carousel-content">
                    <h2>Biến Những Khoảnh Khắc Thành Vĩnh Cửu</h2>
                    <p>Bạn đồng hành cùng chúng tôi - Chúng tôi mang lại sự hoàn hảo từng góc máy</p>
                    <a href="/booking" class="carousel-btn">LIÊN HỆ BÁO GIÁ ↗</a>
                </div>
                <div class="carousel-counter">3</div>
            </div>

            <!-- Slide 4: Nhóm Bạn -->
            <div class="carousel-slide">
                <div style="background-image: url('{{ asset('img/4.jpg') }}'); background-size: cover; background-position: center; width: 100%; height: 100%;"></div>
                <div class="carousel-content">
                    <h2>Ghi chép từng khoảnh khắc đẹp của hành trình yêu thương</h2>
                    <p>Bạn tin tưởng chúng tôi - chúng tôi tạo lên giá trị qua từng khung ảnh</p>
                    <a href="/booking" class="carousel-btn">LIÊN HỆ BÁO GIÁ ↗</a>
                </div>
                <div class="carousel-counter">4</div>
            </div>

            <!-- Navigation Dots -->
            <div class="carousel-nav">
                <div class="carousel-dot active" onclick="currentSlide(0)"></div>
                <div class="carousel-dot" onclick="currentSlide(1)"></div>
                <div class="carousel-dot" onclick="currentSlide(2)"></div>
                <div class="carousel-dot" onclick="currentSlide(3)"></div>
            </div>
        </div>
    </section>

<!-- ABOUT SECTION -->
<section class="about-section">
    <div class="container-lg">
        <div class="about-container">
            
            <div class="about-video">
                
                <!-- Click vào ảnh -->
                <a href="https://www.facebook.com/Family.media.www" target="_blank" style="display: block; width: 100%; height: 100%;">
                    
                    <div class="about-video-placeholder"
                         style="
                            background-image: url('{{ asset('img/anh-thanh-xuan.jpg') }}');
                            background-size: contain;
                            background-position: center;
                            background-repeat: no-repeat;
                            width: 100%;
                            height: 100%;
                         ">
                    </div>

                </a>

            </div>

            <div class="about-content">
                <h3>VỀ CHÚNG TÔI</h3>
                <h1>FamilyMedia - Dịch Vụ Chụp Ảnh Chuyên Nghiệp</h1>
                <p>Có những khoảnh khắc chỉ đi qua một lần trong đời. Và thanh xuân là điều không thể chụp lại lần thứ hai.</p>
                <p>Trong suốt <strong>hơn 10 năm</strong> đồng hành cùng hàng ngàn lớp học trên khắp Miền Bắc - Miền Trung - Miền Nam. FamilyMedia luôn tiên phong đổi mới, sáng tạo để mỗi bộ kỷ yếu đều mang một dấu ấn đặc cực.</p>
                <p>Chúng tôi hiểu rằng, phía sau mỗi dự án kỷ yếu là sự tin tương của phu huynh, là kỳ vọng của thầy cô, và là kỳ ức quý giá của các bạn học sinh. Vì vậy, BFF Media luôn lựa chọn sự <strong>chỉn chu - tận tâm - trách nhiệm</strong> trong từng chi tiết.</p>

                <div class="about-buttons">
                    <a href="#" class="btn-about-primary">Tư vấn ngay</a>
                    
                    <!-- Link FB ở nút -->
                    <a href="https://www.facebook.com/Family.media.www" target="_blank" class="btn-about-secondary">
                        Xem chi tiết
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

    <!-- PROCESS/TIMELINE SECTION -->
    <section class="process-section">
        <div class="container-lg">
            <h2 class="process-title">QUY TRÌNH LÀM VIỆC</h2>
            
            <div class="process-container">
                <div class="process-timeline">
                    <div class="timeline-line"></div>
                    <div class="timeline-dots" id="timelineDots"></div>
                </div>
                
                <div class="process-cards-wrapper">
                    <div class="process-cards" id="processCards"></div>
                </div>
                
                <div class="process-nav">
                    <button class="process-nav-btn" id="prevBtn" onclick="prevProcessCards()">←</button>
                    <button class="process-nav-btn" id="nextBtn" onclick="nextProcessCards()">→</button>
                </div>
            </div>
        </div>
    </section>

    <!-- WHY CHOOSE US SECTION -->
    <section class="why-choose-section">
        <div class="container-lg">
            <h2 class="why-choose-title">Vì Sao Khách Hàng Tin Chọn FamilyMedia</h2>
            
            <div class="why-choose-container">
                <!-- Left side: Cards -->
                <div class="why-choose-left">
                    <!-- Reason 1 -->
                    <div class="why-choose-card">
                        <div class="reason-number">01</div>
                        <h4 class="reason-title">THƯƠNG HIỆU 10 NĂM<br>LUÔN TIÊN PHONG SÁng TẠO</h4>
                        <ul class="reason-list">
                            <li>Cập nhật xu hướng blend màu mới hàng ngày</li>
                            <li>Luôn đổi mới phong cách, concept hàng năm</li>
                            <li>Tạo trend nhanh chóng để mỗi lớp có một phong cách độc ẩn riêng biệt</li>
                        </ul>
                    </div>

                    <!-- Reason 2 -->
                    <div class="why-choose-card">
                        <div class="reason-number">02</div>
                        <h4 class="reason-title">THIẾT BỊ HIỆN ĐẠI<br>– BẬT KIP XỨ THẾ</h4>
                        <ul class="reason-list">
                            <li>Hệ thống máy ảnh, thiết bị quay phim luôn được nâng cấp theo xu hướng mới nhất</li>
                            <li>Đảm bảo chất lượng hình ảnh, video sắc nét, hiện đại, hợp xu hướng</li>
                        </ul>
                    </div>

                    <!-- Reason 3 -->
                    <div class="why-choose-card">
                        <div class="reason-number">03</div>
                        <h4 class="reason-title">HẬU KỲ<br>CHUYÊN NGHIỆP</h4>
                        <ul class="reason-list">
                            <li>Đội ngũ retoucher chuyên môn cao, xử lý màu sắc tinh tế</li>
                            <li>Sửa được mọi blend màu theo số thích, mongmuốn của khách hàng</li>
                            <li>Mỗi bức ảnh là một tác phẩm nghệ thuật mang dấu ấn riêng của lớp bạn</li>
                        </ul>
                    </div>

                    <!-- Reason 4 -->
                    <div class="why-choose-card">
                        <div class="reason-number">04</div>
                        <h4 class="reason-title">ĐỘI NGŨ NHIẾP ẢNH<br>GIÀU NĂNG LƯỢNG & SÁNG TẠO</h4>
                        <ul class="reason-list">
                            <li>Photographer trẻ trung, nhiệt huyết, hiểu tâm lý học sinh để khai thác kỳ chuyên hình ảnh</li>
                            <li>Luôn tạo không khí vui về, tự nhiên giúp bạn "pose đẹp" nhất</li>
                            <li>Luôn tìm ra ý tưởng mới ngày cô trong điều kiện khô khán về ảnh sáng, địa điểm</li>
                        </ul>
                    </div>

                    <!-- Reason 5 -->
                    <div class="why-choose-card">
                        <div class="reason-number">05</div>
                        <h4 class="reason-title">CHĂM SÓC KHÁCH HÀNG<br>TẬN TÂM 24/7</h4>
                        <ul class="reason-list">
                            <li>Đội ngũ CSKH luôn tâm, chu đáo, sẵn sàng lắng nghe giải đáp, hỗ trợ mọi thắc mắc từ chọn concept – sắp xếp lịch – từ vấn phục - xử lý yếu cầu đặc biệt</li>
                            <li>Luôn đồng hành từ được lên tương cho đến khi album hoàn thiện trên tay khách hàng</li>
                        </ul>
                    </div>

                    <!-- Reason 6 -->
                    <div class="why-choose-card">
                        <div class="reason-number">06</div>
                        <h4 class="reason-title">TRANG PHỤC PHONG PHÚ<br>– SÁCH SẼ, CƠN GẰNG</h4>
                        <ul class="reason-list">
                            <li>Tất cả trang phục luôn sạch, thơm, được giặt là và bảo quản cận thận</li>
                            <li>Được phân loại theo size, tên từng học sinh, động gồi cân thân, giúp tiết kiệm thời gian và mạng lại trải nghiệm chu đáo nhất</li>
                            <li>Nhiều màu trang phục phục đa dạng trong hơn 80+ concept kỳ yếu tại BFFmedia</li>
                        </ul>
                    </div>
                </div>

                <!-- Right side: Sticky Image -->
                <div class="why-choose-right">
                    <div class="sticky-image-wrapper">
                        <img src="{{asset('img/1.jpg')}}" alt="FamilyMedia Photography" class="why-choose-image">
                    </div>
                </div>
            </div>
        </div>
    </section>




    <!-- HERO SECTION - OVERLAY WITH CTA -->
<section class="hero">
    <div class="hero-overlay"></div>

    <div class="container-lg">
        <div class="hero-content text-center">
            <h1 class="hero-title">
                Chúc Mừng Kỷ Yếu Tuyệt Đẹp 🎓
            </h1>

            <p class="hero-subtitle">
                Lưu giữ thanh xuân cùng những concept độc đáo, ekip chuyên nghiệp 
                & album cao cấp dành riêng cho lớp bạn
            </p>

            <div class="hero-buttons">
            <a href="/booking" class="btn-booking">
                <i class="fas fa-calendar-alt"></i> Đặt Lịch Ngay
            </a>
            </div>
        </div>
    </div>
</section>

    <!-- FOOTER -->
    @include('components.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/web.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>



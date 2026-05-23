// Intersection Observer for scroll animations
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
    });
}, {
    threshold: 0.1
});

document.querySelectorAll('.scroll-animation').forEach(el => {
    observer.observe(el);
});

// Carousel Auto Slide
let currentSlideIndex = 0;
const slides = document.querySelectorAll('.carousel-slide');
const dots = document.querySelectorAll('.carousel-dot');
const totalSlides = slides.length;

function showSlide(n) {
    slides.forEach(slide => slide.classList.remove('active'));
    dots.forEach(dot => dot.classList.remove('active'));
    
    slides[n].classList.add('active');
    dots[n].classList.add('active');
    
    // Update carousel counter
    const counters = document.querySelectorAll('.carousel-counter');
    counters.forEach((counter, index) => {
        counter.textContent = (index + 1);
        if (index === n) {
            counter.style.opacity = '1';
        }
    });
}

function nextSlide() {
    currentSlideIndex = (currentSlideIndex + 1) % totalSlides;
    showSlide(currentSlideIndex);
}

function currentSlide(n) {
    currentSlideIndex = n;
    showSlide(currentSlideIndex);
}

// Auto advance every 4 seconds
setInterval(nextSlide, 4000);

// =============== PROCESS CAROUSEL ===============
const processData = [
    { title: "Tư vấn gọi chụp", desc: "Tìm hiểu như cầu lớp và dé xuất gợi chụp, concept, dịch vụ phù hợp." },
    { title: "Tư vấn địa điểm", desc: "Để xứ địa điểm đẹp, phù hợp concept tối ưu chi phí." },
    { title: "Xây dựng concept", desc: "Lắng nghe câu chuyện của lớp → lên moodboard, ý tưởng và tone màu." },
    { title: "Chốt lịch & ký hợp đồng", desc: "Xác nhận ngày chụp, ekip, hợp đồng và tiền đặt cọc." },
    { title: "Gửi timeline buổi chụp", desc: "Thông báo lịch trình chi tiết: giờ tập trung, di chuyển, giờ chụp từng concept, quay MV." },
    { title: "Tư vấn bằng size trang phục", desc: "Gửi form size, tư vấn chọn size phù hợp từng bạn." },
    { title: "Giao trang phục trước 1-2 ngày", desc: "Lớp kiểm tra lại số lượng, size, phụ kiện đầy đủ." },
    { title: "Đối trả trang phục nếu cần", desc: "Hỗ trợ đổi size lỗi hoặc chưa vừa trong ngày chụp để hỗ trợ đối cho lớp." },
    { title: "Tư vấn viên đứng hành xuyên suốt", desc: "Hỗ trợ trước, trong, sau buổi chụp. Giải đáp thắc mắc, hỗ trợ tổ chức và kết nối lớp." },
    { title: "Bàn giao sản phẩm", desc: "Ảnh chính sửa: sau 7-10 ngày\\nVideo kỷ yếu: sau 15-20 ngày" },
    { title: "Chỉnh sửa theo phản hồi", desc: "Điều chỉnh màu sắc, ảnh sáng, chi tiết theo yêu cầu lớp (nếu cần)" },
    { title: "Bàn giao file", desc: "Gửi toàn bộ ảnh chính sửa, video kỷ yếu full chất lượng, ảnh góc (nếu cần)" },
    { title: "Chăm sóc & hậu mãi", desc: "Ưu đãi lớp cũ, voucher giới thiệu lớp mới, hỗ trợ khôi phục file." }
];

let processIndex = 0;
const cardsPerView = 4;
const totalProcessItems = processData.length;
const cardWidth = 100 / cardsPerView;

function renderProcessCards() {
    const container = document.getElementById('processCards');
    container.innerHTML = '';
    
    for (let i = 0; i < totalProcessItems; i++) {
        const data = processData[i];
        const card = document.createElement('div');
        card.className = 'process-card';
        card.style.flex = `0 0 ${cardWidth}%`;
        card.innerHTML = `
            <div class="process-card-number">${i + 1}</div>
            <div class="process-card-title">${data.title}</div>
            <div class="process-card-description">${data.desc}</div>
        `;
        container.appendChild(card);
    }
    
    updateCarousel();
}

function renderTimelineDots() {
    const dotsContainer = document.getElementById('timelineDots');
    dotsContainer.innerHTML = '';
    
    for (let i = 0; i < cardsPerView; i++) {
        const dot = document.createElement('div');
        dot.className = 'timeline-dot';
        dotsContainer.appendChild(dot);
    }
}

function updateTimelineDots() {
    const dots = document.querySelectorAll('.timeline-dot');
    dots.forEach((dot, index) => {
        if (processIndex + index < totalProcessItems) {
            dot.style.opacity = '1';
            dot.style.pointerEvents = 'auto';
        } else {
            dot.style.opacity = '0.3';
            dot.style.pointerEvents = 'none';
        }
    });
}

function updateCarousel() {
    const container = document.getElementById('processCards');
    const offset = -processIndex * cardWidth;
    
    container.style.transform = `translateX(${offset}%)`;
    updateTimelineDots();
    updateButtons();
}

function updateButtons() {
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    
    prevBtn.disabled = processIndex === 0;
    nextBtn.disabled = processIndex + cardsPerView > totalProcessItems;
}

function nextProcessCards() {
    if (processIndex + cardsPerView <= totalProcessItems) {
        processIndex += 1;
        updateCarousel();
    }
}

function prevProcessCards() {
    if (processIndex > 0) {
        processIndex -= 1;
        updateCarousel();
    }
}

renderTimelineDots();
renderProcessCards();
updateTimelineDots();

// =============== REVIEWS (Homepage Preview) ===============
// Reviews data will be loaded from backend API in the future
// For now, create placeholder functions for homepage integration
let homepageReviews = [];
let currentReviewIndex = 0;

function loadHomepageReviews() {
    // Gọi API lấy các đánh giá nổi bật
    fetch('/api/reviews/featured')
        .then(res => res.json())
        .then(data => {
            homepageReviews = data;
            if (homepageReviews.length > 0) {
                displayHomepageReview();
            }
        })
        .catch(err => console.log("Chưa có dữ liệu đánh giá hoặc lỗi API"));
}

function displayHomepageReview() {
    if (homepageReviews.length === 0) return;
    
    const review = homepageReviews[0];
    const container = document.getElementById('reviewsContainer');
    if (container) {
        container.innerHTML = `
            <div class="review-card active">
                <div class="review-header">
                    <div class="review-avatar">${review.name.charAt(0)}</div>
                    <div class="review-info">
                        <h4>${review.name}</h4>
                        <p>${review.school}</p>
                    </div>
                </div>
                <div class="review-quote">"${review.quote}"</div>
            </div>
        `;
    }
}

// Initialize homepage reviews if reviews section exists
window.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('reviewsContainer')) {
        loadHomepageReviews();
    }
});
// ===================== WHY CHOOSE US SECTION JS =====================

document.addEventListener('DOMContentLoaded', function() {

    // Animation khi scroll vào viewport
    const whyCards = document.querySelectorAll('.why-choose-card');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                // Thêm delay để tạo hiệu ứng stagger (từng cái một)
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, index * 120); // Mỗi card delay 120ms
            }
        });
    }, {
        threshold: 0.2,        // Kích hoạt khi 20% card xuất hiện
        rootMargin: "0px 0px -50px 0px"
    });

    // Áp dụng animation ban đầu
    whyCards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(40px)';
        card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
        observer.observe(card);
    });

    // Hover effect mạnh hơn trên mobile (touch)
    if ('ontouchstart' in window) {
        whyCards.forEach(card => {
            card.addEventListener('touchstart', function() {
                this.style.transform = 'translateY(-12px)';
            });
            
            card.addEventListener('touchend', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    }

    // Smooth scroll cho các nút CTA nếu có link #why-choose
    const whyLinks = document.querySelectorAll('a[href="#why-choose"]');
    whyLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector('.why-choose-section');
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    console.log('%cWhy Choose Us Section JS loaded successfully!', 'color: #ff9500; font-weight: bold; font-size: 13px;');
});

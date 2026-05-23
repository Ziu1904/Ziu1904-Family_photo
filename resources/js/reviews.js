// =============== REVIEWS PAGE ===============
// This file handles all review functionality for the dedicated reviews page
// Data will eventually come from backend API

// Sample review data - Will be replaced with backend API
const reviewsData = [
    {
        name: "Thảo My",
        school: "THCS/THPT Amsterdam",
        class: "Lớp Học K35 2024",
        quote: "Minh rất ấn tượng với cách làm việc của các bạn ở BFFMedia. Chuyên nghiệp, để ý tương và luôn lắng nghe những nhu cầu của khách hàng. Nhìn thành phẩm mà tôi cảm xúc và thắt sự đẳng giá.",
        image: "https://via.placeholder.com/400x500?text=Thao+My",
        rating: 5
    },
    {
        name: "Kim Ngân",
        school: "THCS/THPT Beacon",
        class: "Lớp Chuyên Anh K34 2024",
        quote: "Tưng lộ tưng chọn studio sài, nhưng BFFMedia khiến mình thật sự yên tâm. Ekip làm việc tận tâm, hướng dẫn nhiệt tình và bất khoảnh khắc rất tự nhiên. Ảnh nhân về đẹp ngoài mong đợi.",
        image: "https://via.placeholder.com/400x500?text=Kim+Ngan",
        rating: 5
    },
    {
        name: "Hoàng Minh",
        school: "THCS/THPT Thăng Long",
        class: "Lớp 12A1 Năm 2024",
        quote: "Chup kỷ yếu mà ai cũng khen BFFMedia làm việc nhanh, nhiệt tình, không để khách chỉ lâu. Lần đầu hợp tác nhưng những cực kỳ hài lòng. Chắc chắn sẽ giới thiệu với các lớp khác.",
        image: "https://via.placeholder.com/400x500?text=Hoang+Minh",
        rating: 5
    }
];

let currentReviewIndex = 0;

// Load reviews from backend API (when ready)
async function loadReviewsFromBackend() {
    try {
        // TODO: Replace URL with actual API endpoint
        // const response = await fetch('/api/reviews');
        // const data = await response.json();
        // return data;
        
        // For now, return sample data
        return reviewsData;
    } catch (error) {
        console.error('Error loading reviews:', error);
        return reviewsData;
    }
}

// Display reviews in grid/carousel
function renderReviews(reviews) {
    const container = document.getElementById('reviewsContainer');
    if (!container) return;
    
    container.innerHTML = '';

    reviews.forEach((review, index) => {
        const card = document.createElement('div');
        card.className = 'review-card' + (index === 0 ? ' active' : '');
        
        const starsHTML = '⭐'.repeat(review.rating);
        
        card.innerHTML = `
            <div class="review-image">
                <img src="${review.image}" alt="${review.name}">
            </div>
            <div class="review-content">
                <div class="review-header">
                    <div class="review-avatar">${review.name.charAt(0)}</div>
                    <div class="review-info">
                        <h4>${review.name}</h4>
                        <p>${review.school}</p>
                        <small>${review.class}</small>
                    </div>
                </div>
                <div class="review-rating">${starsHTML}</div>
                <div class="review-quote">"${review.quote}"</div>
            </div>
        `;
        container.appendChild(card);
    });
}

// Render pagination dots
function renderReviewDots(count) {
    const container = document.getElementById('reviewDots');
    if (!container) return;
    
    container.innerHTML = '';

    for (let i = 0; i < count; i++) {
        const dot = document.createElement('div');
        dot.className = 'review-dot' + (i === 0 ? ' active' : '');
        dot.onclick = () => goToReview(i);
        container.appendChild(dot);
    }
}

// Update review display
function updateReviewDisplay(reviews) {
    const cards = document.querySelectorAll('.review-card');
    const dots = document.querySelectorAll('.review-dot');

    cards.forEach((card, index) => {
        if (index === currentReviewIndex) {
            card.classList.add('active');
        } else {
            card.classList.remove('active');
        }
    });

    dots.forEach((dot, index) => {
        if (index === currentReviewIndex) {
            dot.classList.add('active');
        } else {
            dot.classList.remove('active');
        }
    });

    // Update image and school info
    const review = reviews[currentReviewIndex];
    const reviewImage = document.getElementById('reviewImage');
    const reviewSchool = document.getElementById('reviewSchool');
    const reviewClass = document.getElementById('reviewClass');
    
    if (reviewImage) reviewImage.src = review.image;
    if (reviewSchool) reviewSchool.textContent = review.school;
    if (reviewClass) reviewClass.textContent = review.class;
}

// Navigation functions
function nextReview(reviews) {
    currentReviewIndex = (currentReviewIndex + 1) % reviews.length;
    updateReviewDisplay(reviews);
}

function prevReview(reviews) {
    currentReviewIndex = (currentReviewIndex - 1 + reviews.length) % reviews.length;
    updateReviewDisplay(reviews);
}

function goToReview(index, reviews) {
    currentReviewIndex = index;
    updateReviewDisplay(reviews);
}

// Filter reviews
function filterReviewsByRating(reviews, rating) {
    if (rating === 'all') return reviews;
    return reviews.filter(review => review.rating >= parseInt(rating));
}

// Search reviews
function searchReviews(reviews, query) {
    if (!query) return reviews;
    const lowerQuery = query.toLowerCase();
    return reviews.filter(review => 
        review.name.toLowerCase().includes(lowerQuery) ||
        review.school.toLowerCase().includes(lowerQuery) ||
        review.quote.toLowerCase().includes(lowerQuery)
    );
}

// Initialize reviews page
async function initializeReviewsPage() {
    const reviews = await loadReviewsFromBackend();
    
    if (reviews && reviews.length > 0) {
        renderReviews(reviews);
        renderReviewDots(reviews.length);
        updateReviewDisplay(reviews);
        
        // Attach global functions for HTML onclick handlers
        window.nextReview = () => nextReview(reviews);
        window.prevReview = () => prevReview(reviews);
        window.goToReview = (index) => goToReview(index, reviews);
        window.filterReviews = (rating) => {
            const filtered = filterReviewsByRating(reviews, rating);
            currentReviewIndex = 0;
            renderReviews(filtered);
            renderReviewDots(filtered.length);
            updateReviewDisplay(filtered);
        };
        window.searchReviews = () => {
            const searchInput = document.getElementById('searchReviews');
            if (searchInput) {
                const filtered = searchReviews(reviews, searchInput.value);
                currentReviewIndex = 0;
                renderReviews(filtered);
                renderReviewDots(filtered.length);
                if (filtered.length > 0) {
                    updateReviewDisplay(filtered);
                }
            }
        };
    } else {
        const container = document.getElementById('reviewsContainer');
        if (container) {
            container.innerHTML = '<div style="text-align: center; padding: 40px;"><p>Chưa có đánh giá</p></div>';
        }
    }
}

// Initialize when DOM is ready
window.addEventListener('DOMContentLoaded', initializeReviewsPage);

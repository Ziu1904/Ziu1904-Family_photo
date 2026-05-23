@php
    /** @var \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|array $reviews */
@endphp

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

                    <p class="review-quote">"{{ \Illuminate\Support\Str::limit($review->quote, 120) }}"</p>

                    <div class="review-meta">
                        <span class="review-date"><i class="far fa-calendar me-2"></i>{{ $review->created_at?->format('d/m/Y') }}</span>
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


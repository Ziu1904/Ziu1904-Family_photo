@extends('layouts.admin')

@section('title', 'Review #' . $review->id)
@section('page_title', 'Review #' . $review->id)

@push('styles')
    <link href="{{ asset('css/admin-reviews.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="review-panel">
    <div class="row">
        <div class="col-md-8">
            <div class="review-section">
                <h5>Review Information</h5>

                <div class="review-field">
                    <label>Name</label>
                    <div class="review-value">{{ $review->name }}</div>
                </div>

                <div class="review-field">
                    <label>School</label>
                    <div class="review-value">{{ $review->school }}</div>
                </div>

                <div class="review-field">
                    <label>Class</label>
                    <div class="review-value">{{ $review->class }}</div>
                </div>

                <div class="review-field">
                    <label>Rating</label>
                    <div class="review-value">
                        <span class="text-warning">
                            @for($i = 0; $i < $review->rating; $i++)
                                <i class="fas fa-star"></i>
                            @endfor
                        </span>
                        <span class="ms-2">{{ $review->rating }} / 5</span>
                    </div>
                </div>

                <div class="review-field">
                    <label>Review Quote</label>
                    <div class="review-value">{{ $review->quote }}</div>
                </div>
            </div>

            @if($review->images && $review->images->count() > 0)
                <div class="review-section">
                    <h5>Images ({{ $review->images->count() }})</h5>
                    <div class="review-images-grid">
                        @foreach($review->images as $image)
                            <div class="review-image-item">
                                <img src="{{ $image->image_url }}" alt="Review Image">
                                <div class="image-actions">
                                    <form action="{{ route('admin.review-images.destroy', $image->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this image?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="col-md-4">
            <div class="review-status-card">
                <div class="status-group">
                    <label>Featured</label>
                    <div class="status-value">
                        @if($review->is_featured)
                            <span class="badge bg-success">Yes</span>
                        @else
                            <span class="badge bg-secondary">No</span>
                        @endif
                    </div>
                </div>

                <div class="status-group">
                    <label>Published</label>
                    <div class="status-value">
                        @if($review->is_published)
                            <span class="badge bg-info">Yes</span>
                        @else
                            <span class="badge bg-secondary">No</span>
                        @endif
                    </div>
                </div>

                @if($review->booking)
                    <div class="status-group">
                        <label>Associated Booking</label>
                        <div class="status-value">
                            Booking #{{ $review->booking->id }}<br>
                            <span class="text-muted">{{ $review->booking->user->name ?? 'N/A' }} · {{ $review->booking->package->name ?? 'N/A' }}</span>
                        </div>
                        <a href="{{ route('admin.bookings.show', $review->booking->id) }}" class="small text-primary">View Booking →</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="review-card-actions mt-4">
        <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection

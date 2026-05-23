@extends('layouts.admin')

@section('title', 'Reviews Management')
@section('page_title', 'Reviews Management')

@push('styles')
    <link href="{{ asset('css/admin-reviews.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="table-admin review-table-wrapper">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>School</th>
                <th>Rating</th>
                <th>Featured</th>
                <th>Published</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reviews as $review)
                <tr>
                    <td>#{{ $review->id }}</td>
                    <td>{{ $review->name }}</td>
                    <td>{{ $review->school }}</td>
                    <td>
                        <span style="color: #ffc107;">
                            @for($i = 0; $i < $review->rating; $i++)
                                <i class="fas fa-star"></i>
                            @endfor
                        </span> {{ $review->rating }}/5
                    </td>
                    <td>
                        @if($review->is_featured)
                            <span class="badge" style="background: #28a745; color: white;">Yes</span>
                        @else
                            <span class="badge" style="background: #ccc; color: white;">No</span>
                        @endif
                    </td>
                    <td>
                        @if($review->is_published)
                            <span class="badge badge-info">Published</span>
                        @else
                            <span class="badge badge-warning">Pending</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.reviews.show', $review->id) }}" class="btn btn-sm btn-primary btn-sm-admin">View</a>
                        
                        @if(!$review->is_published)
                            <!-- Pending: Show Approve & Reject -->
                            <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success btn-sm-admin" title="Approve and publish">
                                    <i class="fas fa-check"></i> Approve
                                </button>
                            </form>
                            <form action="{{ route('admin.reviews.reject', $review->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger btn-sm-admin" title="Reject review">
                                    <i class="fas fa-times"></i> Reject
                                </button>
                            </form>
                        @else
                            <!-- Published: Show Unpublish & Feature -->
                            <form action="{{ route('admin.reviews.toggle-featured', $review->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-info btn-sm-admin">
                                    {{ $review->is_featured ? 'Unfeature' : 'Feature' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.reviews.reject', $review->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-warning btn-sm-admin" title="Unpublish review">
                                    <i class="fas fa-eye-slash"></i> Unpublish
                                </button>
                            </form>
                        @endif
                        
                        <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger btn-sm-admin" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        No reviews found. <a href="{{ route('admin.reviews.create') }}">Create one now</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div style="margin-top: 20px;">
    {{ $reviews->links() }}
</div>
@endsection

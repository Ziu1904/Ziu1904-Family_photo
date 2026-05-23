<form action="{{ isset($review) ? route('admin.reviews.update', $review->id) : route('admin.reviews.store') }}" 
      method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($review))
        @method('PUT')
    @endif

    <div class="mb-3">
        <label class="form-label">Associated Consultation (Optional)</label>
        <select name="consultation_id" class="form-control-admin">
            <option value="">Select Consultation</option>
            @foreach($consultations as $consultation)
                <option value="{{ $consultation->id }}" {{ old('consultation_id', $review->consultation_id ?? '') == $consultation->id ? 'selected' : '' }}>
                    Consultation #{{ $consultation->id }} - {{ $consultation->user->name ?? 'N/A' }} ({{ $consultation->package->name ?? 'No package' }})
                </option>
            @endforeach
        </select>
        @error('consultation_id') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control-admin" value="{{ old('name', $review->name ?? '') }}" required>
        @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">School *</label>
        <input type="text" name="school" class="form-control-admin" value="{{ old('school', $review->school ?? '') }}" required>
        @error('school') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Class *</label>
        <input type="text" name="class" class="form-control-admin" value="{{ old('class', $review->class ?? '') }}" required>
        @error('class') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Review Quote</label>
        <textarea name="quote" class="form-control-admin" rows="4" required>{{ old('quote', $review->quote ?? '') }}</textarea>
        @error('quote') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Rating (1-5)</label>
        <select name="rating" class="form-control-admin" required>
            <option value="">Select Rating</option>
            @for($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}" {{ old('rating', $review->rating ?? '') == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
            @endfor
        </select>
        @error('rating') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Upload Images (Multiple)</label>
        <input type="file" name="images[]" class="form-control-admin" multiple accept="image/jpeg,image/png">
        <small class="text-muted">JPG, PNG - No size limit</small>
        @if(isset($review) && $review->images && $review->images->count() > 0)
            <div style="margin-top: 15px;">
                <p class="text-muted"><strong>Current Images:</strong></p>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 10px;">
                    @foreach($review->images as $image)
                        <div style="position: relative; border-radius: 6px; overflow: hidden; background: #f0f0f0;">
                            <img src="{{ $image->image_url }}" alt="Review Image" style="width: 100%; height: 120px; object-fit: cover;">
                            <form action="{{ route('review-images.destroy', $image->id) }}" method="POST" style="position: absolute; top: 0; right: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" style="border-radius: 0; margin: 0;" onclick="return confirm('Delete this image?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        @error('images') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label>
            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $review->is_featured ?? false) ? 'checked' : '' }}>
            Featured (Show on homepage)
        </label>
    </div>

    <div class="mb-3">
        <label>
            <input type="checkbox" name="is_published" value="1" {{ old('is_published', $review->is_published ?? false) ? 'checked' : '' }}>
            Published (Visible to users)
        </label>
    </div>

    <div class="text-end mt-4">
        <button type="submit" class="btn btn-primary-admin">{{ isset($review) ? 'Update' : 'Create' }} Review</button>
        <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>

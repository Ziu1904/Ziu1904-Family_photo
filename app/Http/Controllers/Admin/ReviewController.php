<?php

namespace App\Http\Controllers\Admin;

use App\Models\Review;
use App\Models\ReviewImage;
use App\Models\Consultation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('consultation', 'images')
            ->latest()
            ->paginate(15);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function show(Review $review)
    {
        $review->load('consultation.user', 'consultation.package', 'images');
        return view('admin.reviews.show', compact('review'));
    }

    public function create()
    {
        $consultations = Consultation::with('user', 'package')->get();
        return view('admin.reviews.create', compact('consultations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'consultation_id'   => 'nullable|exists:consultations,id',
            'name'         => 'required|string|max:255',
            'school'       => 'required|string|max:255',
            'class'        => 'required|string|max:255',
            'quote'        => 'required|string|max:1000',
            'rating'       => 'required|integer|min:1|max:5',
            'images'       => 'nullable|array',
            'images.*'     => 'image|mimes:jpg,jpeg,png',
            'is_featured'  => 'boolean',
            'is_published' => 'boolean',
        ]);

        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_published'] = $request->has('is_published');

        // Loại bỏ images khỏi validated data
        $images = $validated['images'] ?? [];
        unset($validated['images']);

        // Tạo review
        $review = Review::create($validated);

        // Lưu hình ảnh
        if (!empty($images) && $request->hasFile('images')) {
            $order = 0;
            foreach ($request->file('images') as $file) {
                $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('reviews', $filename, 'public');
                
                ReviewImage::create([
                    'review_id' => $review->id,
                    'image_path' => $path,
                    'order' => $order++,
                ]);
            }
        }

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review created successfully!');
    }

    public function edit(Review $review)
    {
        $review->load('images');
        $consultations = Consultation::with('user', 'package')->get();
        return view('admin.reviews.edit', compact('review', 'consultations'));
    }

    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            'consultation_id'   => 'nullable|exists:consultations,id',
            'name'         => 'required|string|max:255',
            'school'       => 'required|string|max:255',
            'class'        => 'required|string|max:255',
            'quote'        => 'required|string|max:1000',
            'rating'       => 'required|integer|min:1|max:5',
            'images'       => 'nullable|array',
            'images.*'     => 'image|mimes:jpg,jpeg,png',
            'is_featured'  => 'boolean',
            'is_published' => 'boolean',
        ]);

        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_published'] = $request->has('is_published');

        // Loại bỏ images khỏi validated data
        $images = $validated['images'] ?? [];
        unset($validated['images']);

        // Cập nhật review
        $review->update($validated);

        // Thêm hình ảnh mới
        if (!empty($images) && $request->hasFile('images')) {
            $maxOrder = $review->images()->max('order') ?? -1;
            $order = $maxOrder + 1;
            
            foreach ($request->file('images') as $file) {
                $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('reviews', $filename, 'public');
                
                ReviewImage::create([
                    'review_id' => $review->id,
                    'image_path' => $path,
                    'order' => $order++,
                ]);
            }
        }

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review updated successfully!');
    }

    public function destroy(Review $review)
    {
        // Xóa tất cả hình ảnh
        foreach ($review->images as $image) {
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
        }
        $review->delete();
        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully!');
    }

    public function destroyImage(ReviewImage $image)
    {
        $reviewId = $image->review_id;
        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }
        $image->delete();
        return redirect()->back()->with('success', 'Image deleted successfully!');
    }

    public function toggleFeatured(Review $review)
    {
        $review->update(['is_featured' => !$review->is_featured]);
        return redirect()->back()->with('success', 'Featured status updated!');
    }

    public function togglePublished(Review $review)
    {
        $review->update(['is_published' => !$review->is_published]);
        return redirect()->back()->with('success', 'Published status updated!');
    }

    public function approve(Review $review)
    {
        $review->update(['is_published' => true]);
        return redirect()->back()->with('success', 'Review approved and published!');
    }

    public function reject(Review $review)
    {
        $review->update(['is_published' => false]);
        return redirect()->back()->with('success', 'Review rejected!');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\ReviewImage;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Hiển thị danh sách review đã được publish
     */
    public function index()
    {
        $reviews = Review::published()
            ->with('images')
            ->latest()
            ->paginate(10);

        return view('reviews.index', compact('reviews'));
    }

    /**
     * Hiển thị form tạo review
     */
    public function create()
    {
        return view('reviews.create');
    }

    /**
     * Lưu review mới từ form
     */
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
        ]);

        try {
            // Chờ Admin duyệt trước khi hiển thị
            $validated['is_published'] = false;
            $validated['is_featured'] = false;

            // Loại bỏ images khỏi validated data để không lưu vào Review
            $files = $request->file('images', []);
            unset($validated['images']);

            // Tạo review
            $review = Review::create($validated);

            // Nếu có upload ảnh, lưu từng file vào storage/public/reviews
            $savedImagePath = null;
            if (!empty($files)) {
                $order = 0;
                foreach ((array) $files as $file) {
                    if (! $file || ! $file->isValid()) {
                        continue;
                    }

                    $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('reviews', $filename, 'public');

                    ReviewImage::create([
                        'review_id' => $review->id,
                        'image_path' => $path,
                        'order' => $order++,
                    ]);

                    if ($savedImagePath === null) {
                        $savedImagePath = $path;
                    }
                }
            }

            if ($savedImagePath) {
                $review->image = $savedImagePath;
                $review->save();
            }

            return redirect()->route('reviews')
                ->with('success', 'Cảm ơn bạn đã gửi đánh giá! Chúng tôi sẽ duyệt và hiển thị đánh giá của bạn sớm.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi khi lưu đánh giá. Vui lòng thử lại sau.')
                ->withInput();
        }
    }
}

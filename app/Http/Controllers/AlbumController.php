<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AlbumController extends Controller
{
    /**
     * Display a listing of published albums
     */
    public function index()
    {
        $albums = Album::where('is_published', true)
            ->latest()
            ->paginate(12);

        return view('album', compact('albums'));
    }

    /**
     * Display a specific album
     */
    public function show(Album $album)
    {
        if (!$album->is_published) {
            if (!auth()->check() || auth()->user()->role !== 'admin') {
                abort(404);
            }
        }

        return view('albums.show', compact('album'));
    }

    /**
     * Store new album
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_id'      => 'required|exists:packages,id',
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'concept'         => 'required|string|max:255',
            'photos_count'    => 'nullable|integer|min:0',
            'cover_image'     => 'nullable|image|max:5120',
            'album_photos'    => 'nullable|array',
            'album_photos.*'  => 'image|max:5120',
            'is_featured'     => 'boolean',
            'is_published'    => 'boolean',
        ]);

        try {
            if ($request->hasFile('cover_image')) {
                $file = $request->file('cover_image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $validated['cover_image'] = $file->storeAs('albums', $filename, 'public');
            }

            $validated['is_featured'] = $request->has('is_featured');
            $validated['is_published'] = $request->has('is_published');

            $album = Album::create($validated);

            $photoCount = 0;
            if ($request->hasFile('album_photos')) {
                $photos = $request->file('album_photos');
                $albumFolder = 'albums/album_' . $album->id;

                foreach ($photos as $photo) {
                    if ($photo->isValid()) {
                        $filename = time() . '_' . rand(1000, 9999) . '.' . $photo->getClientOriginalExtension();
                        $photo->storeAs($albumFolder, $filename, 'public');
                        $photoCount++;
                    }
                }

                if ($photoCount > 0) {
                    $album->update(['photos_count' => $photoCount]);
                }
            }

            return redirect()->route('admin.albums.index')
                             ->with('success', 'Tạo album thành công với ' . $photoCount . ' ảnh!');
        } catch (\Exception $e) {
            return redirect()->back()
                             ->with('error', 'Lỗi: ' . $e->getMessage())
                             ->withInput();
        }
    }

    // ... (các hàm edit, update, toggleFeatured, destroy giữ nguyên)

    /**
     * Update album
     */
    public function update(Request $request, Album $album)
    {
        $validated = $request->validate([
            'package_id'      => 'required|exists:packages,id',
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'concept'         => 'required|string|max:255',
            'photos_count'    => 'nullable|integer|min:0',
            'cover_image'     => 'nullable|image|max:5120',
            'album_photos'    => 'nullable|array',
            'album_photos.*'  => 'image|max:5120',
            'is_featured'     => 'boolean',
            'is_published'    => 'boolean',
        ]);

        try {
            if ($request->hasFile('cover_image')) {
                $file = $request->file('cover_image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $validated['cover_image'] = $file->storeAs('albums', $filename, 'public');
            }

            $validated['is_featured'] = $request->has('is_featured');
            $validated['is_published'] = $request->has('is_published');

            if ($request->hasFile('album_photos')) {
                $photos = $request->file('album_photos');
                $albumFolder = 'albums/album_' . $album->id;
                $photoCount = $album->photos_count ?? 0;

                foreach ($photos as $photo) {
                    if ($photo->isValid()) {
                        $filename = time() . '_' . rand(1000, 9999) . '.' . $photo->getClientOriginalExtension();
                        $photo->storeAs($albumFolder, $filename, 'public');
                        $photoCount++;
                    }
                }

                $validated['photos_count'] = $photoCount;
            }

            $album->update($validated);

            return redirect()->route('admin.albums.index')
                             ->with('success', 'Album updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                             ->with('error', 'Error: ' . $e->getMessage())
                             ->withInput();
        }
    }

    /**
     * Show edit form
     */
    public function edit(Album $album)
    {
        $packages = Package::all();
        return view('admin.albums.edit', compact('album', 'packages'));
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Album $album)
    {
        $album->update(['is_featured' => !$album->is_featured]);
        return back()->with('success', 'Album updated!');
    }

    /**
     * Remove the specified album
     */
    public function destroy(Album $album)
    {
        // Xóa folder ảnh
        $albumFolder = storage_path('app/public/albums/album_' . $album->id);
        if (File::exists($albumFolder)) {
            File::deleteDirectory($albumFolder);
        }

        // Xóa cover image
        if ($album->cover_image) {
            $coverPath = storage_path('app/public/' . $album->cover_image);
            if (File::exists($coverPath)) {
                File::delete($coverPath);
            }
        }

        $album->delete();

        return redirect()->route('admin.albums.index')
                         ->with('success', 'Album đã được xóa thành công!');
    }
}
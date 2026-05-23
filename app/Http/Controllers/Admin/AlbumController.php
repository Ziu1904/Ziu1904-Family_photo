<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::with(['package'])
                       ->latest()
                       ->paginate(15);

        $featured = Album::where('is_featured', true)->count();

        return view('admin.albums.index', compact('albums', 'featured'));
    }

    public function create()
    {
        $packages = Package::all();
        return view('admin.albums.create', compact('packages'));
    }

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
                if ($file->isValid()) {
                    $filename = time() . '_' . preg_replace('/[^a-z0-9._-]/i', '', $file->getClientOriginalName());
                    $path = $file->storeAs('albums', $filename, 'public');
                    if ($path) {
                        $validated['cover_image'] = $path;
                    }
                }
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
                             ->with('success', 'Album created successfully' . ($photoCount > 0 ? ' with ' . $photoCount . ' photos' : '') . '!');
        } catch (\Exception $e) {
            Log::error('Album creation error: ' . $e->getMessage());
            return redirect()->back()
                             ->with('error', 'Error creating album: ' . $e->getMessage())
                             ->withInput();
        }
    }

    public function show(Album $album)
    {
        return view('admin.albums.show', compact('album'));
    }

    public function edit(Album $album)
    {
        $packages = Package::all();
        return view('admin.albums.edit', compact('album', 'packages'));
    }

    public function update(Request $request, Album $album)
    {
        $data = $request->validate([
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
            unset($data['cover_image']);

            if ($request->hasFile('cover_image')) {
                $file = $request->file('cover_image');
                if ($file->isValid()) {
                    if ($album->cover_image && Storage::disk('public')->exists($album->cover_image)) {
                        Storage::disk('public')->delete($album->cover_image);
                    }
                    $filename = time() . '_' . preg_replace('/[^a-z0-9._-]/i', '', $file->getClientOriginalName());
                    $path = $file->storeAs('albums', $filename, 'public');
                    if ($path) {
                        $data['cover_image'] = $path;
                    }
                }
            }

            $data['is_featured'] = $request->has('is_featured');
            $data['is_published'] = $request->has('is_published');

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

                $data['photos_count'] = $photoCount;
            }

            $album->update($data);

            return redirect()->route('admin.albums.index')
                             ->with('success', 'Album updated successfully!');
        } catch (\Exception $e) {
            Log::error('Album update error: ' . $e->getMessage());
            return redirect()->back()
                             ->with('error', 'Error updating album: ' . $e->getMessage())
                             ->withInput();
        }
    }

    public function destroy(Album $album)
    {
        $albumFolder = 'albums/album_' . $album->id;
        if (Storage::disk('public')->exists($albumFolder)) {
            Storage::disk('public')->deleteDirectory($albumFolder);
        }

        if ($album->cover_image && Storage::disk('public')->exists($album->cover_image)) {
            Storage::disk('public')->delete($album->cover_image);
        }

        $album->delete();
        return redirect()->route('admin.albums.index')
                         ->with('success', 'Album deleted successfully!');
    }

    public function toggleFeatured(Album $album)
    {
        $album->update(['is_featured' => !$album->is_featured]);

        $message = $album->is_featured 
            ? 'Album đã được đưa vào Featured!' 
            : 'Album đã bỏ Featured!';

        return redirect()->back()->with('success', $message);
    }
}
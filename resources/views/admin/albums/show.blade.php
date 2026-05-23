@extends('layouts.admin')

@section('title', 'Album: ' . $album->name)
@section('page_title', 'Album: ' . $album->name)

@section('content')
<div style="background: white; border-radius: 8px; padding: 30px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);">
    <div class="row">
        <div class="col-md-8">
            <h5 style="margin-bottom: 20px; font-weight: 600; color: #333;">Chi Tiết Album</h5>
            
            <div style="margin-bottom: 20px;">
                <label style="color: #999; font-size: 12px; text-transform: uppercase; font-weight: 600;">Tên</label>
                <div style="color: #333; font-size: 16px; font-weight: 600;">{{ $album->name }}</div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: #999; font-size: 12px; text-transform: uppercase; font-weight: 600;">Mô Tả</label>
                <p style="color: #333; font-size: 16px;">{{ $album->description ?? 'N/A' }}</p>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: #999; font-size: 12px; text-transform: uppercase; font-weight: 600;">Ý Tưởng</label>
                <div style="color: #333; font-size: 16px;">{{ $album->concept }}</div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: #999; font-size: 12px; text-transform: uppercase; font-weight: 600;">Số Ảnh</label>
                <div style="color: #333; font-size: 16px;">{{ $album->photos_count ?? '0' }}</div>
            </div>

            @if($album->cover_image)
                <div style="margin-bottom: 20px;">
                    <label style="color: #999; font-size: 12px; text-transform: uppercase; font-weight: 600;">Ảnh Bìa</label>
                    <img src="{{ $album->cover_image_url }}" alt="{{ $album->name }}" style="max-width: 100%; max-height: 300px; border-radius: 6px;">
                </div>
            @endif

            <!-- Album Gallery -->
            @php
                $photos = [];
                $albumFolder = storage_path('app/public/albums/album_' . $album->id);
                if (is_dir($albumFolder)) {
                    $files = array_diff(scandir($albumFolder), array('.', '..'));
                    foreach ($files as $file) {
                        if (in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif'])) {
                            $photos[] = 'albums/album_' . $album->id . '/' . $file;
                        }
                    }
                }
            @endphp

            @if(count($photos) > 0)
                <div style="margin-top: 30px;">
                    <h6 style="margin-bottom: 15px; font-weight: 600; color: #333;">Album Photos ({{ count($photos) }})</h6>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 15px;">
                        @foreach($photos as $photo)
                            <div style="border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                <img src="{{ asset('storage/' . $photo) }}" alt="Photo" style="width: 100%; height: 150px; object-fit: cover; display: block;">
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 8px; text-align: center;">
                    <p style="color: #999; margin: 0;">Chưa có ảnh trong album</p>
                </div>
            @endif
        </div>

        <div class="col-md-4">
            <h5 style="margin-bottom: 20px; font-weight: 600; color: #333;">Status</h5>
            
            <div style="background: #f8f9fa; padding: 20px; border-radius: 6px; margin-bottom: 20px;">
                <div style="margin-bottom: 15px;">
                    <label style="color: #999; font-size: 12px; text-transform: uppercase; font-weight: 600;">Featured</label>
                    <div style="color: #333; font-size: 16px;">
                        @if($album->is_featured)
                            <span class="badge" style="background: #28a745; color: white;">Yes</span>
                        @else
                            <span class="badge" style="background: #ccc; color: white;">No</span>
                        @endif
                    </div>
                </div>

                <div>
                    <label style="color: #999; font-size: 12px; text-transform: uppercase; font-weight: 600;">Published</label>
                    <div style="color: #333; font-size: 16px;">
                        @if($album->is_published)
                            <span class="badge" style="background: #17a2b8; color: white;">Yes</span>
                        @else
                            <span class="badge" style="background: #ccc; color: white;">No</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="margin-top: 30px; text-align: right;">
        <a href="{{ route('admin.albums.edit', $album->id) }}" class="btn btn-primary-admin">Sửa</a>
        <a href="{{ route('admin.albums.index') }}" class="btn" style="background: #e9ecef; color: #333; border-radius: 6px; padding: 10px 20px; border: none; cursor: pointer; text-decoration: none;">Quay Lại</a>
    </div>
</div>
@endsection

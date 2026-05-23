<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use App\Models\Consultation;
use App\Models\Review;
use App\Models\Album;
use App\Models\User;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_consultations' => Consultation::count(),
            'pending_consultations' => Consultation::where('status', 'pending')->count(),
            'total_reviews' => Review::count(),
            'featured_reviews' => Review::where('is_featured', true)->count(),
            'total_albums' => Album::count(),
            'featured_albums' => Album::where('is_featured', true)->count(),
        ];

        $recent_consultations = Consultation::latest()->limit(5)->get();
        $recent_reviews = Review::latest()->limit(5)->get();
        $recent_albums = Album::latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_consultations', 'recent_reviews', 'recent_albums'));
    }
}

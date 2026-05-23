<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\AlbumController;

// Import Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\AlbumController as AdminAlbumController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| AUTHENTICATION ROUTES (BẮT BUỘC PHẢI CÓ)
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Login form submission
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| CLIENT SIDE ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews');
Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// Album Routes
Route::get('/albums', [AlbumController::class, 'index'])->name('albums');
Route::get('/albums/{album}', [AlbumController::class, 'show'])->name('albums.show');

// Consultation Routes
Route::get('/booking', [ConsultationController::class, 'index'])->name('booking');
Route::post('/consultation', [ConsultationController::class, 'store'])->name('consultation.store');

// API Routes
// Route::get('/api/booked-dates', [ConsultationController::class, 'getBookedDates'])
//     ->name('api.booked-dates');

// VNPay Routes
Route::get('/vnpay/{id}', [BookingController::class, 'vnpay'])->name('vnpay.payment');
Route::get('/vnpay-return', [BookingController::class, 'vnpayReturn'])->name('vnpay.return');

Route::middleware('auth')->group(function () {
    Route::get('/account', [AuthController::class, 'account'])->name('account');
    Route::post('/consultations/{consultation}/confirm', [ConsultationController::class, 'confirm'])
        ->name('consultations.confirm');
    Route::post('/consultations/{consultation}/cancel', [ConsultationController::class, 'cancel'])
        ->name('consultations.cancel');
});



// ==================== ADMIN ROUTES ====================
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('bookings', AdminBookingController::class);
        Route::resource('reviews',  AdminReviewController::class);
        Route::resource('packages', PackageController::class);
        Route::resource('consultations', \App\Http\Controllers\Admin\ConsultationController::class)
            ->only(['index', 'show', 'destroy']);
        Route::patch('consultations/{consultation}/status',
            [\App\Http\Controllers\Admin\ConsultationController::class, 'updateStatus'])
            ->name('consultations.updateStatus');

        // === ALBUMS ===
        Route::resource('albums', AdminAlbumController::class);

        Route::resource('users', UserController::class)
            ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'])
            ->middleware('admin:admin');

        // Password Change Routes
        Route::get('users/{user}/change-password', [UserController::class, 'changePassword'])
            ->name('users.change-password')
            ->middleware('admin:admin');
        Route::put('users/{user}/update-password', [UserController::class, 'updatePassword'])
            ->name('users.update-password')
            ->middleware('admin:admin');

        // Custom toggle featured
        Route::post('albums/{album}/toggle-featured',
            [AdminAlbumController::class, 'toggleFeatured'])
            ->name('albums.toggle-featured');

        Route::post('reviews/{review}/toggle-featured',
            [\App\Http\Controllers\Admin\ReviewController::class, 'toggleFeatured'])
            ->name('reviews.toggle-featured');

        Route::post('reviews/{review}/toggle-published',
            [\App\Http\Controllers\Admin\ReviewController::class, 'togglePublished'])
            ->name('reviews.toggle-published');

        Route::post('reviews/{review}/approve',
            [\App\Http\Controllers\Admin\ReviewController::class, 'approve'])
            ->name('reviews.approve');

        Route::post('reviews/{review}/reject',
            [\App\Http\Controllers\Admin\ReviewController::class, 'reject'])
            ->name('reviews.reject');

        Route::delete('review-images/{image}',
            [\App\Http\Controllers\Admin\ReviewController::class, 'destroyImage'])
            ->name('review-images.destroy');
    });

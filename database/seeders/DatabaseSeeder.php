<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Package;
use App\Models\Booking;
use App\Models\Album;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'dtd@admin.com',
            'password' => bcrypt('admin1@'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Manager',
            'email' => 'manager@example.com',
            'password' => bcrypt('Password123'),
            'role' => 'manager',
        ]);

        // Create test user
        $testUser = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        // Create packages
        $silver = Package::create([
            'name' => 'Silver',
            'description' => 'Basic Photography Package',
            'price' => 2000000,
            'photos_count' => 100,
            'videos_count' => 0,
            'concepts_count' => 1,
            'features' => ['Basic Editing', 'USB Delivery'],
            'is_active' => true,
        ]);

        $gold = Package::create([
            'name' => 'Gold',
            'description' => 'Premium Photography Package',
            'price' => 5000000,
            'photos_count' => 200,
            'videos_count' => 1,
            'concepts_count' => 2,
            'features' => ['Professional Editing', 'Album', 'USB & Online'],
            'is_active' => true,
        ]);

        $platinum = Package::create([
            'name' => 'Platinum',
            'description' => 'Luxury Photography Package',
            'price' => 10000000,
            'photos_count' => 500,
            'videos_count' => 3,
            'concepts_count' => 5,
            'features' => ['Premium Editing', 'Album', 'Video Highlight', 'USB & Online', 'Print Copies'],
            'is_active' => true,
        ]);

        // Create test bookings
        $booking1 = Booking::create([
            'user_id' => $testUser->id,
            'package_id' => $gold->id,
            'booking_date' => now()->addDays(7),
            'location' => 'Hà Nội',
            'notes' => 'Family portrait session',
            'status' => 'confirmed',
        ]);

        $booking2 = Booking::create([
            'user_id' => $testUser->id,
            'package_id' => $platinum->id,
            'booking_date' => now()->addDays(14),
            'location' => 'Hồ Chí Minh',
            'notes' => 'Wedding photography',
            'status' => 'confirmed',
        ]);

        // Create test albums
        Album::create([
            'booking_id' => $booking1->id,
            'name' => 'Family Portrait 2024',
            'description' => 'Beautiful family portraits taken in spring',
            'concept' => 'Natural & Candid',
            'photos_count' => 45,
            'cover_image' => 'albums/1713370800_family.jpg',
            'is_featured' => true,
            'is_published' => true,
        ]);

        Album::create([
            'booking_id' => $booking2->id,
            'name' => 'Wedding - Tùng & Hoa',
            'description' => 'Complete wedding photography coverage',
            'concept' => 'Traditional & Modern',
            'photos_count' => 200,
            'cover_image' => 'albums/1713370900_wedding.jpg',
            'is_featured' => true,
            'is_published' => true,
        ]);

        Album::create([
            'booking_id' => $booking1->id,
            'name' => 'Kids Fun Session',
            'description' => 'Playful moments with the kids',
            'concept' => 'Fun & Playful',
            'photos_count' => 30,
            'cover_image' => 'albums/1713371000_kids.jpg',
            'is_featured' => false,
            'is_published' => true,
        ]);
    }
}

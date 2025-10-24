<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\TourPackage;
use App\Models\Cart;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin TourTravels',
            'email' => 'admin@tourtravels.com',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'address' => 'Jakarta, Indonesia',
            'role' => 'admin',
        ]);

        // Create Customer User
        $customer = User::create([
            'name' => 'John Customer',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'phone' => '081234567891',
            'address' => 'Bandung, Indonesia',
            'role' => 'customer',
        ]);

        // Create cart for customer
        Cart::create(['user_id' => $customer->id]);

        // Create Sample Tour Packages
        TourPackage::create([
            'title' => 'Wisata Bali 3 Hari 2 Malam',
            'description' => 'Nikmati keindahan pulau dewata dengan paket lengkap mengunjungi tempat-tempat wisata terkenal di Bali.',
            'location' => 'Bali',
            'duration' => '3 Hari 2 Malam',
            'price' => 2500000,
            'available_seats' => 20,
            'start_date' => '2024-03-01',
            'end_date' => '2024-03-03',
            'status' => 'available',
        ]);

        TourPackage::create([
            'title' => 'Tour Lombok 4 Hari 3 Malam',
            'description' => 'Jelajahi keindahan alam Lombok dengan pantai-pantai eksotis dan gunung Rinjani yang menakjubkan.',
            'location' => 'Lombok',
            'duration' => '4 Hari 3 Malam',
            'price' => 3200000,
            'available_seats' => 15,
            'start_date' => '2024-03-05',
            'end_date' => '2024-03-08',
            'status' => 'available',
        ]);

        TourPackage::create([
            'title' => 'Yogyakarta Heritage Tour',
            'description' => 'Mengenal warisan budaya Jawa dengan mengunjungi Candi Borobudur, Prambanan, dan Keraton Yogyakarta.',
            'location' => 'Yogyakarta',
            'duration' => '2 Hari 1 Malam',
            'price' => 1500000,
            'available_seats' => 25,
            'start_date' => '2024-02-20',
            'end_date' => '2024-02-21',
            'status' => 'available',
        ]);

        $this->command->info('Sample data created successfully!');
        $this->command->info('Admin Login: admin@tourtravels.com / password');
        $this->command->info('Customer Login: customer@example.com / password');
    }
}
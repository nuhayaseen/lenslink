<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\PhotographerProfile;
use App\Models\Portfolio;
use App\Models\PhotographerPackage;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Review;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    public function run(): void {

        // Admin
        User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@lenslink.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
            'phone'    => '0771234567',
            'is_active'=> true,
        ]);

        // Photographers
        $photographersData = [
            [
                'name'  => 'Amara Silva',
                'email' => 'amara@lenslink.com',
                'bio'   => 'Professional wedding and portrait photographer with 8 years of experience.',
                'location' => 'Kandy',
                'specialization' => 'Wedding',
                'price_per_hour' => 8000,
                'years_of_experience' => 8,
            ],
            [
                'name'  => 'Rajan Perera',
                'email' => 'rajan@lenslink.com',
                'bio'   => 'Corporate and event photographer based in Colombo.',
                'location' => 'Colombo',
                'specialization' => 'Corporate',
                'price_per_hour' => 12000,
                'years_of_experience' => 5,
            ],
            [
                'name'  => 'Nisha Fernando',
                'email' => 'nisha@lenslink.com',
                'bio'   => 'Fashion and baby photographer with an eye for detail.',
                'location' => 'Galle',
                'specialization' => 'Fashion',
                'price_per_hour' => 6500,
                'years_of_experience' => 3,
            ],
        ];

        $photographers = [];
        foreach ($photographersData as $data) {
            $user = User::create([
                'name'      => $data['name'],
                'email'     => $data['email'],
                'password'  => Hash::make('password123'),
                'role'      => 'photographer',
                'is_active' => true,
            ]);

            $profile = PhotographerProfile::create([
                'user_id'              => $user->id,
                'bio'                  => $data['bio'],
                'location'             => $data['location'],
                'specialization'       => $data['specialization'],
                'price_per_hour'       => $data['price_per_hour'],
                'years_of_experience'  => $data['years_of_experience'],
                'is_available'         => true,
            ]);

            $portfolio = Portfolio::create([
                'photographer_profile_id' => $profile->id,
                'title'                   => $data['name'] . "'s Portfolio",
                'description'             => 'A collection of my best work.',
            ]);

            // Packages
            PhotographerPackage::create([
                'photographer_profile_id' => $profile->id,
                'name'           => 'Basic',
                'description'    => 'Perfect for small events.',
                'price'          => $data['price_per_hour'] * 2,
                'duration_hours' => 2,
                'edited_photos'  => 20,
                'includes_raw'   => false,
                'includes_album' => false,
                'includes_video' => false,
                'is_active'      => true,
            ]);
            PhotographerPackage::create([
                'photographer_profile_id' => $profile->id,
                'name'           => 'Standard',
                'description'    => 'Great for weddings and parties.',
                'price'          => $data['price_per_hour'] * 5,
                'duration_hours' => 5,
                'edited_photos'  => 60,
                'includes_raw'   => false,
                'includes_album' => true,
                'includes_video' => false,
                'is_active'      => true,
            ]);
            PhotographerPackage::create([
                'photographer_profile_id' => $profile->id,
                'name'           => 'Premium',
                'description'    => 'Full day coverage with all extras.',
                'price'          => $data['price_per_hour'] * 10,
                'duration_hours' => 10,
                'edited_photos'  => 150,
                'includes_raw'   => true,
                'includes_album' => true,
                'includes_video' => true,
                'is_active'      => true,
            ]);

            $photographers[] = ['user' => $user, 'profile' => $profile];
        }

        // Clients
        $client1 = User::create([
            'name'      => 'Kamal Dissanayake',
            'email'     => 'kamal@lenslink.com',
            'password'  => Hash::make('password123'),
            'role'      => 'client',
            'is_active' => true,
        ]);
        $client2 = User::create([
            'name'      => 'Priya Jayawardena',
            'email'     => 'priya@lenslink.com',
            'password'  => Hash::make('password123'),
            'role'      => 'client',
            'is_active' => true,
        ]);

        // Sample bookings
        $b1 = Booking::create([
            'client_id'       => $client1->id,
            'photographer_id' => $photographers[0]['user']->id,
            'event_type'      => 'Wedding',
            'event_date'      => now()->addDays(30),
            'event_location'  => 'Kandy Lake Club',
            'duration_hours'  => 8,
            'budget'          => 64000,
            'guest_count'     => 150,
            'status'          => 'pending',
        ]);

        $b2 = Booking::create([
            'client_id'       => $client2->id,
            'photographer_id' => $photographers[1]['user']->id,
            'event_type'      => 'Corporate Event',
            'event_date'      => now()->addDays(15),
            'event_location'  => 'Colombo Hilton',
            'duration_hours'  => 4,
            'budget'          => 48000,
            'guest_count'     => 80,
            'status'          => 'accepted',
        ]);

        Payment::create([
            'booking_id'     => $b2->id,
            'amount'         => 48000,
            'payment_status' => 'pending',
        ]);

        $b3 = Booking::create([
            'client_id'       => $client1->id,
            'photographer_id' => $photographers[2]['user']->id,
            'event_type'      => 'Birthday Party',
            'event_date'      => now()->subDays(10),
            'event_location'  => 'Galle Fort',
            'duration_hours'  => 3,
            'budget'          => 19500,
            'guest_count'     => 40,
            'status'          => 'completed',
        ]);

        Payment::create([
            'booking_id'     => $b3->id,
            'amount'         => 19500,
            'payment_status' => 'paid',
        ]);

        Review::create([
            'booking_id'      => $b3->id,
            'client_id'       => $client1->id,
            'photographer_id' => $photographers[2]['user']->id,
            'rating'          => 5,
            'comment'         => 'Amazing photos! Nisha was very professional and friendly.',
        ]);
    }
}
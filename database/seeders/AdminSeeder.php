<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = 'admin@lenslink.com';

        // Include soft-deleted users so a deleted admin can be restored
        $user = User::withTrashed()->where('email', $email)->first();

        if ($user) {
            if ($user->trashed()) {
                $user->restore();
            }

            $user->update([
                'name'      => 'Admin User',
                'password'  => 'admin123',   // hashed automatically by the User model
                'role'      => 'admin',
                'is_active' => true,
            ]);

            $this->command->info('Admin account updated.');
        } else {
            User::create([
                'name'      => 'Admin User',
                'email'     => $email,
                'password'  => 'admin123',
                'role'      => 'admin',
                'phone'     => '0771234567',
                'is_active' => true,
            ]);

            $this->command->info('Admin account created.');
        }
    }
}
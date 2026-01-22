<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete existing test users to allow re-seeding
        $testEmails = [
            'admin@alpine.test',
            'superadmin@alpine.test',
            'ahmed.vendor@alpine.test',
            'fatima.vendor@alpine.test',
            'hassan.vendor@alpine.test',
            'ali.member@alpine.test',
            'zara.member@alpine.test',
            'bilal.member@alpine.test',
            'aisha.member@alpine.test',
            'samir.member@alpine.test',
            'kareem.suspended@alpine.test'
        ];
        User::whereIn('email', $testEmails)->forceDelete();

        // Create Admin Users (2)
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@alpine.test',
            'phone' => '03011234567',
            'password' => Hash::make('password123'),
            'is_admin' => true,
            'membership_tier' => 'premium',
            'membership_status' => 'active',
            'email_verified_at' => now(),
        ]);

        User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'superadmin@alpine.test',
            'phone' => '03019876543',
            'password' => Hash::make('password123'),
            'is_admin' => true,
            'membership_tier' => 'premium',
            'membership_status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Create Vendor Users (3)
        $vendor1 = User::create([
            'first_name' => 'Ahmed',
            'last_name' => 'Equipment',
            'email' => 'ahmed.vendor@alpine.test',
            'phone' => '03021551234',
            'password' => Hash::make('password123'),
            'membership_tier' => 'standard',
            'membership_status' => 'active',
            'email_verified_at' => now(),
        ]);

        $vendor2 = User::create([
            'first_name' => 'Fatima',
            'last_name' => 'Tours',
            'email' => 'fatima.vendor@alpine.test',
            'phone' => '03022555678',
            'password' => Hash::make('password123'),
            'membership_tier' => 'premium',
            'membership_status' => 'active',
            'email_verified_at' => now(),
        ]);

        $vendor3 = User::create([
            'first_name' => 'Hassan',
            'last_name' => 'Guides',
            'email' => 'hassan.vendor@alpine.test',
            'phone' => '03023559999',
            'password' => Hash::make('password123'),
            'membership_tier' => 'standard',
            'membership_status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Create Admin users first to get IDs
        $admin = User::where('email', 'admin@alpine.test')->first();
        $adminId = $admin?->id ?? 1;

        // Create Vendor Records linked to users
        Vendor::create([
            'vendor_user_id' => $vendor1->id,
            'business_name' => 'Ahmed\'s Equipment Store',
            'contact_person' => 'Ahmed Khan',
            'email' => 'ahmed.vendor@alpine.test',
            'phone' => '03021551234',
            'address' => 'Islamabad, Pakistan',
            'business_type' => 'equipment',
            'description' => 'High quality climbing equipment and gear',
            'is_certified' => true,
            'can_sell' => true,
            'status' => 'verified',
            'verified_by' => $adminId,
            'verified_at' => now(),
            'rating' => 4.8,
            'total_bookings' => 45,
        ]);

        Vendor::create([
            'vendor_user_id' => $vendor2->id,
            'business_name' => 'Fatima\'s Mountain Tours',
            'contact_person' => 'Fatima Hassan',
            'email' => 'fatima.vendor@alpine.test',
            'phone' => '03022555678',
            'address' => 'Gilgit, Pakistan',
            'business_type' => 'guide',
            'description' => 'Professional guided climbing tours and expeditions',
            'is_certified' => true,
            'can_sell' => true,
            'status' => 'verified',
            'verified_by' => $adminId,
            'verified_at' => now(),
            'rating' => 5.0,
            'total_bookings' => 78,
        ]);

        Vendor::create([
            'vendor_user_id' => $vendor3->id,
            'business_name' => 'Hassan\'s Guide Services',
            'contact_person' => 'Hassan Ahmed',
            'email' => 'hassan.vendor@alpine.test',
            'phone' => '03023559999',
            'address' => 'Hunza, Pakistan',
            'business_type' => 'guide',
            'description' => 'Expert mountain guides and training',
            'is_certified' => true,
            'can_sell' => true,
            'status' => 'verified',
            'verified_by' => $adminId,
            'verified_at' => now(),
            'rating' => 4.9,
            'total_bookings' => 62,
        ]);

        // Create Member Users (6)
        User::create([
            'first_name' => 'Ali',
            'last_name' => 'Khan',
            'email' => 'ali.member@alpine.test',
            'phone' => '03031771111',
            'password' => Hash::make('password123'),
            'membership_tier' => 'standard',
            'membership_status' => 'active',
            'email_verified_at' => now(),
        ]);

        User::create([
            'first_name' => 'Zara',
            'last_name' => 'Malik',
            'email' => 'zara.member@alpine.test',
            'phone' => '03032772222',
            'password' => Hash::make('password123'),
            'membership_tier' => 'premium',
            'membership_status' => 'active',
            'email_verified_at' => now(),
        ]);

        User::create([
            'first_name' => 'Bilal',
            'last_name' => 'Ahmed',
            'email' => 'bilal.member@alpine.test',
            'phone' => '03033773333',
            'password' => Hash::make('password123'),
            'membership_tier' => 'standard',
            'membership_status' => 'active',
            'email_verified_at' => now(),
        ]);

        User::create([
            'first_name' => 'Aisha',
            'last_name' => 'Hassan',
            'email' => 'aisha.member@alpine.test',
            'phone' => '03034774444',
            'password' => Hash::make('password123'),
            'membership_tier' => 'standard',
            'membership_status' => 'active',
            'email_verified_at' => now(),
        ]);

        User::create([
            'first_name' => 'Samir',
            'last_name' => 'Raza',
            'email' => 'samir.member@alpine.test',
            'phone' => '03035775555',
            'password' => Hash::make('password123'),
            'membership_tier' => 'premium',
            'membership_status' => 'expired', // Expired
            'email_verified_at' => now(),
        ]);

        // Create Suspended Member
        User::create([
            'first_name' => 'Kareem',
            'last_name' => 'Suspended',
            'email' => 'kareem.suspended@alpine.test',
            'phone' => '03036776666',
            'password' => Hash::make('password123'),
            'membership_tier' => 'standard',
            'membership_status' => 'suspended',
            'email_verified_at' => now(),
        ]);

        $this->command->info('Test users seeded successfully!');
        $this->command->newLine();

        // Display test credentials
        $this->command->table(
            ['Role', 'Email', 'Password', 'Status'],
            [
                ['Admin', 'admin@alpine.test', 'password123', 'Active'],
                ['Admin', 'superadmin@alpine.test', 'password123', 'Active'],
                ['Vendor', 'ahmed.vendor@alpine.test', 'password123', 'Active'],
                ['Vendor', 'fatima.vendor@alpine.test', 'password123', 'Active'],
                ['Vendor', 'hassan.vendor@alpine.test', 'password123', 'Active'],
                ['Member', 'ali.member@alpine.test', 'password123', 'Active'],
                ['Member', 'zara.member@alpine.test', 'password123', 'Active'],
                ['Member', 'bilal.member@alpine.test', 'password123', 'Active'],
                ['Member', 'aisha.member@alpine.test', 'password123', 'Pending Payment'],
                ['Member', 'samir.member@alpine.test', 'password123', 'Expired'],
                ['Member', 'kareem.suspended@alpine.test', 'password123', 'Suspended'],
            ]
        );

        $this->command->newLine();
        $this->command->info('✓ 2 Admin users created');
        $this->command->info('✓ 3 Vendor users created with verified vendor records');
        $this->command->info('✓ 6 Member users created (various statuses)');
        $this->command->newLine();
        $this->command->warn('Note: Password for all test users is "password123"');
    }
}

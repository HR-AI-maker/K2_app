<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\MembershipTier;
use App\Models\Payment;
use App\Models\MembershipTransaction;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Skip if test users already exist
        if (User::where('email', 'admin@alpine.test')->exists()) {
            $this->command->info('Test users already exist. Skipping seeder.');
            return;
        }

        // Get membership tiers
        $proTier = MembershipTier::where('name', 'Pro')->first();
        $ultimateTier = MembershipTier::where('name', 'Ultimate')->first();

        // Create Admin Users (2)
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@alpine.test',
            'phone' => '03011234567',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'membership_tier' => 'premium',
            'membership_status' => 'active',
            'membership_expires_at' => now()->addYear(),
            'phone_verified_at' => now(),
            'email_verified_at' => now(),
        ]);

        User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'superadmin@alpine.test',
            'phone' => '03019876543',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'membership_tier' => 'premium',
            'membership_status' => 'active',
            'membership_expires_at' => now()->addYear(),
            'phone_verified_at' => now(),
            'email_verified_at' => now(),
        ]);

        // Create Vendor Users (3)
        $vendor1 = User::create([
            'first_name' => 'Ahmed',
            'last_name' => 'Equipment',
            'email' => 'ahmed.vendor@alpine.test',
            'phone' => '03021551234',
            'password' => Hash::make('password123'),
            'role' => 'vendor',
            'membership_tier' => 'standard',
            'membership_status' => 'active',
            'membership_expires_at' => now()->addMonth(),
            'phone_verified_at' => now(),
            'email_verified_at' => now(),
        ]);

        $vendor2 = User::create([
            'first_name' => 'Fatima',
            'last_name' => 'Tours',
            'email' => 'fatima.vendor@alpine.test',
            'phone' => '03022555678',
            'password' => Hash::make('password123'),
            'role' => 'vendor',
            'membership_tier' => 'premium',
            'membership_status' => 'active',
            'membership_expires_at' => now()->addMonth(),
            'phone_verified_at' => now(),
            'email_verified_at' => now(),
        ]);

        $vendor3 = User::create([
            'first_name' => 'Hassan',
            'last_name' => 'Guides',
            'email' => 'hassan.vendor@alpine.test',
            'phone' => '03023559999',
            'password' => Hash::make('password123'),
            'role' => 'vendor',
            'membership_tier' => 'standard',
            'membership_status' => 'active',
            'membership_expires_at' => now()->addMonth(),
            'phone_verified_at' => now(),
            'email_verified_at' => now(),
        ]);

        // Create Member Users (6)
        User::create([
            'first_name' => 'Ali',
            'last_name' => 'Khan',
            'email' => 'ali.member@alpine.test',
            'phone' => '03031771111',
            'password' => Hash::make('password123'),
            'role' => 'member',
            'membership_tier' => 'standard',
            'membership_status' => 'active',
            'membership_expires_at' => now()->addMonth(),
            'phone_verified_at' => now(),
            'email_verified_at' => now(),
        ]);

        User::create([
            'first_name' => 'Zara',
            'last_name' => 'Malik',
            'email' => 'zara.member@alpine.test',
            'phone' => '03032772222',
            'password' => Hash::make('password123'),
            'role' => 'member',
            'membership_tier' => 'premium',
            'membership_status' => 'active',
            'membership_expires_at' => now()->addMonth(),
            'phone_verified_at' => now(),
            'email_verified_at' => now(),
        ]);

        User::create([
            'first_name' => 'Bilal',
            'last_name' => 'Ahmed',
            'email' => 'bilal.member@alpine.test',
            'phone' => '03033773333',
            'password' => Hash::make('password123'),
            'role' => 'member',
            'membership_tier' => 'standard',
            'membership_status' => 'active',
            'membership_expires_at' => now()->addMonth(),
            'phone_verified_at' => now(),
            'email_verified_at' => now(),
        ]);

        User::create([
            'first_name' => 'Aisha',
            'last_name' => 'Hassan',
            'email' => 'aisha.member@alpine.test',
            'phone' => '03034774444',
            'password' => Hash::make('password123'),
            'role' => 'member',
            'membership_tier' => 'standard',
            'membership_status' => 'active',
            'membership_expires_at' => now()->addMonth(),
            'phone_verified_at' => now(),
            'email_verified_at' => now(),
        ]);

        User::create([
            'first_name' => 'Samir',
            'last_name' => 'Raza',
            'email' => 'samir.member@alpine.test',
            'phone' => '03035775555',
            'password' => Hash::make('password123'),
            'role' => 'member',
            'membership_tier' => 'premium',
            'membership_status' => 'active',
            'membership_expires_at' => now()->subDays(5), // Expired
            'phone_verified_at' => now(),
            'email_verified_at' => now(),
        ]);

        // Create Suspended Member
        User::create([
            'first_name' => 'Kareem',
            'last_name' => 'Suspended',
            'email' => 'kareem.suspended@alpine.test',
            'phone' => '03036776666',
            'password' => Hash::make('password123'),
            'role' => 'member',
            'membership_tier' => 'standard',
            'membership_status' => 'suspended',
            'membership_expires_at' => now()->addMonth(),
            'phone_verified_at' => now(),
            'email_verified_at' => now(),
        ]);

        // Create Payment records for members
        Payment::create([
            'user_id' => User::where('email', 'ali.member@alpine.test')->first()->id,
            'amount' => 1000,
            'payment_method' => 'card',
            'payment_status' => 'completed',
            'verification_status' => 'verified',
            'payment_verified_at' => now(),
            'verified_by' => User::where('email', 'admin@alpine.test')->first()->id,
            'transaction_reference' => 'HBL-TEST-001',
        ]);

        Payment::create([
            'user_id' => User::where('email', 'zara.member@alpine.test')->first()->id,
            'amount' => 2000,
            'payment_method' => 'card',
            'payment_status' => 'completed',
            'verification_status' => 'verified',
            'payment_verified_at' => now(),
            'verified_by' => User::where('email', 'admin@alpine.test')->first()->id,
            'transaction_reference' => 'HBL-TEST-002',
        ]);

        // Create Membership Transaction records
        $proTierId = $proTier?->id ?? 1;
        $ultimateTierId = $ultimateTier?->id ?? 2;

        MembershipTransaction::create([
            'user_id' => User::where('email', 'ali.member@alpine.test')->first()->id,
            'payment_id' => Payment::where('transaction_reference', 'HBL-TEST-001')->first()->id,
            'membership_tier_id' => $proTierId,
            'transaction_type' => 'new_membership',
            'amount' => 1000,
            'starts_at' => now()->subDays(5),
            'expires_at' => now()->addMonth(),
            'is_active' => true,
        ]);

        MembershipTransaction::create([
            'user_id' => User::where('email', 'zara.member@alpine.test')->first()->id,
            'payment_id' => Payment::where('transaction_reference', 'HBL-TEST-002')->first()->id,
            'membership_tier_id' => $ultimateTierId,
            'transaction_type' => 'new_membership',
            'amount' => 2000,
            'starts_at' => now()->subDays(5),
            'expires_at' => now()->addMonth(),
            'is_active' => true,
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
        $this->command->info('✓ 3 Vendor users created');
        $this->command->info('✓ 6 Member users created (various statuses)');
        $this->command->info('✓ Payment and transaction records created');
        $this->command->newLine();
        $this->command->warn('Note: Password for all test users is "password123"');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembershipTiersSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('membership_tiers')->delete();

        DB::table('membership_tiers')->insert([
            [
                'name' => 'Basic',
                'price' => 1000.00,
                'billing_cycle' => 'monthly',
                'features' => json_encode([
                    'Community Access',
                    'Marketplace Access',
                    'Event Discounts (5%)',
                ]),
                'description' => 'Perfect for beginners',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Premium',
                'price' => 2500.00,
                'billing_cycle' => 'monthly',
                'features' => json_encode([
                    'Everything in Basic',
                    'GPS & Offline Maps',
                    'SOS Emergency System',
                    'Event Discounts (15%)',
                ]),
                'description' => 'For serious adventurers',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Elite',
                'price' => 5000.00,
                'billing_cycle' => 'monthly',
                'features' => json_encode([
                    'Everything in Premium',
                    'Priority Support 24/7',
                    'Exclusive Content',
                    'Free Gear Rental',
                ]),
                'description' => 'For expedition leaders',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

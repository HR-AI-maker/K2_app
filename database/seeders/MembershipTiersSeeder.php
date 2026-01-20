<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembershipTiersSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('membership_tiers')->insertOrIgnore([
            [
                'name' => 'Pro',
                'price' => 1000.00,
                'billing_cycle' => 'monthly',
                'features' => json_encode([
                    'community_access' => true,
                    'marketplace_access' => true,
                    'events_discount' => '10%',
                    'gps_tracking' => true,
                    'offline_maps' => true,
                    'sos_system' => true,
                    'max_events' => 5,
                ]),
                'description' => 'Perfect for climbers who want to explore and connect',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ultimate',
                'price' => 2000.00,
                'billing_cycle' => 'monthly',
                'features' => json_encode([
                    'community_access' => true,
                    'marketplace_access' => true,
                    'events_discount' => '25%',
                    'gps_tracking' => true,
                    'offline_maps' => true,
                    'sos_system' => true,
                    'priority_support' => true,
                    'max_events' => 'unlimited',
                    'exclusive_content' => true,
                    'gear_rental_discount' => '20%',
                ]),
                'description' => 'For serious climbers who want premium benefits',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

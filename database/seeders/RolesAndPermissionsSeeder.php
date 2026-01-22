<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Create Roles
        $roles = [
            ['name' => 'admin', 'display_name' => 'Administrator'],
            ['name' => 'vendor', 'display_name' => 'Vendor'],
            ['name' => 'member', 'display_name' => 'Member'],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insertOrIgnore([
                'name' => $role['name'],
                'display_name' => $role['display_name'],
                'description' => ucfirst($role['name']) . ' role for Alpine platform',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create Permissions
        $permissions = [
            // User Management
            ['name' => 'view-users', 'display_name' => 'View Users'],
            ['name' => 'create-users', 'display_name' => 'Create Users'],
            ['name' => 'edit-users', 'display_name' => 'Edit Users'],
            ['name' => 'delete-users', 'display_name' => 'Delete Users'],
            ['name' => 'manage-roles', 'display_name' => 'Manage Roles'],

            // Membership Management
            ['name' => 'view-memberships', 'display_name' => 'View Memberships'],
            ['name' => 'manage-membership-tiers', 'display_name' => 'Manage Membership Tiers'],
            ['name' => 'verify-payments', 'display_name' => 'Verify Payments'],

            // Vendor Management
            ['name' => 'approve-vendors', 'display_name' => 'Approve Vendors'],
            ['name' => 'manage-vendors', 'display_name' => 'Manage Vendors'],

            // Product Management
            ['name' => 'approve-products', 'display_name' => 'Approve Products'],
            ['name' => 'manage-products', 'display_name' => 'Manage Products'],

            // Content Management
            ['name' => 'manage-events', 'display_name' => 'Manage Events'],
            ['name' => 'manage-expeditions', 'display_name' => 'Manage Expeditions'],
            ['name' => 'moderate-community', 'display_name' => 'Moderate Community'],
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->insertOrIgnore([
                'name' => $permission['name'],
                'display_name' => $permission['display_name'],
                'description' => $permission['display_name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Assign permissions to Admin role
        $adminRole = DB::table('roles')->where('name', 'admin')->first();
        $allPermissions = DB::table('permissions')->pluck('id');

        foreach ($allPermissions as $permissionId) {
            DB::table('role_permissions')->insertOrIgnore([
                'role_id' => $adminRole->id,
                'permission_id' => $permissionId,
            ]);
        }

        // Assign permissions to Vendor role
        $vendorRole = DB::table('roles')->where('name', 'vendor')->first();
        $vendorPermissions = DB::table('permissions')
            ->whereIn('name', ['manage-products', 'view-users'])
            ->pluck('id');

        foreach ($vendorPermissions as $permissionId) {
            DB::table('role_permissions')->insertOrIgnore([
                'role_id' => $vendorRole->id,
                'permission_id' => $permissionId,
            ]);
        }

        // Assign permissions to Member role (view only)
        $memberRole = DB::table('roles')->where('name', 'member')->first();
        $memberPermissions = DB::table('permissions')
            ->whereIn('name', ['view-users', 'view-memberships'])
            ->pluck('id');

        foreach ($memberPermissions as $permissionId) {
            DB::table('role_permissions')->insertOrIgnore([
                'role_id' => $memberRole->id,
                'permission_id' => $permissionId,
            ]);
        }
    }
}

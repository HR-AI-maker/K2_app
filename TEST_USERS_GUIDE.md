# Test Users Guide

## Overview

The `TestUsersSeeder` creates a complete set of test users with different roles and membership statuses for development and testing purposes.

---

## Running the Seeder

### Option 1: Run Single Seeder
```bash
php artisan db:seed --class=TestUsersSeeder
```

### Option 2: Run with All Seeders
```bash
php artisan db:seed
```

### Option 3: Fresh Database with Test Users
```bash
php artisan migrate:fresh --seed --seeder=TestUsersSeeder
```

---

## Test User Accounts

### Admin Users (2)

| Email | Password | Status | Tier | Notes |
|-------|----------|--------|------|-------|
| `admin@alpine.test` | `password123` | Active | Ultimate | Main admin account |
| `superadmin@alpine.test` | `password123` | Active | Ultimate | Secondary admin |

**Access:** `/admin/user-management` (when logged in as admin)

---

### Vendor Users (3)

| Email | Password | Status | Tier | Business |
|-------|----------|--------|------|----------|
| `ahmed.vendor@alpine.test` | `password123` | Active | Pro | Equipment Sales |
| `fatima.vendor@alpine.test` | `password123` | Active | Ultimate | Tour Operations |
| `hassan.vendor@alpine.test` | `password123` | Active | Pro | Guide Services |

**Access:** `/vendor/dashboard` (when logged in as vendor)

---

### Member Users (6)

#### Active Members

| Email | Password | Status | Tier | Notes |
|-------|----------|--------|------|-------|
| `ali.member@alpine.test` | `password123` | Active | Pro | Standard member with payment verified |
| `zara.member@alpine.test` | `password123` | Active | Ultimate | Premium member with payment verified |
| `bilal.member@alpine.test` | `password123` | Active | Pro | Regular active member |

#### Special Status Members

| Email | Password | Status | Tier | Notes |
|-------|----------|--------|------|-------|
| `aisha.member@alpine.test` | `password123` | Pending Payment | Pro | Hasn't paid yet |
| `samir.member@alpine.test` | `password123` | Expired | Ultimate | Membership expired 5 days ago |
| `kareem.suspended@alpine.test` | `password123` | Suspended | Pro | Account suspended |

**Access:** `/dashboard` (when logged in as member)

---

## Test Scenarios

### Scenario 1: Admin User Management
**Login as:** `admin@alpine.test`
**Actions:**
1. Go to `/admin/user-management`
2. View all users
3. Create new user
4. Edit user information
5. Reset password
6. Manage membership
7. Suspend/reactivate user
8. Export CSV

---

### Scenario 2: Vendor Dashboard
**Login as:** `ahmed.vendor@alpine.test`
**Actions:**
1. Access vendor dashboard (`/vendor/dashboard`)
2. View product management
3. See vendor orders
4. Check sales statistics

---

### Scenario 3: Member Features
**Login as:** `ali.member@alpine.test`
**Actions:**
1. Access dashboard
2. Browse marketplace (`/marketplace`)
3. View events
4. Participate in community
5. Check membership details

---

### Scenario 4: Testing Membership Statuses

#### Active Membership
- Login as `ali.member@alpine.test`
- Expected: Full access to all features
- Membership expires: ~30 days from today

#### Pending Payment
- Login as `aisha.member@alpine.test`
- Expected: Limited access until payment
- Status: `pending_payment`

#### Expired Membership
- Login as `samir.member@alpine.test`
- Expected: Prompt to renew
- Status: `expired`
- Expired: 5 days ago

#### Suspended Account
- Try to login as `kareem.suspended@alpine.test`
- Expected: Login should fail or show suspended message
- Status: `suspended`

---

## Database Relationships Created

The seeder also creates:

### Payment Records
- 2 verified payments (Ali and Zara)
- Associated transaction references
- Verified by admin user

### Membership Transactions
- 2 transaction records
- Pro and Ultimate tier assignments
- Start and expiry dates

---

## Test User Data Summary

```
Total Users Created: 11
├── Admin: 2
├── Vendor: 3
└── Member: 6
    ├── Active: 3
    ├── Pending Payment: 1
    ├── Expired: 1
    └── Suspended: 1

Payment Records: 2
Membership Transactions: 2
```

---

## Common Password

All test users share the same password for easy testing:
```
password123
```

> **Note:** This is for testing only. In production, use strong individual passwords.

---

## Use Cases

### 1. Admin Testing
- Create/edit/delete users
- Manage roles and permissions
- Reset passwords
- Verify payments
- Manage vendors
- View statistics

**Test Users:** `admin@alpine.test`, `superadmin@alpine.test`

### 2. Vendor Testing
- Product management
- Order processing
- Sales dashboard
- Inventory management

**Test Users:** `ahmed.vendor@alpine.test`, `fatima.vendor@alpine.test`, `hassan.vendor@alpine.test`

### 3. Member Testing
- Marketplace browsing
- Event registration
- Community participation
- Profile management
- Membership renewal

**Test Users:** `ali.member@alpine.test`, `zara.member@alpine.test`, `bilal.member@alpine.test`

### 4. Edge Case Testing
- Pending payment workflow
- Expired membership handling
- Account suspension
- Payment verification process

**Test Users:** `aisha.member@alpine.test`, `samir.member@alpine.test`, `kareem.suspended@alpine.test`

---

## Resetting Test Data

To reset test data and recreate:

```bash
# Option 1: Fresh migration with seeder
php artisan migrate:fresh --seed --seeder=TestUsersSeeder

# Option 2: Wipe users table and reseed
php artisan db:wipe
php artisan migrate
php artisan db:seed --class=RolesAndPermissionsSeeder
php artisan db:seed --class=MembershipTiersSeeder
php artisan db:seed --class=TestUsersSeeder
```

---

## Troubleshooting

### Issue: Email already exists
**Cause:** Seeder was run multiple times
**Solution:** Run `php artisan migrate:fresh --seed` to reset

### Issue: Membership tier not found
**Cause:** MembershipTiersSeeder wasn't run
**Solution:** Run seeders in order:
1. RolesAndPermissionsSeeder
2. MembershipTiersSeeder
3. TestUsersSeeder

### Issue: Can't login
**Cause:** User might be suspended or wrong password
**Solution:**
- Verify email is correct
- Password is always `password123` for test users
- Check membership status

---

## Quick Login Reference

Copy and paste for quick testing:

```
Admin: admin@alpine.test / password123
Vendor: ahmed.vendor@alpine.test / password123
Member: ali.member@alpine.test / password123
```

---

## Notes for Developers

- All test users have `phone_verified_at` and `email_verified_at` set to now
- Membership expiry dates are set to 1 month from seeding date
- Payment records include transaction references (HBL-TEST-001, HBL-TEST-002)
- Member names follow pattern: FirstName + Role/Status
- Vendors have realistic business names
- Members have realistic Pakistani names

---

**Version:** 1.0
**Created:** January 21, 2025
**Status:** Ready for Testing

For more information, see:
- `ADMIN_USER_MANAGEMENT_GUIDE.md` - Admin features
- `MEMBER_ONBOARDING_GUIDE.md` - Member registration
- `IMPLEMENTATION_SUMMARY.md` - System overview

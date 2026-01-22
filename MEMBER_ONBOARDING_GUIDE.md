# Member Onboarding System - Complete Guide

## Overview

The Alpine platform now includes a comprehensive member onboarding system with:
- Email-based OTP verification
- Membership tier selection (Pro/Ultimate)
- HBL dummy credit card payment gateway
- Automatic account creation and activation
- Payment tracking and membership transaction logging

---

## Member Registration Flow

### Step 1: Initial Registration Form
**URL:** `/member/register`
**Route Name:** `member.register`

Users provide:
- First Name
- Last Name
- Email (must be unique)
- Phone Number (must be unique)
- Password (minimum 8 characters)
- Confirm Password

**What Happens:**
- Input validation (email/phone uniqueness check)
- OTP code generated (6 digits)
- OTP stored in database with 10-minute expiry
- OTP sent to user's email
- Registration data stored in session
- User redirected to OTP verification page

---

### Step 2: Email OTP Verification
**URL:** `/member/verify-otp`
**Route Name:** `member.verify-otp`

Users enter:
- 6-digit OTP code received in email

**What Happens:**
- OTP validated against database
- OTP expiry checked (10-minute window)
- OTP marked as verified in database
- OTP verified flag stored in session
- User redirected to membership tier selection

---

### Step 3: Membership Tier Selection
**URL:** `/member/select-tier`
**Route Name:** `member.select-tier`

Users select:
- Pro (Rs. 1,000/month) OR Ultimate (Rs. 2,000/month)

**What Happens:**
- Tier validation against database
- Tier details stored in session
- User redirected to payment form

---

### Step 4: Payment Processing
**URL:** `/member/payment`
**Route Name:** `member.payment`

Users enter:
- Card Number (16 digits)
- Card Holder Name
- Expiry Date (MM/YY format)
- CVV (3 digits)

**Test Card Numbers:**
- Visa: `4111111111111111`
- Mastercard: `5555555555554444`

**What Happens:**
1. Card validation
2. HBL dummy payment processing
3. User account created
4. Payment record created
5. Membership transaction recorded
6. User logged in automatically
7. User redirected to success page

---

### Step 5: Registration Success
**URL:** `/member/success`
**Route Name:** `member.success`

**Displays:**
- Success confirmation
- Account details
- Next steps guide
- Links to dashboard and profile completion

---

## Access the System

### For Users:
1. Click "Join Now" button on navbar (when not logged in)
2. Complete the 5-step registration flow
3. Dashboard will be accessible immediately

### For Admins:
- User Management: `/admin/user-management`
- View all users, manage roles, reset passwords, etc.

---

## Database Tables

**Users Table:**
- role: member, vendor, admin
- membership_tier: Pro, Ultimate
- membership_status: pending_payment, active, suspended, expired
- membership_expires_at: Expiry timestamp
- phone_verified_at: Verification timestamp

**Related Tables:**
- otp_verifications: OTP codes and verification status
- payments: Payment records and verification
- membership_transactions: Transaction history
- membership_tiers: Tier definitions and pricing

---

## Testing Checklist

Before going live, verify:

- [ ] Member can register with valid data
- [ ] Duplicate email is rejected
- [ ] Duplicate phone is rejected
- [ ] Password validation (min 8 chars) works
- [ ] OTP email is sent and received
- [ ] OTP verification accepts correct code
- [ ] OTP verification rejects wrong code
- [ ] OTP expires after 10 minutes
- [ ] Membership tiers display correctly
- [ ] Pro tier selection works
- [ ] Ultimate tier selection works
- [ ] Payment form accepts test card numbers
- [ ] Payment form rejects invalid cards
- [ ] Payment processing creates account
- [ ] Success page shows correct details
- [ ] User is automatically logged in
- [ ] Dashboard is accessible
- [ ] Payment record exists in database
- [ ] Navigation shows "Join Now" when not logged in

---

## Routes

```
Public (Guest Only):
GET    /member/register          → Registration form
POST   /member/register          → Process registration
GET    /member/verify-otp        → OTP verification form
POST   /member/verify-otp        → Verify OTP
GET    /member/select-tier       → Tier selection form
POST   /member/select-tier       → Select tier
GET    /member/payment           → Payment form
POST   /member/payment           → Process payment

Authenticated:
GET    /member/success           → Success page
```

---

**Version:** 1.0
**Status:** Ready for Testing
**Last Updated:** January 21, 2025

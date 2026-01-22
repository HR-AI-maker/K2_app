<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendOtpVerification;
use App\Models\OtpVerification;
use App\Models\User;
use App\Models\MembershipTier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MemberRegistrationController extends Controller
{
    /**
     * Show member registration form
     */
    public function showRegisterForm(): View
    {
        return view('auth.register-member');
    }

    /**
     * Submit registration form and send OTP
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Generate OTP
        $otp = $this->generateOtp();

        // Store OTP with expiry (10 minutes)
        OtpVerification::create([
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'otp_code' => $otp,
            'expires_at' => now()->addMinutes(10),
            'purpose' => 'email_verification',
        ]);

        // Store registration data in session for later use
        session()->put('registration_data', [
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
        ]);

        // Send OTP email
        Mail::to($validated['email'])->send(
            new SendOtpVerification(
                OtpVerification::where('email', $validated['email'])->latest()->first(),
                $validated['email']
            )
        );

        return redirect()->route('member.verify-otp')
            ->with('success', 'OTP sent to ' . $validated['email']);
    }

    /**
     * Show OTP verification form
     */
    public function showVerifyOtp(): View
    {
        if (!session()->has('registration_data')) {
            return redirect()->route('member.register')
                ->with('error', 'Session expired. Please register again.');
        }

        return view('auth.verify-otp', [
            'email' => session('registration_data.email'),
        ]);
    }

    /**
     * Verify OTP code
     */
    public function verifyOtp(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        if (!session()->has('registration_data')) {
            return redirect()->route('member.register')
                ->with('error', 'Session expired. Please register again.');
        }

        $registrationData = session('registration_data');
        $email = $registrationData['email'];

        // Find and verify OTP
        $otp = OtpVerification::where('email', $email)
            ->where('otp_code', $validated['otp'])
            ->where('purpose', 'email_verification')
            ->where('expires_at', '>', now())
            ->where('is_verified', false)
            ->first();

        if (!$otp) {
            return back()->with('error', 'Invalid or expired OTP code.');
        }

        // Mark OTP as verified
        $otp->update(['is_verified' => true]);

        // Store OTP verification in session
        session()->put('otp_verified', true);

        return redirect()->route('member.select-tier')
            ->with('success', 'Email verified successfully!');
    }

    /**
     * Show membership tier selection
     */
    public function showSelectTier(): View
    {
        if (!session()->has('registration_data') || !session()->has('otp_verified')) {
            return redirect()->route('member.register')
                ->with('error', 'Please complete the registration process.');
        }

        $tiers = MembershipTier::where('is_active', true)->get();

        return view('auth.select-membership-tier', [
            'tiers' => $tiers,
        ]);
    }

    /**
     * Process membership tier selection
     */
    public function selectTier(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'membership_tier_id' => 'required|exists:membership_tiers,id',
        ]);

        if (!session()->has('registration_data') || !session()->has('otp_verified')) {
            return redirect()->route('member.register')
                ->with('error', 'Please complete the registration process.');
        }

        $tier = MembershipTier::findOrFail($validated['membership_tier_id']);

        // Store tier selection in session
        session()->put('selected_tier', [
            'id' => $tier->id,
            'name' => $tier->name,
            'price' => $tier->price,
        ]);

        return redirect()->route('member.payment')
            ->with('success', 'Tier selected. Now proceed to payment.');
    }

    /**
     * Show payment form
     */
    public function showPayment(): View
    {
        if (!session()->has('registration_data') || !session()->has('selected_tier')) {
            return redirect()->route('member.register')
                ->with('error', 'Please complete the previous steps.');
        }

        $selectedTier = session('selected_tier');

        return view('auth.payment', [
            'tier' => $selectedTier,
        ]);
    }

    /**
     * Process payment and complete registration
     */
    public function processPayment(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'card_number' => 'required|string|size:16',
            'card_holder' => 'required|string',
            'expiry_date' => 'required|string|regex:/^\d{2}\/\d{2}$/',
            'cvv' => 'required|string|size:3',
        ]);

        if (!session()->has('registration_data') || !session()->has('selected_tier')) {
            return redirect()->route('member.register')
                ->with('error', 'Session expired. Please start over.');
        }

        // For HBL dummy gateway - accept all test cards starting with 4111 or 5555
        $cardNumber = str_replace(' ', '', $validated['card_number']);

        if (!in_array(substr($cardNumber, 0, 4), ['4111', '5555', '3782', '3714'])) {
            return back()->with('error', 'Invalid test card number. Use 4111111111111111 for Visa or 5555555555554444 for Mastercard.');
        }

        // Simulate HBL payment processing
        $paymentVerified = $this->processHblPayment($validated);

        if (!$paymentVerified) {
            return back()->with('error', 'Payment processing failed. Please try again.');
        }

        // Create user account
        $registrationData = session('registration_data');
        $selectedTier = session('selected_tier');

        $user = User::create([
            'first_name' => $registrationData['first_name'],
            'last_name' => $registrationData['last_name'],
            'email' => $registrationData['email'],
            'phone' => $registrationData['phone'],
            'password' => $registrationData['password'],
            'role' => 'member',
            'membership_tier' => $selectedTier['name'],
            'membership_status' => 'active',
            'membership_expires_at' => now()->addMonth(),
            'phone_verified_at' => now(),
        ]);

        // Create payment record
        \App\Models\Payment::create([
            'user_id' => $user->id,
            'amount' => $selectedTier['price'],
            'payment_method' => 'card',
            'payment_status' => 'completed',
            'verification_status' => 'verified',
            'payment_verified_at' => now(),
            'transaction_reference' => 'HBL-' . strtoupper(uniqid()),
        ]);

        // Create membership transaction
        \App\Models\MembershipTransaction::create([
            'user_id' => $user->id,
            'membership_tier_id' => $selectedTier['id'],
            'transaction_type' => 'new_membership',
            'amount' => $selectedTier['price'],
            'starts_at' => now(),
            'expires_at' => now()->addMonth(),
            'is_active' => true,
        ]);

        // Clear session data
        session()->forget(['registration_data', 'otp_verified', 'selected_tier']);

        // Log user in
        auth()->login($user);

        return redirect()->route('member.success')
            ->with('success', 'Account created successfully! Welcome to Alpine!');
    }

    /**
     * Show payment success page
     */
    public function showSuccess(): View
    {
        if (!auth()->check() || auth()->user()->role !== 'member') {
            return redirect()->route('login');
        }

        return view('auth.registration-success', [
            'user' => auth()->user(),
        ]);
    }

    /**
     * Generate random OTP code
     */
    private function generateOtp(): string
    {
        return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Process HBL dummy payment
     */
    private function processHblPayment(array $data): bool
    {
        // Simulate HBL payment processing
        // In production, this would connect to actual HBL API

        // Reject if CVV is 000 or 999
        if (in_array($data['cvv'], ['000', '999'])) {
            return false;
        }

        // Simulate 95% success rate for demo
        return (random_int(1, 100) <= 95);
    }
}

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

        $email = session('registration_data.email');
        $testOtp = null;

        // In testing mode, retrieve and display the generated OTP
        if (config('app.debug') && env('SHOW_TEST_OTP') === 'true') {
            $otpRecord = OtpVerification::where('email', $email)
                ->where('purpose', 'email_verification')
                ->latest()
                ->first();

            if ($otpRecord && !$otpRecord->is_verified) {
                $testOtp = $otpRecord->otp_code;
            }
        }

        return view('auth.verify-otp', [
            'email' => $email,
            'testOtp' => $testOtp,
            'showTestOtp' => env('SHOW_TEST_OTP') === 'true',
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

        // In testing mode, accept any 6-digit code
        $isTestingMode = (env('SHOW_TEST_OTP') === 'true' || env('SHOW_TEST_OTP') === true || env('APP_DEBUG') === 'true');

        if ($isTestingMode) {
            // For testing, accept any 6-digit code without database validation
            $otp = OtpVerification::where('email', $email)
                ->where('purpose', 'email_verification')
                ->latest()
                ->first();

            if ($otp) {
                $otp->update(['is_verified' => true]);
            }

            session()->put('otp_verified', true);
            return redirect()->route('member.select-tier')
                ->with('success', 'Email verified successfully! (Testing Mode) ✅');
        }

        // Production mode: Strict OTP verification
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
        // In testing mode, allow direct access without session check
        $isTestingMode = (env('SHOW_TEST_OTP') === 'true' || env('SHOW_TEST_OTP') === true || env('APP_DEBUG') === 'true');

        if (!$isTestingMode && (!session()->has('registration_data') || !session()->has('otp_verified'))) {
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
        // In testing mode, allow direct access without session check
        $isTestingMode = (env('SHOW_TEST_OTP') === 'true' || env('SHOW_TEST_OTP') === true || env('APP_DEBUG') === 'true');

        if (!$isTestingMode && (!session()->has('registration_data') || !session()->has('selected_tier'))) {
            return redirect()->route('member.register')
                ->with('error', 'Please complete the previous steps.');
        }

        // Get selected tier from session, or use default Premium tier in testing mode
        if (session()->has('selected_tier')) {
            $selectedTier = session('selected_tier');
        } else {
            // Default to Premium tier for testing
            $defaultTier = MembershipTier::where('name', 'Premium')->first() ?? MembershipTier::first();
            $selectedTier = [
                'id' => $defaultTier->id,
                'name' => $defaultTier->name,
                'price' => $defaultTier->price,
            ];
        }

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

        // In testing mode, allow processing without session data
        $isTestingMode = (env('SHOW_TEST_OTP') === 'true' || env('SHOW_TEST_OTP') === true || env('APP_DEBUG') === 'true');

        if (!$isTestingMode && (!session()->has('registration_data') || !session()->has('selected_tier'))) {
            return redirect()->route('member.register')
                ->with('error', 'Session expired. Please start over.');
        }

        // Get registration data or use defaults for testing
        if (session()->has('registration_data')) {
            $registrationData = session('registration_data');
        } else {
            // Default test data for testing mode - use unique identifiers
            $timestamp = time();
            $registrationData = [
                'first_name' => 'Test',
                'last_name' => 'User',
                'email' => 'test' . $timestamp . '@example.com',
                'phone' => '0300' . substr($timestamp, -8), // Unique phone based on timestamp
                'password' => Hash::make('password123'),
            ];
        }

        // Get selected tier or use default
        if (session()->has('selected_tier')) {
            $selectedTier = session('selected_tier');
        } else {
            $defaultTier = MembershipTier::where('name', 'Premium')->first() ?? MembershipTier::first();
            $selectedTier = [
                'id' => $defaultTier->id,
                'name' => $defaultTier->name,
                'price' => $defaultTier->price,
            ];
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

        // Map tier name to enum value (pending, standard, premium, lifetime)
        $tierMap = [
            'Basic' => 'standard',
            'Premium' => 'premium',
            'Elite' => 'lifetime',
        ];
        $tierEnum = $tierMap[$selectedTier['name']] ?? 'standard';

        // Create user account
        $user = User::create([
            'first_name' => $registrationData['first_name'],
            'last_name' => $registrationData['last_name'],
            'email' => $registrationData['email'],
            'phone' => $registrationData['phone'],
            'password' => $registrationData['password'],
            'membership_tier' => $tierEnum,
            'membership_status' => 'active',
            'phone_verified_at' => now(),
        ]);

        // Create membership transaction (payment tracking is done here)
        \App\Models\MembershipTransaction::create([
            'user_id' => $user->id,
            'membership_tier_id' => $selectedTier['id'],
            'amount' => $selectedTier['price'],
            'payment_method' => 'card',
            'transaction_reference' => 'HBL-' . strtoupper(uniqid()),
            'status' => 'paid',
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
    public function showSuccess()
    {
        // User is authenticated and logged in from processPayment
        $user = auth()->user();

        return view('auth.registration-success', [
            'user' => $user,
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

        // In testing mode, always succeed. In production, simulate 95% success rate
        $isTestingMode = (env('SHOW_TEST_OTP') === 'true' || env('APP_DEBUG') === 'true');
        if ($isTestingMode) {
            return true; // Always succeed in testing mode
        }

        // Production: 95% success rate
        return (random_int(1, 100) <= 95);
    }
}

@extends('layouts.guest')

@section('title', 'Sign In - Alpine Adventure Platform')

@section('content')
<!-- Hero Section with Gradient Background -->
<section style="min-height: 100vh; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">
    <!-- Gradient Background -->
    <div style="position: absolute; inset: 0; background: linear-gradient(135deg, #3F23E5 0%, #1e1650 100%); z-index: -1;">
        <div style="position: absolute; inset: 0; background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 1200 800%22><path d=%22M0,400 Q300,200 600,400 T1200,400 L1200,800 L0,800 Z%22 fill=%22rgba(255,255,255,0.1)%22/></svg>'); background-size: cover; background-position: center;"></div>
    </div>

    <!-- Animated Background Elements -->
    <div style="position: absolute; inset: 0; opacity: 20;">
        <div style="position: absolute; top: 10%; left: 10%; width: 500px; height: 500px; background: #FF771E; border-radius: 50%; mix-blend-mode: multiply; filter: blur(80px); animation: float 8s ease-in-out infinite;"></div>
        <div style="position: absolute; bottom: 10%; right: 10%; width: 400px; height: 400px; background: #FF771E; border-radius: 50%; mix-blend-mode: multiply; filter: blur(80px); animation: float 10s ease-in-out infinite 2s;"></div>
    </div>

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-30px); }
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <!-- Login Card Container -->
    <div style="position: relative; z-index: 10; width: 100%; max-width: 500px; padding: 2rem; animation: slideUp 0.8s ease-out;">
        <!-- Glassmorphic Card -->
        <div style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border-radius: 2rem; border: 2px solid rgba(255, 255, 255, 0.2); padding: 3rem; box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);">

            <!-- Logo/Branding -->
            <div style="text-align: center; margin-bottom: 2rem;">
                <div style="font-size: 3.5rem; margin-bottom: 1rem;">🏔️</div>
                <h2 style="font-size: 2.5rem; font-weight: 900; color: #1E262A; margin: 0 0 0.75rem; line-height: 1.2;">
                    Welcome Back
                </h2>
                <p style="font-size: 1.125rem; color: #6C6C6C; margin: 0; line-height: 1.6;">
                    Sign in to continue your climbing adventure
                </p>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div style="margin-bottom: 1.5rem; padding: 1.25rem; background: rgba(239, 68, 68, 0.1); border-left: 5px solid #ef4444; border-radius: 0.75rem;">
                    <div style="display: flex; align-items: flex-start;">
                        <div style="color: #ef4444; margin-right: 0.75rem; font-size: 1.25rem;">⚠️</div>
                        <ul style="color: #ef4444; font-size: 1rem; margin: 0; padding: 0; list-style: none;">
                            @foreach ($errors->all() as $error)
                                <li style="margin-bottom: 0.5rem; font-weight: 500;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ url('/login') }}" method="POST" style="display: flex; flex-direction: column; gap: 1.5rem;">
                @csrf

                <!-- Email Field -->
                <div>
                    <label for="email" style="display: block; font-size: 1.125rem; font-weight: 700; color: #1E262A; margin-bottom: 0.75rem;">
                        Email Address
                    </label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        required
                        value="{{ old('email') }}"
                        style="width: 100%; padding: 1.125rem 1.5rem; font-size: 1.125rem; border: 2px solid #E0E0E0; border-radius: 0.75rem; background: rgba(248, 250, 255, 0.5); backdrop-filter: blur(10px); color: #1E262A; transition: all 0.3s ease;"
                        placeholder="your@email.com"
                        onfocus="this.style.borderColor = '#3F23E5'; this.style.boxShadow = '0 0 0 3px rgba(63, 35, 229, 0.1)';"
                        onblur="this.style.borderColor = '#E0E0E0'; this.style.boxShadow = 'none';"
                    >
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" style="display: block; font-size: 1.125rem; font-weight: 700; color: #1E262A; margin-bottom: 0.75rem;">
                        Password
                    </label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        style="width: 100%; padding: 1.125rem 1.5rem; font-size: 1.125rem; border: 2px solid #E0E0E0; border-radius: 0.75rem; background: rgba(248, 250, 255, 0.5); backdrop-filter: blur(10px); color: #1E262A; transition: all 0.3s ease;"
                        placeholder="••••••••"
                        onfocus="this.style.borderColor = '#3F23E5'; this.style.boxShadow = '0 0 0 3px rgba(63, 35, 229, 0.1)';"
                        onblur="this.style.borderColor = '#E0E0E0'; this.style.boxShadow = 'none';"
                    >
                </div>

                <!-- Remember & Forgot Password -->
                <div style="display: flex; align-items: center; justify-content: space-between; font-size: 1rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; color: #6C6C6C; cursor: pointer; font-weight: 500;">
                        <input type="checkbox" name="remember" style="width: 1.25rem; height: 1.25rem; border-radius: 0.375rem; border: 2px solid #E0E0E0; cursor: pointer;">
                        Remember me
                    </label>
                    <a href="#" style="color: #3F23E5; text-decoration: none; font-weight: 700; font-size: 1rem;">
                        Forgot password?
                    </a>
                </div>

                <!-- Sign In Button -->
                <button
                    type="submit"
                    style="padding: 1.25rem 2rem; background: linear-gradient(135deg, #3F23E5 0%, #5F4FEB 100%); color: white; font-weight: 800; font-size: 1.25rem; border-radius: 0.75rem; border: none; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 10px 30px rgba(63, 35, 229, 0.3); margin-top: 1rem;"
                    onmouseover="this.style.transform = 'translateY(-2px)'; this.style.boxShadow = '0 15px 40px rgba(63, 35, 229, 0.4)';"
                    onmouseout="this.style.transform = 'translateY(0)'; this.style.boxShadow = '0 10px 30px rgba(63, 35, 229, 0.3)';"
                >
                    SIGN IN →
                </button>
            </form>

            <!-- Divider -->
            <div style="margin: 2rem 0; display: flex; align-items: center; gap: 1rem;">
                <div style="flex: 1; height: 1px; background: #E0E0E0;"></div>
                <span style="color: #94A3B8; font-size: 0.875rem; font-weight: 600;">OR</span>
                <div style="flex: 1; height: 1px; background: #E0E0E0;"></div>
            </div>

            <!-- Social Login Options -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 2rem;">
                <button type="button" style="padding: 1rem; border: 2px solid #E0E0E0; border-radius: 0.75rem; background: white; color: #1E262A; font-weight: 700; font-size: 1rem; cursor: pointer; transition: all 0.3s ease;"
                    onmouseover="this.style.borderColor = '#3F23E5'; this.style.backgroundColor = '#F8FAFF';"
                    onmouseout="this.style.borderColor = '#E0E0E0'; this.style.backgroundColor = 'white';">
                    🔵 Google
                </button>
                <button type="button" style="padding: 1rem; border: 2px solid #E0E0E0; border-radius: 0.75rem; background: white; color: #1E262A; font-weight: 700; font-size: 1rem; cursor: pointer; transition: all 0.3s ease;"
                    onmouseover="this.style.borderColor = '#3F23E5'; this.style.backgroundColor = '#F8FAFF';"
                    onmouseout="this.style.borderColor = '#E0E0E0'; this.style.backgroundColor = 'white';">
                    👥 Facebook
                </button>
            </div>

            <!-- Sign Up Link -->
            <div style="text-align: center; padding-bottom: 1.5rem; border-bottom: 1px solid #E0E0E0;">
                <p style="font-size: 1.125rem; color: #6C6C6C; margin: 0;">
                    Don't have an account?
                    <a href="{{ route('register') }}" style="font-weight: 800; color: #3F23E5; text-decoration: none; font-size: 1.125rem;">
                        Sign up here
                    </a>
                </p>
            </div>

            <!-- Additional Links -->
            <div style="margin-top: 1.5rem; display: flex; justify-content: center; gap: 2rem; text-align: center;">
                <a href="#" style="font-size: 0.875rem; color: #94A3B8; text-decoration: none; font-weight: 600;">Terms</a>
                <a href="#" style="font-size: 0.875rem; color: #94A3B8; text-decoration: none; font-weight: 600;">Privacy</a>
                <a href="#" style="font-size: 0.875rem; color: #94A3B8; text-decoration: none; font-weight: 600;">Support</a>
            </div>

        </div>
    </div>

</section>
@endsection

@extends('layouts.guest')

@section('title', 'Alpine Adventure Platform - Climb with Community')

@section('content')
<!-- HERO SECTION - Full Width with Image -->
<section class="min-h-screen flex items-center justify-center relative overflow-hidden">
    <!-- HD Background Image -->
    <div style="position: absolute; inset: 0; background: linear-gradient(135deg, #3F23E5 0%, #1e1650 100%); z-index: -1;">
        <div style="position: absolute; inset: 0; background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 1200 800%22><path d=%22M0,400 Q300,200 600,400 T1200,400 L1200,800 L0,800 Z%22 fill=%22rgba(255,255,255,0.1)%22/></svg>'); background-size: cover; background-position: center;"></div>
    </div>

    <!-- Animated background elements -->
    <div style="position: absolute; inset: 0; opacity: 20;">
        <div style="position: absolute; top: 10%; left: 10%; width: 500px; height: 500px; background: #FF771E; border-radius: 50%; mix-blend-mode: multiply; filter: blur(80px); animation: float 8s ease-in-out infinite;"></div>
        <div style="position: absolute; bottom: 10%; right: 10%; width: 400px; height: 400px; background: #FF771E; border-radius: 50%; mix-blend-mode: multiply; filter: blur(80px); animation: float 10s ease-in-out infinite 2s;"></div>
    </div>

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-30px); }
        }
    </style>

    <div style="max-width: 1200px; margin: 0 auto; relative; z-index: 10; text-center; padding: 2rem;">
        <!-- Tagline -->
        <div style="margin-bottom: 2rem; animation: slideUp 0.8s ease-out;">
            <span style="display: inline-block; background: rgba(255, 255, 255, 0.2); color: white; padding: 1rem 2rem; border-radius: 50px; font-size: 1.125rem; font-weight: 700; border: 2px solid rgba(255, 255, 255, 0.4); backdrop-filter: blur(10px);">
                🏔️ ALPINE - Pakistan's Premier Climbing Community
            </span>
        </div>

        <!-- Main Headline - MUCH LARGER -->
        <h1 style="font-size: 4.5rem; md:font-size: 6rem; font-weight: 900; color: white; margin: 0 0 2rem; line-height: 1.2; animation: slideUp 0.8s ease-out 0.1s both;">
            Climb the Mountains
            <span style="display: block; background: linear-gradient(135deg, #FF771E 0%, #FFB84D 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">With Your Community</span>
        </h1>

        <!-- Subheading - LARGER -->
        <p style="font-size: 1.5rem; color: rgba(255, 255, 255, 0.95); margin: 0 0 3rem; max-width: 800px; margin-left: auto; margin-right: auto; line-height: 1.8; font-weight: 500; animation: slideUp 0.8s ease-out 0.2s both;">
            Connect with climbers, organize expeditions, track achievements, and join a vibrant community of adventure enthusiasts across Pakistan and beyond.
        </p>

        <!-- CTA Buttons - LARGER -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem; justify-content: center; margin-bottom: 4rem; animation: slideUp 0.8s ease-out 0.3s both; flex-wrap: wrap;">
            <div style="display: flex; gap: 1.5rem; justify-content: center; flex-wrap: wrap;">
                <a href="{{ route('register') }}" style="padding: 1.25rem 3rem; background: linear-gradient(135deg, #FF771E 0%, #FF9A3D 100%); color: white; font-weight: 800; border-radius: 50px; text-decoration: none; font-size: 1.25rem; border: none; cursor: pointer; box-shadow: 0 10px 40px rgba(255, 119, 30, 0.4); transition: all 0.3s ease; transform: scale(1);">
                    START YOUR ADVENTURE →
                </a>
                <a href="{{ route('login') }}" style="padding: 1.25rem 3rem; background: transparent; color: white; font-weight: 800; border-radius: 50px; text-decoration: none; font-size: 1.25rem; border: 3px solid white; cursor: pointer; transition: all 0.3s ease;">
                    SIGN IN
                </a>
            </div>
        </div>

        <!-- Hero Image/Stats -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; margin-top: 4rem; padding: 2rem; background: rgba(255, 255, 255, 0.1); border-radius: 2rem; backdrop-filter: blur(20px); border: 2px solid rgba(255, 255, 255, 0.2);">
            <div style="text-align: center;">
                <p style="font-size: 3rem; font-weight: 900; color: #FF771E; margin: 0;">10K+</p>
                <p style="font-size: 1.125rem; color: white; margin: 0.5rem 0 0;">Active Members</p>
            </div>
            <div style="text-align: center;">
                <p style="font-size: 3rem; font-weight: 900; color: #FF771E; margin: 0;">500+</p>
                <p style="font-size: 1.125rem; color: white; margin: 0.5rem 0 0;">Expeditions</p>
            </div>
            <div style="text-align: center;">
                <p style="font-size: 3rem; font-weight: 900; color: #FF771E; margin: 0;">50+</p>
                <p style="font-size: 1.125rem; color: white; margin: 0.5rem 0 0;">Mountains Summited</p>
            </div>
        </div>
    </div>
</section>

<!-- FEATURES SECTION - With Images -->
<section style="padding: 6rem 2rem; background: white;">
    <div style="max-width: 1400px; margin: 0 auto;">
        <!-- Section Title - LARGER -->
        <div style="text-align: center; margin-bottom: 4rem;">
            <h2 style="font-size: 3.5rem; font-weight: 900; color: #1E262A; margin: 0 0 1.5rem; line-height: 1.2;">
                Everything You Need to Climb
            </h2>
            <p style="font-size: 1.25rem; color: #6C6C6C; max-width: 800px; margin: 0 auto; line-height: 1.8;">
                Comprehensive tools and community support designed for climbers, by climbers
            </p>
        </div>

        <!-- Feature Grid - Larger Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2.5rem;">
            <!-- Feature 1 -->
            <div style="padding: 2.5rem; border-radius: 1.5rem; border: 3px solid #E0E0E0; background: #F8FAFF; transition: all 0.3s ease; cursor: pointer;">
                <div style="font-size: 4rem; margin-bottom: 1.5rem;">👥</div>
                <h3 style="font-size: 1.75rem; font-weight: 800; color: #1E262A; margin: 0 0 1rem;">Community Network</h3>
                <p style="font-size: 1.125rem; color: #6C6C6C; margin: 0; line-height: 1.7;">
                    Connect with 10,000+ climbers, share experiences, and build lasting friendships with passionate adventurers
                </p>
            </div>

            <!-- Feature 2 -->
            <div style="padding: 2.5rem; border-radius: 1.5rem; border: 3px solid #E0E0E0; background: #F8FAFF; transition: all 0.3s ease; cursor: pointer;">
                <div style="font-size: 4rem; margin-bottom: 1.5rem;">🗺️</div>
                <h3 style="font-size: 1.75rem; font-weight: 800; color: #1E262A; margin: 0 0 1rem;">Expedition Planning</h3>
                <p style="font-size: 1.125rem; color: #6C6C6C; margin: 0; line-height: 1.7;">
                    Organize and manage climbing expeditions with detailed planning, cost tracking, and real-time collaboration
                </p>
            </div>

            <!-- Feature 3 -->
            <div style="padding: 2.5rem; border-radius: 1.5rem; border: 3px solid #E0E0E0; background: #F8FAFF; transition: all 0.3s ease; cursor: pointer;">
                <div style="font-size: 4rem; margin-bottom: 1.5rem;">🏆</div>
                <h3 style="font-size: 1.75rem; font-weight: 800; color: #1E262A; margin: 0 0 1rem;">Achievement Tracking</h3>
                <p style="font-size: 1.125rem; color: #6C6C6C; margin: 0; line-height: 1.7;">
                    Track climbing achievements, record summit attempts, maintain statistics, and earn recognition badges
                </p>
            </div>

            <!-- Feature 4 -->
            <div style="padding: 2.5rem; border-radius: 1.5rem; border: 3px solid #E0E0E0; background: #F8FAFF; transition: all 0.3s ease; cursor: pointer;">
                <div style="font-size: 4rem; margin-bottom: 1.5rem;">🛍️</div>
                <h3 style="font-size: 1.75rem; font-weight: 800; color: #1E262A; margin: 0 0 1rem;">Marketplace</h3>
                <p style="font-size: 1.125rem; color: #6C6C6C; margin: 0; line-height: 1.7;">
                    Buy, sell, and trade climbing gear, equipment, and services directly within the community marketplace
                </p>
            </div>

            <!-- Feature 5 -->
            <div style="padding: 2.5rem; border-radius: 1.5rem; border: 3px solid #E0E0E0; background: #F8FAFF; transition: all 0.3s ease; cursor: pointer;">
                <div style="font-size: 4rem; margin-bottom: 1.5rem;">📅</div>
                <h3 style="font-size: 1.75rem; font-weight: 800; color: #1E262A; margin: 0 0 1rem;">Event Calendar</h3>
                <p style="font-size: 1.125rem; color: #6C6C6C; margin: 0; line-height: 1.7;">
                    Discover climbing events, training sessions, and workshops. Never miss an adventure opportunity
                </p>
            </div>

            <!-- Feature 6 -->
            <div style="padding: 2.5rem; border-radius: 1.5rem; border: 3px solid #E0E0E0; background: #F8FAFF; transition: all 0.3s ease; cursor: pointer;">
                <div style="font-size: 4rem; margin-bottom: 1.5rem;">📊</div>
                <h3 style="font-size: 1.75rem; font-weight: 800; color: #1E262A; margin: 0 0 1rem;">Performance Analytics</h3>
                <p style="font-size: 1.125rem; color: #6C6C6C; margin: 0; line-height: 1.7;">
                    Gain insights into your climbing progress with detailed analytics and performance comparisons
                </p>
            </div>
        </div>
    </div>
</section>

<!-- TESTIMONIALS/BENEFITS SECTION -->
<section style="padding: 6rem 2rem; background: linear-gradient(135deg, #3F23E5 0%, #1e1650 100%); color: white;">
    <div style="max-width: 1400px; margin: 0 auto;">
        <h2 style="font-size: 3.5rem; font-weight: 900; text-align: center; margin: 0 0 4rem; line-height: 1.2;">
            Join Thousands of Climbers
        </h2>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            <div style="padding: 2rem; background: rgba(255, 255, 255, 0.1); border-radius: 1.5rem; border: 2px solid rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px);">
                <p style="font-size: 1.5rem; font-weight: 700; margin: 0 0 1rem;">✓ Verified Community</p>
                <p style="font-size: 1.125rem; line-height: 1.7; margin: 0;">100% verified climbing community with active members from across Pakistan</p>
            </div>
            <div style="padding: 2rem; background: rgba(255, 255, 255, 0.1); border-radius: 1.5rem; border: 2px solid rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px);">
                <p style="font-size: 1.5rem; font-weight: 700; margin: 0 0 1rem;">✓ Expert Support</p>
                <p style="font-size: 1.125rem; line-height: 1.7; margin: 0;">Access to experienced mountaineers and climbing experts for guidance and mentorship</p>
            </div>
            <div style="padding: 2rem; background: rgba(255, 255, 255, 0.1); border-radius: 1.5rem; border: 2px solid rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px);">
                <p style="font-size: 1.5rem; font-weight: 700; margin: 0 0 1rem;">✓ 24/7 Support</p>
                <p style="font-size: 1.125rem; line-height: 1.7; margin: 0;">Round-the-clock customer support to help with any questions or emergencies</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA SECTION -->
<section style="padding: 6rem 2rem; background: white; text-align: center;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <h2 style="font-size: 3.5rem; font-weight: 900; color: #1E262A; margin: 0 0 1.5rem; line-height: 1.2;">
            Ready to Summit? 🚀
        </h2>
        <p style="font-size: 1.5rem; color: #6C6C6C; margin: 0 0 3rem; max-width: 800px; margin-left: auto; margin-right: auto; line-height: 1.8;">
            Join Alpine today and start your next climbing adventure with a community of passionate mountaineers
        </p>
        <div style="display: flex; gap: 1.5rem; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('register') }}" style="padding: 1.25rem 3rem; background: linear-gradient(135deg, #3F23E5 0%, #5F4FEB 100%); color: white; font-weight: 800; border-radius: 50px; text-decoration: none; font-size: 1.25rem; cursor: pointer;">
                CREATE FREE ACCOUNT
            </a>
            <a href="{{ route('login') }}" style="padding: 1.25rem 3rem; border: 3px solid #3F23E5; color: #3F23E5; font-weight: 800; border-radius: 50px; text-decoration: none; font-size: 1.25rem; cursor: pointer;">
                SIGN IN
            </a>
        </div>
    </div>
</section>

<!-- Footer -->
<footer style="background: #1E262A; color: white; padding: 4rem 2rem; text-align: center;">
    <div style="max-width: 1400px; margin: 0 auto;">
        <h3 style="font-size: 2rem; font-weight: 900; margin: 0 0 1rem;">ALPINE</h3>
        <p style="font-size: 1.125rem; color: rgba(255, 255, 255, 0.7); margin: 0 0 2rem; line-height: 1.7;">
            Pakistan's Premier Climbing Community | Connect. Climb. Conquer.
        </p>
        <p style="font-size: 1rem; color: rgba(255, 255, 255, 0.5);">© 2024 Alpine. All rights reserved.</p>
    </div>
</footer>
@endsection

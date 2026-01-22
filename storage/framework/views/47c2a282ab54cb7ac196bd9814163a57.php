<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alpine - Mountain Adventure Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        :root {
            --primary: #1e5f8a;
            --primary-dark: #0f3d56;
            --secondary: #2a7f5e;
            --accent: #d97706;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-600: #4b5563;
            --gray-900: #111827;
        }
        .hero-gradient {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        }
        .glass-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }
        .feature-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        .expedition-card {
            transition: transform 0.3s ease;
        }
        .expedition-card:hover {
            transform: scale(1.02);
        }
        .btn-primary {
            background: var(--primary);
            color: white;
            padding: 0.875rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
        }
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }
        .btn-outline-white {
            background: transparent;
            color: white;
            padding: 0.875rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            border: 2px solid white;
            transition: all 0.3s ease;
            display: inline-block;
        }
        .btn-outline-white:hover {
            background: white;
            color: var(--primary-dark);
        }
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 1rem;
        }
        .section-subtitle {
            font-size: 1.125rem;
            color: var(--gray-600);
            max-width: 600px;
            margin: 0 auto;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-white">
    <!-- TOP BAR -->
    <div style="background: var(--primary-dark); padding: 0.5rem 0;">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center text-white text-sm">
            <div class="flex items-center gap-6">
                <span class="flex items-center gap-2">
                    <span>📞</span> +92 51 1234567
                </span>
                <span class="flex items-center gap-2">
                    <span>✉️</span> info@pakalpine.com
                </span>
            </div>
            <div class="flex items-center gap-4">
                <a href="#" class="hover:text-amber-300 transition">Facebook</a>
                <a href="#" class="hover:text-amber-300 transition">Instagram</a>
                <a href="#" class="hover:text-amber-300 transition">Twitter</a>
            </div>
        </div>
    </div>

    <!-- NAVIGATION -->
    <nav style="background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 100;">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="/" class="flex items-center gap-3">
                <span class="text-4xl">🏔️</span>
                <div>
                    <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--primary-dark);">Pak Alpine</h1>
                    <p style="font-size: 0.75rem; color: var(--gray-600);">Mountain Adventures</p>
                </div>
            </a>
            <div class="hidden md:flex items-center gap-8">
                <a href="#features" style="color: var(--gray-600); font-weight: 500;" class="hover:text-blue-700 transition">Features</a>
                <a href="#expeditions" style="color: var(--gray-600); font-weight: 500;" class="hover:text-blue-700 transition">Expeditions</a>
                <a href="#pricing" style="color: var(--gray-600); font-weight: 500;" class="hover:text-blue-700 transition">Pricing</a>
                <a href="#testimonials" style="color: var(--gray-600); font-weight: 500;" class="hover:text-blue-700 transition">Reviews</a>
            </div>
            <div class="flex items-center gap-3">
                <a href="<?php echo e(route('login')); ?>" style="color: var(--primary); font-weight: 600;" class="hover:underline">Sign In</a>
                <a href="<?php echo e(route('member.register')); ?>" class="btn-primary">Get Started</a>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero-gradient relative overflow-hidden" style="min-height: 90vh; display: flex; align-items: center;">
        <!-- Background decorations -->
        <div style="position: absolute; inset: 0; opacity: 0.1;">
            <div style="position: absolute; width: 400px; height: 400px; background: radial-gradient(circle, white 0%, transparent 70%); top: -150px; right: -100px;"></div>
            <div style="position: absolute; width: 300px; height: 300px; background: radial-gradient(circle, white 0%, transparent 70%); bottom: -100px; left: -100px;"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 py-20 relative z-10 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <!-- Left Content -->
                <div>
                    <div style="display: inline-block; background: rgba(255,255,255,0.15); padding: 0.5rem 1.25rem; border-radius: 9999px; margin-bottom: 1.5rem;">
                        <span class="text-white text-sm font-semibold">🏔️ Pakistan's Premier Adventure Platform</span>
                    </div>
                    <h1 style="font-size: 3.75rem; font-weight: 800; color: white; margin-bottom: 1.5rem; line-height: 1.1;">
                        Escape Ordinary.<br/>
                        <span style="color: #fbbf24;">Embrace the Peak.</span>
                    </h1>
                    <p style="font-size: 1.25rem; color: rgba(255,255,255,0.9); margin-bottom: 2.5rem; max-width: 520px; line-height: 1.7;">
                        Connect with expert climbers, explore breathtaking expeditions, and experience premium mountain adventures on Pakistan's most trusted platform.
                    </p>

                    <!-- Stats Row -->
                    <div style="display: flex; gap: 2rem; margin-bottom: 2.5rem; flex-wrap: wrap;">
                        <div style="text-align: center;">
                            <div style="font-size: 2rem; font-weight: 700; color: #fbbf24;">10K+</div>
                            <div style="font-size: 0.875rem; color: rgba(255,255,255,0.8);">Active Members</div>
                        </div>
                        <div style="text-align: center;">
                            <div style="font-size: 2rem; font-weight: 700; color: #fbbf24;">50+</div>
                            <div style="font-size: 0.875rem; color: rgba(255,255,255,0.8);">Expeditions</div>
                        </div>
                        <div style="text-align: center;">
                            <div style="font-size: 2rem; font-weight: 700; color: #fbbf24;">100%</div>
                            <div style="font-size: 0.875rem; color: rgba(255,255,255,0.8);">Verified Guides</div>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                        <a href="<?php echo e(route('member.register')); ?>" class="btn-primary" style="padding: 1rem 2.5rem; font-size: 1.125rem;">
                            Start Your Journey →
                        </a>
                        <a href="<?php echo e(route('login')); ?>" class="btn-outline-white" style="padding: 1rem 2.5rem; font-size: 1.125rem;">
                            Sign In
                        </a>
                    </div>
                </div>

                <!-- Right: Feature Cards Grid -->
                <div class="hidden lg:grid grid-cols-2 gap-4">
                    <div class="glass-card rounded-2xl p-6 text-center text-white float-animation" style="animation-delay: 0s;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🗺️</div>
                        <h4 style="font-weight: 700; font-size: 1.125rem; margin-bottom: 0.5rem;">Explore</h4>
                        <p style="font-size: 0.875rem; opacity: 0.9;">Discover peaks, trails & hidden gems</p>
                    </div>
                    <div class="glass-card rounded-2xl p-6 text-center text-white float-animation" style="animation-delay: 0.5s;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">👥</div>
                        <h4 style="font-weight: 700; font-size: 1.125rem; margin-bottom: 0.5rem;">Connect</h4>
                        <p style="font-size: 0.875rem; opacity: 0.9;">Join the climbing community</p>
                    </div>
                    <div class="glass-card rounded-2xl p-6 text-center text-white float-animation" style="animation-delay: 1s;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🛡️</div>
                        <h4 style="font-weight: 700; font-size: 1.125rem; margin-bottom: 0.5rem;">Safety</h4>
                        <p style="font-size: 0.875rem; opacity: 0.9;">GPS tracking & SOS system</p>
                    </div>
                    <div class="glass-card rounded-2xl p-6 text-center text-white float-animation" style="animation-delay: 1.5s;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🏆</div>
                        <h4 style="font-weight: 700; font-size: 1.125rem; margin-bottom: 0.5rem;">Achieve</h4>
                        <p style="font-size: 0.875rem; opacity: 0.9;">Earn badges & recognition</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll indicator -->
        <div style="position: absolute; bottom: 2rem; left: 50%; transform: translateX(-50%); text-align: center;">
            <div style="color: white; font-size: 0.875rem; margin-bottom: 0.5rem;">Scroll to explore</div>
            <div style="width: 30px; height: 50px; border: 2px solid rgba(255,255,255,0.5); border-radius: 15px; margin: 0 auto; position: relative;">
                <div style="width: 6px; height: 10px; background: white; border-radius: 3px; position: absolute; top: 8px; left: 50%; transform: translateX(-50%); animation: float 1.5s ease-in-out infinite;"></div>
            </div>
        </div>
    </section>

    <!-- WHY CHOOSE US SECTION -->
    <section id="features" style="padding: 6rem 1rem; background: var(--gray-50);">
        <div class="max-w-7xl mx-auto">
            <div style="text-align: center; margin-bottom: 4rem;">
                <span style="color: var(--accent); font-weight: 600; text-transform: uppercase; letter-spacing: 2px; font-size: 0.875rem;">Why Choose Us</span>
                <h2 class="section-title" style="margin-top: 0.5rem;">Everything You Need for Adventure</h2>
                <p class="section-subtitle">From planning to execution, we provide premium services for unforgettable mountain experiences</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card bg-white rounded-2xl p-8 shadow-lg">
                    <div style="width: 70px; height: 70px; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                        <span style="font-size: 2rem;">🗺️</span>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.75rem;">Expert Planning</h3>
                    <p style="color: var(--gray-600); line-height: 1.6;">Comprehensive expedition planning with detailed itineraries, gear lists, and expert guidance.</p>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card bg-white rounded-2xl p-8 shadow-lg">
                    <div style="width: 70px; height: 70px; background: linear-gradient(135deg, var(--secondary) 0%, #1f6048 100%); border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                        <span style="font-size: 2rem;">🛡️</span>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.75rem;">Safety First</h3>
                    <p style="color: var(--gray-600); line-height: 1.6;">Real-time GPS tracking, emergency SOS system, and 24/7 support for peace of mind.</p>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card bg-white rounded-2xl p-8 shadow-lg">
                    <div style="width: 70px; height: 70px; background: linear-gradient(135deg, var(--accent) 0%, #b45309 100%); border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                        <span style="font-size: 2rem;">💎</span>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.75rem;">Premium Quality</h3>
                    <p style="color: var(--gray-600); line-height: 1.6;">Curated experiences with verified guides, quality equipment, and premium accommodations.</p>
                </div>

                <!-- Feature 4 -->
                <div class="feature-card bg-white rounded-2xl p-8 shadow-lg">
                    <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                        <span style="font-size: 2rem;">👥</span>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.75rem;">Vibrant Community</h3>
                    <p style="color: var(--gray-600); line-height: 1.6;">Connect with 10,000+ climbers, share experiences, and find expedition partners.</p>
                </div>

                <!-- Feature 5 -->
                <div class="feature-card bg-white rounded-2xl p-8 shadow-lg">
                    <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #ec4899 0%, #be185d 100%); border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                        <span style="font-size: 2rem;">🏪</span>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.75rem;">Marketplace</h3>
                    <p style="color: var(--gray-600); line-height: 1.6;">Buy, sell, and rent quality climbing gear from verified vendors at competitive prices.</p>
                </div>

                <!-- Feature 6 -->
                <div class="feature-card bg-white rounded-2xl p-8 shadow-lg">
                    <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%); border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                        <span style="font-size: 2rem;">🎓</span>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.75rem;">Training & Events</h3>
                    <p style="color: var(--gray-600); line-height: 1.6;">Access workshops, certifications, and events to enhance your climbing skills.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURED EXPEDITIONS -->
    <section id="expeditions" style="padding: 6rem 1rem; background: white;">
        <div class="max-w-7xl mx-auto">
            <div style="text-align: center; margin-bottom: 4rem;">
                <span style="color: var(--accent); font-weight: 600; text-transform: uppercase; letter-spacing: 2px; font-size: 0.875rem;">Popular Destinations</span>
                <h2 class="section-title" style="margin-top: 0.5rem;">Featured Expeditions</h2>
                <p class="section-subtitle">Join our most sought-after mountain adventures led by certified expert guides</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Expedition 1 -->
                <div class="expedition-card bg-white rounded-2xl overflow-hidden shadow-xl">
                    <div style="height: 220px; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); position: relative;">
                        <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;">
                            <span style="font-size: 5rem; opacity: 0.3;">🏔️</span>
                        </div>
                        <div style="position: absolute; top: 1rem; left: 1rem; background: var(--accent); color: white; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                            FEATURED
                        </div>
                        <div style="position: absolute; bottom: 1rem; right: 1rem; background: rgba(0,0,0,0.5); color: white; padding: 0.25rem 0.75rem; border-radius: 0.5rem; font-size: 0.875rem;">
                            14 Days
                        </div>
                    </div>
                    <div style="padding: 1.5rem;">
                        <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">K2 Base Camp Trek</h3>
                        <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: 1rem; line-height: 1.6;">Experience the majestic beauty of the world's second-highest peak.</p>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <span style="font-size: 0.75rem; color: var(--gray-600);">From</span>
                                <div style="font-size: 1.25rem; font-weight: 700; color: var(--primary);">PKR 250,000</div>
                            </div>
                            <a href="<?php echo e(route('login')); ?>" style="background: var(--primary); color: white; padding: 0.5rem 1.25rem; border-radius: 0.5rem; font-weight: 600; font-size: 0.875rem;">Explore →</a>
                        </div>
                    </div>
                </div>

                <!-- Expedition 2 -->
                <div class="expedition-card bg-white rounded-2xl overflow-hidden shadow-xl">
                    <div style="height: 220px; background: linear-gradient(135deg, var(--secondary) 0%, #1f6048 100%); position: relative;">
                        <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;">
                            <span style="font-size: 5rem; opacity: 0.3;">⛰️</span>
                        </div>
                        <div style="position: absolute; top: 1rem; left: 1rem; background: #22c55e; color: white; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                            POPULAR
                        </div>
                        <div style="position: absolute; bottom: 1rem; right: 1rem; background: rgba(0,0,0,0.5); color: white; padding: 0.25rem 0.75rem; border-radius: 0.5rem; font-size: 0.875rem;">
                            10 Days
                        </div>
                    </div>
                    <div style="padding: 1.5rem;">
                        <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">Nanga Parbat Trek</h3>
                        <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: 1rem; line-height: 1.6;">Conquer the "Killer Mountain" with our experienced expedition team.</p>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <span style="font-size: 0.75rem; color: var(--gray-600);">From</span>
                                <div style="font-size: 1.25rem; font-weight: 700; color: var(--primary);">PKR 180,000</div>
                            </div>
                            <a href="<?php echo e(route('login')); ?>" style="background: var(--primary); color: white; padding: 0.5rem 1.25rem; border-radius: 0.5rem; font-weight: 600; font-size: 0.875rem;">Explore →</a>
                        </div>
                    </div>
                </div>

                <!-- Expedition 3 -->
                <div class="expedition-card bg-white rounded-2xl overflow-hidden shadow-xl">
                    <div style="height: 220px; background: linear-gradient(135deg, var(--accent) 0%, #b45309 100%); position: relative;">
                        <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;">
                            <span style="font-size: 5rem; opacity: 0.3;">🌄</span>
                        </div>
                        <div style="position: absolute; top: 1rem; left: 1rem; background: #3b82f6; color: white; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                            BEGINNER FRIENDLY
                        </div>
                        <div style="position: absolute; bottom: 1rem; right: 1rem; background: rgba(0,0,0,0.5); color: white; padding: 0.25rem 0.75rem; border-radius: 0.5rem; font-size: 0.875rem;">
                            7 Days
                        </div>
                    </div>
                    <div style="padding: 1.5rem;">
                        <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">Hunza Valley Explorer</h3>
                        <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: 1rem; line-height: 1.6;">Discover the stunning landscapes and rich culture of Hunza Valley.</p>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <span style="font-size: 0.75rem; color: var(--gray-600);">From</span>
                                <div style="font-size: 1.25rem; font-weight: 700; color: var(--primary);">PKR 85,000</div>
                            </div>
                            <a href="<?php echo e(route('login')); ?>" style="background: var(--primary); color: white; padding: 0.5rem 1.25rem; border-radius: 0.5rem; font-weight: 600; font-size: 0.875rem;">Explore →</a>
                        </div>
                    </div>
                </div>
            </div>

            <div style="text-align: center; margin-top: 3rem;">
                <a href="<?php echo e(route('login')); ?>" class="btn-primary" style="padding: 1rem 3rem;">View All Expeditions →</a>
            </div>
        </div>
    </section>

    <!-- PRICING SECTION -->
    <section id="pricing" style="padding: 6rem 1rem; background: var(--gray-50);">
        <div class="max-w-7xl mx-auto">
            <div style="text-align: center; margin-bottom: 4rem;">
                <span style="color: var(--accent); font-weight: 600; text-transform: uppercase; letter-spacing: 2px; font-size: 0.875rem;">Membership Plans</span>
                <h2 class="section-title" style="margin-top: 0.5rem;">Choose Your Adventure Level</h2>
                <p class="section-subtitle">Flexible membership options designed for every type of mountain enthusiast</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Basic Plan -->
                <div class="feature-card bg-white rounded-2xl p-8 shadow-lg text-center">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🏕️</div>
                    <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">Basic</h3>
                    <p style="color: var(--gray-600); margin-bottom: 1.5rem;">Perfect for beginners</p>
                    <div style="margin-bottom: 1.5rem;">
                        <span style="font-size: 3rem; font-weight: 800; color: var(--primary);">PKR 1,000</span>
                        <span style="color: var(--gray-600);">/month</span>
                    </div>
                    <ul style="text-align: left; margin-bottom: 2rem; space-y: 0.75rem;">
                        <li style="padding: 0.5rem 0; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; gap: 0.5rem;">
                            <span style="color: var(--secondary);">✓</span> Community Access
                        </li>
                        <li style="padding: 0.5rem 0; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; gap: 0.5rem;">
                            <span style="color: var(--secondary);">✓</span> Marketplace Access
                        </li>
                        <li style="padding: 0.5rem 0; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; gap: 0.5rem;">
                            <span style="color: var(--secondary);">✓</span> Event Discounts (5%)
                        </li>
                        <li style="padding: 0.5rem 0; display: flex; align-items: center; gap: 0.5rem; color: var(--gray-400);">
                            <span>✗</span> GPS Tracking
                        </li>
                    </ul>
                    <a href="<?php echo e(route('member.register')); ?>" style="display: block; background: var(--gray-100); color: var(--gray-900); padding: 0.875rem 2rem; border-radius: 0.5rem; font-weight: 600; transition: all 0.3s ease;" onmouseover="this.style.background='var(--primary)'; this.style.color='white';" onmouseout="this.style.background='var(--gray-100)'; this.style.color='var(--gray-900)';">
                        Get Started
                    </a>
                </div>

                <!-- Premium Plan (Featured) -->
                <div class="feature-card bg-white rounded-2xl p-8 shadow-2xl text-center relative" style="border: 3px solid var(--primary); transform: scale(1.05);">
                    <div style="position: absolute; top: -1rem; left: 50%; transform: translateX(-50%); background: var(--primary); color: white; padding: 0.25rem 1.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">
                        Most Popular
                    </div>
                    <div style="font-size: 3rem; margin-bottom: 1rem;">⛰️</div>
                    <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">Premium</h3>
                    <p style="color: var(--gray-600); margin-bottom: 1.5rem;">For serious adventurers</p>
                    <div style="margin-bottom: 1.5rem;">
                        <span style="font-size: 3rem; font-weight: 800; color: var(--primary);">PKR 2,500</span>
                        <span style="color: var(--gray-600);">/month</span>
                    </div>
                    <ul style="text-align: left; margin-bottom: 2rem; space-y: 0.75rem;">
                        <li style="padding: 0.5rem 0; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; gap: 0.5rem;">
                            <span style="color: var(--secondary);">✓</span> Everything in Basic
                        </li>
                        <li style="padding: 0.5rem 0; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; gap: 0.5rem;">
                            <span style="color: var(--secondary);">✓</span> GPS & Offline Maps
                        </li>
                        <li style="padding: 0.5rem 0; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; gap: 0.5rem;">
                            <span style="color: var(--secondary);">✓</span> SOS Emergency System
                        </li>
                        <li style="padding: 0.5rem 0; display: flex; align-items: center; gap: 0.5rem;">
                            <span style="color: var(--secondary);">✓</span> Event Discounts (15%)
                        </li>
                    </ul>
                    <a href="<?php echo e(route('member.register')); ?>" class="btn-primary" style="display: block; width: 100%;">
                        Get Premium
                    </a>
                </div>

                <!-- Elite Plan -->
                <div class="feature-card bg-white rounded-2xl p-8 shadow-lg text-center">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🏔️</div>
                    <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">Elite</h3>
                    <p style="color: var(--gray-600); margin-bottom: 1.5rem;">For expedition leaders</p>
                    <div style="margin-bottom: 1.5rem;">
                        <span style="font-size: 3rem; font-weight: 800; color: var(--primary);">PKR 5,000</span>
                        <span style="color: var(--gray-600);">/month</span>
                    </div>
                    <ul style="text-align: left; margin-bottom: 2rem; space-y: 0.75rem;">
                        <li style="padding: 0.5rem 0; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; gap: 0.5rem;">
                            <span style="color: var(--secondary);">✓</span> Everything in Premium
                        </li>
                        <li style="padding: 0.5rem 0; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; gap: 0.5rem;">
                            <span style="color: var(--secondary);">✓</span> Priority Support 24/7
                        </li>
                        <li style="padding: 0.5rem 0; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; gap: 0.5rem;">
                            <span style="color: var(--secondary);">✓</span> Exclusive Content
                        </li>
                        <li style="padding: 0.5rem 0; display: flex; align-items: center; gap: 0.5rem;">
                            <span style="color: var(--secondary);">✓</span> Free Gear Rental
                        </li>
                    </ul>
                    <a href="<?php echo e(route('member.register')); ?>" style="display: block; background: var(--gray-100); color: var(--gray-900); padding: 0.875rem 2rem; border-radius: 0.5rem; font-weight: 600; transition: all 0.3s ease;" onmouseover="this.style.background='var(--primary)'; this.style.color='white';" onmouseout="this.style.background='var(--gray-100)'; this.style.color='var(--gray-900)';">
                        Go Elite
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- TESTIMONIALS SECTION -->
    <section id="testimonials" style="padding: 6rem 1rem; background: white;">
        <div class="max-w-7xl mx-auto">
            <div style="text-align: center; margin-bottom: 4rem;">
                <span style="color: var(--accent); font-weight: 600; text-transform: uppercase; letter-spacing: 2px; font-size: 0.875rem;">Testimonials</span>
                <h2 class="section-title" style="margin-top: 0.5rem;">What Our Members Say</h2>
                <p class="section-subtitle">Real stories from real adventurers who trusted Pak Alpine</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="feature-card bg-white rounded-2xl p-8 shadow-lg" style="border: 1px solid #e5e7eb;">
                    <div style="display: flex; gap: 0.25rem; margin-bottom: 1rem;">
                        <span style="color: #fbbf24; font-size: 1.25rem;">★</span>
                        <span style="color: #fbbf24; font-size: 1.25rem;">★</span>
                        <span style="color: #fbbf24; font-size: 1.25rem;">★</span>
                        <span style="color: #fbbf24; font-size: 1.25rem;">★</span>
                        <span style="color: #fbbf24; font-size: 1.25rem;">★</span>
                    </div>
                    <p style="color: var(--gray-600); line-height: 1.7; margin-bottom: 1.5rem; font-style: italic;">
                        "The K2 Base Camp expedition was life-changing. The guides were professional, the planning was meticulous, and the community support was incredible."
                    </p>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">AK</div>
                        <div>
                            <div style="font-weight: 700; color: var(--gray-900);">Ahmed Khan</div>
                            <div style="font-size: 0.875rem; color: var(--gray-600);">Premium Member</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="feature-card bg-white rounded-2xl p-8 shadow-lg" style="border: 1px solid #e5e7eb;">
                    <div style="display: flex; gap: 0.25rem; margin-bottom: 1rem;">
                        <span style="color: #fbbf24; font-size: 1.25rem;">★</span>
                        <span style="color: #fbbf24; font-size: 1.25rem;">★</span>
                        <span style="color: #fbbf24; font-size: 1.25rem;">★</span>
                        <span style="color: #fbbf24; font-size: 1.25rem;">★</span>
                        <span style="color: #fbbf24; font-size: 1.25rem;">★</span>
                    </div>
                    <p style="color: var(--gray-600); line-height: 1.7; margin-bottom: 1.5rem; font-style: italic;">
                        "As a beginner, I was nervous about my first trek. The Pak Alpine team made me feel safe and confident. The GPS tracking feature was a lifesaver!"
                    </p>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--secondary) 0%, #1f6048 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">SF</div>
                        <div>
                            <div style="font-weight: 700; color: var(--gray-900);">Sarah Fatima</div>
                            <div style="font-size: 0.875rem; color: var(--gray-600);">Elite Member</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="feature-card bg-white rounded-2xl p-8 shadow-lg" style="border: 1px solid #e5e7eb;">
                    <div style="display: flex; gap: 0.25rem; margin-bottom: 1rem;">
                        <span style="color: #fbbf24; font-size: 1.25rem;">★</span>
                        <span style="color: #fbbf24; font-size: 1.25rem;">★</span>
                        <span style="color: #fbbf24; font-size: 1.25rem;">★</span>
                        <span style="color: #fbbf24; font-size: 1.25rem;">★</span>
                        <span style="color: #fbbf24; font-size: 1.25rem;">★</span>
                    </div>
                    <p style="color: var(--gray-600); line-height: 1.7; margin-bottom: 1.5rem; font-style: italic;">
                        "The marketplace saved me thousands on quality gear. Found an amazing tent and climbing equipment at half the retail price. Highly recommend!"
                    </p>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--accent) 0%, #b45309 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">MR</div>
                        <div>
                            <div style="font-weight: 700; color: var(--gray-900);">Muhammad Raza</div>
                            <div style="font-size: 0.875rem; color: var(--gray-600);">Basic Member</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA SECTION -->
    <section class="hero-gradient" style="padding: 5rem 1rem;">
        <div class="max-w-4xl mx-auto text-center">
            <h2 style="font-size: 2.5rem; font-weight: 700; color: white; margin-bottom: 1rem;">Ready to Start Your Adventure?</h2>
            <p style="font-size: 1.25rem; color: rgba(255,255,255,0.9); margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">
                Join thousands of climbers who trust Pak Alpine for their mountain adventures. Your next peak awaits!
            </p>
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="<?php echo e(route('member.register')); ?>" style="background: white; color: var(--primary-dark); padding: 1rem 2.5rem; border-radius: 0.5rem; font-weight: 700; font-size: 1.125rem; transition: all 0.3s ease; display: inline-block;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.2)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                    Create Free Account →
                </a>
                <a href="<?php echo e(route('login')); ?>" class="btn-outline-white" style="padding: 1rem 2.5rem; font-size: 1.125rem;">
                    Sign In
                </a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer style="background: var(--primary-dark); padding: 4rem 1rem 2rem; color: white;">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Brand -->
                <div>
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                        <span style="font-size: 2.5rem;">🏔️</span>
                        <div>
                            <h3 style="font-size: 1.25rem; font-weight: 700;">Pak Alpine</h3>
                            <p style="font-size: 0.75rem; opacity: 0.8;">Mountain Adventures</p>
                        </div>
                    </div>
                    <p style="font-size: 0.875rem; opacity: 0.8; line-height: 1.6;">
                        Pakistan's premier mountain adventure platform connecting climbers with expeditions, community, and gear.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 style="font-weight: 700; margin-bottom: 1rem;">Quick Links</h4>
                    <ul style="space-y: 0.5rem; font-size: 0.875rem; opacity: 0.8;">
                        <li style="margin-bottom: 0.5rem;"><a href="#features" class="hover:text-amber-300 transition">Features</a></li>
                        <li style="margin-bottom: 0.5rem;"><a href="#expeditions" class="hover:text-amber-300 transition">Expeditions</a></li>
                        <li style="margin-bottom: 0.5rem;"><a href="#pricing" class="hover:text-amber-300 transition">Pricing</a></li>
                        <li style="margin-bottom: 0.5rem;"><a href="#testimonials" class="hover:text-amber-300 transition">Reviews</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h4 style="font-weight: 700; margin-bottom: 1rem;">Support</h4>
                    <ul style="space-y: 0.5rem; font-size: 0.875rem; opacity: 0.8;">
                        <li style="margin-bottom: 0.5rem;"><a href="#" class="hover:text-amber-300 transition">Help Center</a></li>
                        <li style="margin-bottom: 0.5rem;"><a href="#" class="hover:text-amber-300 transition">Safety Guidelines</a></li>
                        <li style="margin-bottom: 0.5rem;"><a href="#" class="hover:text-amber-300 transition">Terms of Service</a></li>
                        <li style="margin-bottom: 0.5rem;"><a href="#" class="hover:text-amber-300 transition">Privacy Policy</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 style="font-weight: 700; margin-bottom: 1rem;">Contact Us</h4>
                    <ul style="space-y: 0.5rem; font-size: 0.875rem; opacity: 0.8;">
                        <li style="margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                            <span>📞</span> +92 51 1234567
                        </li>
                        <li style="margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                            <span>✉️</span> info@pakalpine.com
                        </li>
                        <li style="margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                            <span>📍</span> Islamabad, Pakistan
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Trust Badges -->
            <div style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 2rem; margin-top: 2rem;">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div style="text-align: center; padding: 1rem; background: rgba(255,255,255,0.05); border-radius: 0.5rem;">
                        <span style="font-size: 1.5rem;">🔒</span>
                        <p style="font-size: 0.75rem; margin-top: 0.5rem;">100% Secure</p>
                    </div>
                    <div style="text-align: center; padding: 1rem; background: rgba(255,255,255,0.05); border-radius: 0.5rem;">
                        <span style="font-size: 1.5rem;">✅</span>
                        <p style="font-size: 0.75rem; margin-top: 0.5rem;">Verified Guides</p>
                    </div>
                    <div style="text-align: center; padding: 1rem; background: rgba(255,255,255,0.05); border-radius: 0.5rem;">
                        <span style="font-size: 1.5rem;">💳</span>
                        <p style="font-size: 0.75rem; margin-top: 0.5rem;">Easy Payments</p>
                    </div>
                    <div style="text-align: center; padding: 1rem; background: rgba(255,255,255,0.05); border-radius: 0.5rem;">
                        <span style="font-size: 1.5rem;">📞</span>
                        <p style="font-size: 0.75rem; margin-top: 0.5rem;">24/7 Support</p>
                    </div>
                </div>

                <!-- Copyright -->
                <div style="text-align: center; font-size: 0.875rem; opacity: 0.6;">
                    <p>© 2025 Pak Alpine. All rights reserved. Made with ❤️ in Pakistan</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
<?php /**PATH D:\xampp\htdocs\alpine\resources\views/landing.blade.php ENDPATH**/ ?>
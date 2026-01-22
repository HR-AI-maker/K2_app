@extends('layouts.app')

@section('title', 'Welcome to Pak Alpine - Mountain Adventure Platform')

@section('content')
<!-- HERO SECTION - Premium Alpine Experience -->
<section style="background: linear-gradient(135deg, #1e5f8a 0%, #0f3d56 100%); position: relative; overflow: hidden; min-height: 600px; display: flex; align-items: center;">
    <!-- Animated background elements -->
    <div style="position: absolute; inset: 0; opacity: 0.08;">
        <div style="position: absolute; width: 300px; height: 300px; background: radial-gradient(circle, white 0%, transparent 70%); top: -100px; left: -100px;"></div>
        <div style="position: absolute; width: 200px; height: 200px; background: radial-gradient(circle, white 0%, transparent 70%); bottom: -50px; right: -50px;"></div>
    </div>

    <div class="max-w-6xl mx-auto px-4 py-32 relative z-10 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left: Hero Content -->
            <div>
                <div style="display: inline-block; background: rgba(255,255,255,0.1); padding: 0.5rem 1rem; border-radius: 9999px; margin-bottom: 1rem; backdrop-filter: blur(10px);">
                    <span class="text-white text-sm font-semibold">🏔️ Alpine Adventures Await</span>
                </div>
                <h1 style="font-size: 3.5rem; font-weight: 700; color: white; margin-bottom: 1.5rem; line-height: 1.2;">
                    Escape Ordinary.<br/>Embrace the Peak.
                </h1>
                <p style="font-size: 1.125rem; color: rgba(255,255,255,0.9); margin-bottom: 2rem; max-width: 500px; line-height: 1.6;">
                    Connect with expert climbers, explore breathtaking expeditions, and experience premium mountain adventures on Pakistan's most trusted platform.
                </p>

                <!-- Benefits -->
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 2rem; font-size: 0.875rem; color: white;">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span style="font-size: 1.25rem;">✓</span>
                        <span>10K+ Members</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span style="font-size: 1.25rem;">✓</span>
                        <span>50+ Expeditions</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span style="font-size: 1.25rem;">✓</span>
                        <span>100% Verified</span>
                    </div>
                </div>

                <!-- CTAs -->
                @if (!auth()->check())
                    <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                        <a href="{{ route('member.register') }}" class="btn btn-primary" style="padding: 1rem 2rem; font-size: 1rem;">
                            Get Started Now →
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline" style="padding: 1rem 2rem; font-size: 1rem; background: rgba(255,255,255,0.1); color: white; border: 2px solid white;">
                            Sign In
                        </a>
                    </div>
                @else
                    <a href="{{ route('dashboard') }}" class="btn btn-primary" style="padding: 1rem 2rem; font-size: 1rem;">
                        Go to Dashboard →
                    </a>
                @endif
            </div>

            <!-- Right: Feature Grid -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); padding: 2rem; border-radius: 1rem; border: 1px solid rgba(255,255,255,0.2); text-align: center; color: white;">
                    <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">🏔️</div>
                    <h4 style="font-weight: 600; margin-bottom: 0.5rem;">Explore</h4>
                    <p style="font-size: 0.875rem; opacity: 0.9;">Discover peaks & trails</p>
                </div>

                <div style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); padding: 2rem; border-radius: 1rem; border: 1px solid rgba(255,255,255,0.2); text-align: center; color: white;">
                    <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">👥</div>
                    <h4 style="font-weight: 600; margin-bottom: 0.5rem;">Connect</h4>
                    <p style="font-size: 0.875rem; opacity: 0.9;">Join the community</p>
                </div>

                <div style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); padding: 2rem; border-radius: 1rem; border: 1px solid rgba(255,255,255,0.2); text-align: center; color: white;">
                    <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">📚</div>
                    <h4 style="font-weight: 600; margin-bottom: 0.5rem;">Learn</h4>
                    <p style="font-size: 0.875rem; opacity: 0.9;">Expert guidance & training</p>
                </div>

                <div style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); padding: 2rem; border-radius: 1rem; border: 1px solid rgba(255,255,255,0.2); text-align: center; color: white;">
                    <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">🏆</div>
                    <h4 style="font-weight: 600; margin-bottom: 0.5rem;">Achieve</h4>
                    <p style="font-size: 0.875rem; opacity: 0.9;">Earn achievements & badges</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- WHY CHOOSE US - Premium Features -->
<section style="padding: 6rem 1rem; background-color: #ffffff;">
    <div class="max-w-6xl mx-auto">
        <div style="text-align: center; margin-bottom: 4rem;">
            <h2 style="font-size: 2.5rem; font-weight: 700; color: var(--primary-dark); margin-bottom: 1rem;">Why Choose Alpine?</h2>
            <p style="font-size: 1.125rem; color: var(--gray-600); max-width: 600px; margin: 0 auto;">Everything you need for unforgettable mountain adventures, from planning to execution</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
            <!-- Feature 1 -->
            <div class="card card-featured" style="text-align: center;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🗺️</div>
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.75rem; color: var(--primary-dark);">Expert Planning</h3>
                <p style="color: var(--gray-600); font-size: 0.95rem; line-height: 1.6;">Detailed expeditions crafted by certified mountaineers with years of experience</p>
            </div>

            <!-- Feature 2 -->
            <div class="card card-featured" style="text-align: center;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🛡️</div>
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.75rem; color: var(--primary-dark);">Safety First</h3>
                <p style="color: var(--gray-600); font-size: 0.95rem; line-height: 1.6;">GPS tracking, SOS alerts, and comprehensive insurance for peace of mind</p>
            </div>

            <!-- Feature 3 -->
            <div class="card card-featured" style="text-align: center;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">💎</div>
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.75rem; color: var(--primary-dark);">Premium Quality</h3>
                <p style="color: var(--gray-600); font-size: 0.95rem; line-height: 1.6;">Curated experiences with luxury accommodations and top-tier equipment</p>
            </div>

            <!-- Feature 4 -->
            <div class="card card-featured" style="text-align: center;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🤝</div>
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.75rem; color: var(--primary-dark);">Community</h3>
                <p style="color: var(--gray-600); font-size: 0.95rem; line-height: 1.6;">Connect with 10K+ passionate climbers and adventure enthusiasts</p>
            </div>

            <!-- Feature 5 -->
            <div class="card card-featured" style="text-align: center;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🏪</div>
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.75rem; color: var(--primary-dark);">Marketplace</h3>
                <p style="color: var(--gray-600); font-size: 0.95rem; line-height: 1.6;">Premium gear, services, and accommodations from verified vendors</p>
            </div>

            <!-- Feature 6 -->
            <div class="card card-featured" style="text-align: center;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🎓</div>
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.75rem; color: var(--primary-dark);">Training</h3>
                <p style="color: var(--gray-600); font-size: 0.95rem; line-height: 1.6;">Certifications and workshops from mountaineering experts</p>
            </div>
        </div>
    </div>
</section>

<!-- EXPEDITIONS SHOWCASE -->
<section style="padding: 6rem 1rem; background-color: var(--primary-light);">
    <div class="max-w-6xl mx-auto">
        <div style="text-align: center; margin-bottom: 4rem;">
            <h2 style="font-size: 2.5rem; font-weight: 700; color: var(--primary-dark); margin-bottom: 1rem;">Featured Expeditions</h2>
            <p style="font-size: 1.125rem; color: var(--gray-600); max-width: 600px; margin: 0 auto;">Explore our curated mountain adventures</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem;">
            @for ($i = 1; $i <= 3; $i++)
                <div class="card" style="overflow: hidden;">
                    <div style="width: 100%; height: 200px; background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); display: flex; align-items: center; justify-content: center; font-size: 3rem;">
                        @if ($i === 1) 🏔️ @elseif ($i === 2) 🗻 @else ⛰️ @endif
                    </div>
                    <div style="padding: 1.5rem;">
                        <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem;">
                            @if ($i === 1) K2 Base Camp @elseif ($i === 2) Nanga Parbat Trek @else Hunza Valley Explorer @endif
                        </h3>
                        <p style="color: var(--gray-600); font-size: 0.95rem; margin-bottom: 1rem;">
                            @if ($i === 1) Challenge yourself on the world's second highest peak @elseif ($i === 2) Experience the legendary 9th highest mountain @else Discover pristine mountain valleys and cultural gems @endif
                        </p>
                        <a href="{{ route('expeditions.index') }}" class="btn btn-primary" style="width: 100%; text-align: center;">Explore →</a>
                    </div>
                </div>
            @endfor
        </div>

        <div style="text-align: center; margin-top: 3rem;">
            <a href="{{ route('expeditions.index') }}" class="btn btn-primary btn-lg">
                View All Expeditions →
            </a>
        </div>
    </div>
</section>

<!-- TESTIMONIALS -->
<section style="padding: 6rem 1rem; background-color: #ffffff;">
    <div class="max-w-6xl mx-auto">
        <div style="text-align: center; margin-bottom: 4rem;">
            <h2 style="font-size: 2.5rem; font-weight: 700; color: var(--primary-dark); margin-bottom: 1rem;">What Our Members Say</h2>
            <p style="font-size: 1.125rem; color: var(--gray-600);">Real experiences from our growing community</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            @for ($i = 1; $i <= 3; $i++)
                <div style="background: var(--primary-light); padding: 2rem; border-radius: 1rem; border-left: 4px solid var(--primary);">
                    <div style="color: var(--accent); font-size: 1.5rem; margin-bottom: 1rem;">★★★★★</div>
                    <p style="color: var(--gray-700); margin-bottom: 1.5rem; line-height: 1.6;">
                        "Alpine transformed my mountain climbing experience. The community support, expert guidance, and safety features are unmatched!"
                    </p>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700;">
                            @if ($i === 1) AH @elseif ($i === 2) MK @else SA @endif
                        </div>
                        <div>
                            <p style="font-weight: 600; color: var(--gray-900);">
                                @if ($i === 1) Ahmed Hassan @elseif ($i === 2) Maria Khan @else Sara Ali @endif
                            </p>
                            <p style="color: var(--gray-600); font-size: 0.875rem;">
                                @if ($i === 1) Professional Climber @elseif ($i === 2) Adventure Enthusiast @else Trekking Guide @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>

<!-- CTA SECTION -->
<section style="background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); padding: 4rem 1rem; text-align: center; color: white;">
    <div class="max-w-4xl mx-auto">
        <h2 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem;">Ready to Start Your Adventure?</h2>
        <p style="font-size: 1.125rem; margin-bottom: 2rem; opacity: 0.95;">Join thousands of climbers discovering Pakistan's most stunning peaks</p>

        @if (!auth()->check())
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="{{ route('member.register') }}" class="btn btn-primary" style="padding: 1rem 2rem; font-size: 1rem; background: white; color: var(--primary);">
                    Get Started Now
                </a>
                <a href="{{ route('login') }}" class="btn" style="padding: 1rem 2rem; font-size: 1rem; background: rgba(255,255,255,0.2); color: white; border: 2px solid white;">
                    Sign In
                </a>
            </div>
        @else
            <a href="{{ route('dashboard') }}" class="btn btn-primary" style="padding: 1rem 2rem; font-size: 1rem; background: white; color: var(--primary);">
                Go to Dashboard
            </a>
        @endif
    </div>
</section>

<!-- FOOTER TRUST SECTION -->
<section style="background-color: var(--gray-50); padding: 3rem 1rem; border-top: 1px solid var(--gray-200);">
    <div class="max-w-6xl mx-auto text-center">
        <p style="color: var(--gray-700); margin-bottom: 2rem; font-weight: 600;">Trusted by Mountaineers & Adventure Enthusiasts Across Pakistan</p>
        <div style="display: flex; justify-content: center; gap: 2rem; flex-wrap: wrap; font-size: 0.95rem; color: var(--gray-600);">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: var(--success); font-weight: bold;">✓</span> 100% Secure
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: var(--success); font-weight: bold;">✓</span> Free Account
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: var(--success); font-weight: bold;">✓</span> No Hidden Fees
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: var(--success); font-weight: bold;">✓</span> 24/7 Support
            </div>
        </div>
    </div>
</section>
@endsection

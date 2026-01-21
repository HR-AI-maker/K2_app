<!-- UI change only – no logic modified -->
<footer style="background: linear-gradient(135deg, var(--primary-dark) 0%, #0a2236 100%); color: white; margin-top: 4rem;">
    <div class="max-w-6xl mx-auto px-4 py-16">
        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-8 mb-12">
            <!-- Brand Section -->
            <div>
                <div class="text-2xl font-bold mb-4 flex items-center gap-2">
                    🏔️ Pak Alpine
                </div>
                <p class="text-gray-300 text-sm mb-6">
                    Digital Ecosystem for the Alpine Club of Pakistan. Connect, train, explore, and share your mountain adventures.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="text-gray-300 hover:text-white transition" title="Facebook">f</a>
                    <a href="#" class="text-gray-300 hover:text-white transition" title="Twitter">𝕏</a>
                    <a href="#" class="text-gray-300 hover:text-white transition" title="Instagram">📷</a>
                </div>
            </div>

            <!-- Platform Links -->
            <div>
                <h4 class="font-bold mb-4 text-white">Platform</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white text-sm transition">Home</a></li>
                    <li><a href="{{ route('expeditions.index') }}" class="text-gray-300 hover:text-white text-sm transition">Expeditions</a></li>
                    <li><a href="{{ route('events.index') }}" class="text-gray-300 hover:text-white text-sm transition">Events</a></li>
                    <li><a href="{{ route('community.index') }}" class="text-gray-300 hover:text-white text-sm transition">Community</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div>
                <h4 class="font-bold mb-4 text-white">Services</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('marketplace.index') }}" class="text-gray-300 hover:text-white text-sm transition">Marketplace</a></li>
                    <li><a href="{{ route('vendors.index') }}" class="text-gray-300 hover:text-white text-sm transition">Vendors</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white text-sm transition">Training</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white text-sm transition">Safety Tools</a></li>
                </ul>
            </div>

            <!-- Support -->
            <div>
                <h4 class="font-bold mb-4 text-white">Support</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-300 hover:text-white text-sm transition">Help Center</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white text-sm transition">Contact Us</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white text-sm transition">Terms of Service</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white text-sm transition">Privacy Policy</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="font-bold mb-4 text-white">Contact</h4>
                <div class="space-y-3 text-sm text-gray-300">
                    <div>
                        <div class="font-semibold text-white mb-1">Email</div>
                        <a href="mailto:info@pakalpin.local" class="hover:text-white transition">info@pakalpin.local</a>
                    </div>
                    <div>
                        <div class="font-semibold text-white mb-1">Location</div>
                        <p>Pakistan</p>
                    </div>
                    <div>
                        <div class="font-semibold text-white mb-1">Support</div>
                        <p>24/7 Available</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div style="border-top: 1px solid rgba(255, 255, 255, 0.1); padding-top: 2rem;"></div>

        <!-- Bottom Footer -->
        <div class="flex flex-col sm:flex-row items-center justify-between text-sm text-gray-300">
            <div>
                <p>&copy; {{ now()->year }} Alpine Club of Pakistan. All rights reserved.</p>
            </div>
            <div class="flex gap-6 mt-4 sm:mt-0">
                <a href="#" class="hover:text-white transition">Terms</a>
                <a href="#" class="hover:text-white transition">Privacy</a>
                <a href="#" class="hover:text-white transition">Cookies</a>
            </div>
        </div>
    </div>
</footer>

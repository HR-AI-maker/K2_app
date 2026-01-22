

<?php $__env->startSection('title', 'Vendor Directory'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-gray-50 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-green-600 to-green-800 text-white py-12">
        <div class="max-w-6xl mx-auto px-4">
            <h1 class="text-4xl font-bold mb-2">Vendor Directory</h1>
            <p class="text-green-100">Find trusted guides, transportation, lodging, and equipment providers</p>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="max-w-6xl mx-auto px-4 py-8">
        <form method="GET" class="bg-white rounded-lg shadow p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <input
                        type="text"
                        name="search"
                        value="<?php echo e(request('search')); ?>"
                        placeholder="Business name, contact..."
                        class="input"
                    >
                </div>

                <!-- Business Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                    <select name="business_type" class="input">
                        <option value="">All Types</option>
                        <option value="guide" <?php echo e($currentBusinessType === 'guide' ? 'selected' : ''); ?>>Guide</option>
                        <option value="transport" <?php echo e($currentBusinessType === 'transport' ? 'selected' : ''); ?>>Transport</option>
                        <option value="lodging" <?php echo e($currentBusinessType === 'lodging' ? 'selected' : ''); ?>>Lodging</option>
                        <option value="equipment" <?php echo e($currentBusinessType === 'equipment' ? 'selected' : ''); ?>>Equipment</option>
                        <option value="other" <?php echo e($currentBusinessType === 'other' ? 'selected' : ''); ?>>Other</option>
                    </select>
                </div>

                <!-- Region -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Region</label>
                    <select name="region" class="input">
                        <option value="">All Regions</option>
                        <?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($region); ?>" <?php echo e($currentRegion === $region ? 'selected' : ''); ?>>
                                <?php echo e($region); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Sort -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sort</label>
                    <select name="sort_by" class="input">
                        <option value="rating" <?php echo e(request('sort_by') === 'rating' ? 'selected' : ''); ?>>Highest Rated</option>
                        <option value="bookings" <?php echo e(request('sort_by') === 'bookings' ? 'selected' : ''); ?>>Most Booked</option>
                        <option value="name" <?php echo e(request('sort_by') === 'name' ? 'selected' : ''); ?>>Alphabetical</option>
                        <option value="recent" <?php echo e(request('sort_by') === 'recent' ? 'selected' : ''); ?>>Recently Verified</option>
                    </select>
                </div>

                <!-- Submit -->
                <div class="flex items-end">
                    <button type="submit" class="btn-primary w-full">
                        Apply Filters
                    </button>
                </div>
            </div>
        </form>

        <!-- Vendors Grid -->
        <?php if($vendors->count() > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('vendors.show', $vendor)); ?>" class="card hover:shadow-lg transition-shadow hover:scale-105">
                        <!-- Type Badge & Certification -->
                        <div class="flex justify-between items-start mb-3">
                            <span class="badge
                                <?php if($vendor->business_type === 'guide'): ?> bg-blue-100 text-blue-800
                                <?php elseif($vendor->business_type === 'transport'): ?> bg-purple-100 text-purple-800
                                <?php elseif($vendor->business_type === 'lodging'): ?> bg-orange-100 text-orange-800
                                <?php elseif($vendor->business_type === 'equipment'): ?> bg-green-100 text-green-800
                                <?php else: ?> bg-gray-100 text-gray-800
                                <?php endif; ?>">
                                <?php if($vendor->business_type === 'guide'): ?> 👨‍🏫 Guide
                                <?php elseif($vendor->business_type === 'transport'): ?> 🚗 Transport
                                <?php elseif($vendor->business_type === 'lodging'): ?> 🏨 Lodging
                                <?php elseif($vendor->business_type === 'equipment'): ?> 🎒 Equipment
                                <?php else: ?> 🏪 <?php echo e(ucfirst($vendor->business_type)); ?>

                                <?php endif; ?>
                            </span>
                            <?php if($vendor->is_certified): ?>
                                <span class="text-yellow-500 text-lg">⭐</span>
                            <?php endif; ?>
                        </div>

                        <!-- Business Name -->
                        <h3 class="text-lg font-bold mb-2 line-clamp-2">
                            <?php echo e($vendor->business_name); ?>

                        </h3>

                        <!-- Contact Info -->
                        <p class="text-sm text-gray-600 mb-2">
                            👤 <?php echo e($vendor->contact_person); ?>

                        </p>

                        <!-- Description -->
                        <p class="text-sm text-gray-700 mb-3 line-clamp-2">
                            <?php echo e($vendor->description); ?>

                        </p>

                        <!-- Location -->
                        <p class="text-sm text-gray-600 mb-3">
                            📍 <?php echo e($vendor->address); ?>

                        </p>

                        <!-- Rating & Bookings -->
                        <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                            <div>
                                <div class="flex items-center gap-1">
                                    <?php for($i = 0; $i < 5; $i++): ?>
                                        <?php if($i < floor($vendor->rating ?? 0)): ?>
                                            <span class="text-yellow-400">★</span>
                                        <?php elseif($i < $vendor->rating ?? 0): ?>
                                            <span class="text-yellow-300">✧</span>
                                        <?php else: ?>
                                            <span class="text-gray-300">☆</span>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                                <p class="text-xs text-gray-600"><?php echo e($vendor->rating ? number_format($vendor->rating, 1) : 'No rating'); ?></p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-blue-600"><?php echo e($vendor->total_bookings ?? 0); ?></p>
                                <p class="text-xs text-gray-600">bookings</p>
                            </div>
                        </div>

                        <!-- Certification Badge -->
                        <?php if($vendor->is_certified): ?>
                            <div class="mt-3 p-2 bg-yellow-50 rounded text-xs text-yellow-800 font-semibold text-center">
                                ✓ Certified Vendor
                            </div>
                        <?php endif; ?>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Pagination -->
            <div class="mb-8">
                <?php echo e($vendors->links()); ?>

            </div>
        <?php else: ?>
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <p class="text-6xl mb-4">🏪</p>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No Vendors Found</h3>
                <p class="text-gray-600 mb-6">Try adjusting your filters to see available vendors</p>
                <a href="<?php echo e(route('vendors.index')); ?>" class="btn-primary">
                    View All Vendors
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.member', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\alpine\resources\views/vendors/index.blade.php ENDPATH**/ ?>
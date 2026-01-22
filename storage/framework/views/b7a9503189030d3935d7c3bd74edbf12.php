<a href="<?php echo e(route('marketplace.product.show', $product)); ?>" class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden">
    <!-- Product Image -->
    <div class="relative w-full h-48 bg-gray-200">
        <?php if($product->images && count($product->images) > 0): ?>
            <img src="<?php echo e(asset('storage/' . $product->images[0])); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-full object-cover">
        <?php else: ?>
            <div class="w-full h-full flex items-center justify-center text-gray-400">
                <span>No image</span>
            </div>
        <?php endif; ?>
    </div>

    <!-- Product Info -->
    <div class="p-4">
        <h3 class="font-semibold text-gray-900 truncate"><?php echo e($product->name); ?></h3>

        <!-- Vendor Name -->
        <p class="text-sm text-gray-600 mt-1"><?php echo e($product->vendor->business_name); ?></p>

        <!-- Category and Views -->
        <div class="flex justify-between items-center mt-2 text-xs text-gray-500">
            <span class="inline-block bg-gray-100 px-2 py-1 rounded"><?php echo e(ucfirst($product->category)); ?></span>
            <span><?php echo e($product->views_count); ?> views</span>
        </div>

        <!-- Price -->
        <div class="mt-4 pt-4 border-t border-gray-100">
            <p class="text-lg font-bold text-blue-600">Rs. <?php echo e(number_format($product->price, 0)); ?></p>
            <p class="text-xs text-gray-500 mt-1">
                <?php if($product->is_unlimited_stock): ?>
                    In Stock
                <?php elseif($product->stock_quantity > 0): ?>
                    <?php echo e($product->stock_quantity); ?> available
                <?php else: ?>
                    Out of Stock
                <?php endif; ?>
            </p>
        </div>

        <!-- Add to Cart Button -->
        <?php if(auth()->check() && $product->isAvailable()): ?>
            <button onclick="addToCart(event, <?php echo e($product->id); ?>)" class="w-full mt-3 px-3 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition-colors">
                Add to Cart
            </button>
        <?php elseif(!auth()->check()): ?>
            <a href="<?php echo e(route('login')); ?>" class="block w-full mt-3 px-3 py-2 bg-gray-300 text-gray-700 text-sm rounded text-center">
                Sign in to Buy
            </a>
        <?php else: ?>
            <button disabled class="w-full mt-3 px-3 py-2 bg-gray-300 text-gray-500 text-sm rounded cursor-not-allowed">
                Out of Stock
            </button>
        <?php endif; ?>
    </div>
</a>
<?php /**PATH D:\xampp\htdocs\alpine\resources\views/marketplace/partials/product-card.blade.php ENDPATH**/ ?>
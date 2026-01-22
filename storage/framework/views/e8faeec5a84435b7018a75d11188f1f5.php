

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="<?php echo e(route('marketplace.index')); ?>" class="text-blue-600 hover:text-blue-800 mb-6">&larr; Back to Marketplace</a>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
                <!-- Product Images -->
                <div>
                    <?php if($product->images && count($product->images) > 0): ?>
                        <div class="bg-gray-200 rounded-lg overflow-hidden h-96 flex items-center justify-center">
                            <img src="<?php echo e(asset('storage/' . $product->images[0])); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-full object-cover">
                        </div>
                        <?php if(count($product->images) > 1): ?>
                            <div class="grid grid-cols-4 gap-2 mt-4">
                                <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <img src="<?php echo e(asset('storage/' . $image)); ?>" alt="<?php echo e($product->name); ?>" class="h-20 rounded cursor-pointer hover:opacity-80 transition-opacity object-cover">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="bg-gray-300 rounded-lg h-96 flex items-center justify-center text-gray-600">
                            <span>No images available</span>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Product Details -->
                <div>
                    <h1 class="text-3xl font-bold text-gray-900"><?php echo e($product->name); ?></h1>

                    <!-- Vendor Info -->
                    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                        <a href="<?php echo e(route('marketplace.vendor', $product->vendor)); ?>" class="text-lg font-semibold text-blue-600 hover:text-blue-800">
                            <?php echo e($product->vendor->business_name); ?>

                        </a>
                        <?php if($product->vendor->is_certified): ?>
                            <p class="text-sm text-green-600 mt-1">✓ Certified Vendor</p>
                        <?php endif; ?>
                    </div>

                    <!-- Category and Stats -->
                    <div class="mt-4 flex gap-4">
                        <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm"><?php echo e(ucfirst($product->category)); ?></span>
                        <span class="text-gray-600 text-sm"><?php echo e($product->views_count); ?> views</span>
                        <span class="text-gray-600 text-sm"><?php echo e($product->sales_count); ?> sold</span>
                    </div>

                    <!-- Price -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <p class="text-4xl font-bold text-blue-600">Rs. <?php echo e(number_format($product->price, 0)); ?></p>
                    </div>

                    <!-- Stock Status -->
                    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                        <?php if($product->is_unlimited_stock): ?>
                            <p class="text-green-600 font-semibold">✓ Always in Stock</p>
                        <?php elseif($product->stock_quantity > 0): ?>
                            <p class="text-green-600 font-semibold">✓ <?php echo e($product->stock_quantity); ?> available</p>
                        <?php else: ?>
                            <p class="text-red-600 font-semibold">✗ Out of Stock</p>
                        <?php endif; ?>
                    </div>

                    <!-- Add to Cart -->
                    <?php if(auth()->check() && $product->isAvailable()): ?>
                        <div class="mt-6">
                            <form id="addToCartForm" class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                                    <input type="number" id="quantity" name="quantity" min="1" value="1" class="w-20 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                                <button type="button" onclick="addToCart(event, <?php echo e($product->id); ?>)" class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-lg font-semibold transition-colors">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    <?php elseif(!auth()->check()): ?>
                        <a href="<?php echo e(route('login')); ?>" class="block w-full mt-6 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-center text-lg font-semibold transition-colors">
                            Sign in to Purchase
                        </a>
                    <?php else: ?>
                        <button disabled class="w-full mt-6 px-6 py-3 bg-gray-300 text-gray-500 rounded-lg text-lg font-semibold cursor-not-allowed">
                            Out of Stock
                        </button>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Description -->
            <div class="border-t border-gray-200 p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Description</h2>
                <p class="text-gray-700 whitespace-pre-wrap"><?php echo e($product->description ?? 'No description available'); ?></p>
            </div>
        </div>
    </div>
</div>

<script>
function addToCart(event, productId) {
    event.preventDefault();
    const quantity = document.getElementById('quantity')?.value || 1;

    fetch('<?php echo e(route("cart.add")); ?>', {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: parseInt(quantity),
        }),
    })
    .then(async response => {
        const contentType = response.headers.get('content-type') || '';
        if (!response.ok) {
            if (contentType.includes('application/json')) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Unable to add product to cart.');
            }
            const text = await response.text();
            throw new Error(text || 'Unable to add product to cart.');
        }
        if (contentType.includes('application/json')) {
            return response.json();
        }
        return { success: true };
    })
    .then(data => {
        if (data.success) {
            window.location.href = '<?php echo e(route("cart.index")); ?>';
            return;
        }
        alert(data.message || 'Unable to add product to cart.');
    })
    .catch(error => {
        console.error('Error:', error);
        alert(error.message || 'Unable to add product to cart.');
    });
}
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.member', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\alpine\resources\views/marketplace/show.blade.php ENDPATH**/ ?>
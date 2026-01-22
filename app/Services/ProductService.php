<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    /**
     * Create a new product
     */
    public function createProduct(Vendor $vendor, array $data): Product
    {
        // Add vendor_id to the data
        $data['vendor_id'] = $vendor->id;
        $data['status'] = 'pending'; // Default status is pending approval

        return Product::create($data);
    }

    /**
     * Update an existing product
     */
    public function updateProduct(Product $product, array $data): Product
    {
        $product->update($data);
        return $product;
    }

    /**
     * Upload product images
     */
    public function uploadProductImages(Product $product, $images)
    {
        $imagePaths = [];

        if (!is_array($images)) {
            $images = [$images];
        }

        foreach ($images as $image) {
            if ($image && $image->isValid()) {
                $path = $image->store('products', 'public');
                $imagePaths[] = $path;
            }
        }

        if (!empty($imagePaths)) {
            $product->update([
                'images' => array_merge($product->images ?? [], $imagePaths)
            ]);
        }

        return $product;
    }

    /**
     * Publish a product
     */
    public function publishProduct(Product $product): Product
    {
        $product->update(['status' => 'published']);
        return $product;
    }

    /**
     * Update product stock
     */
    public function updateStock(Product $product, int $quantity): Product
    {
        if (!$product->is_unlimited_stock) {
            $product->update(['stock_quantity' => $quantity]);
        }
        return $product;
    }

    /**
     * Increment product views
     */
    public function incrementViews(Product $product): Product
    {
        $product->increment('views_count');
        return $product;
    }
}

<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Determine if user can view the product
     */
    public function view(User $user, Product $product): bool
    {
        return true; // Anyone can view published products
    }

    /**
     * Determine if user can update the product
     */
    public function update(User $user, Product $product): bool
    {
        // Allow if user is the vendor who owns this product
        if ($user->isVendor() && $user->managedVendor->id === $product->vendor_id) {
            return true;
        }

        // Allow if user is admin
        if ($user->isAdmin()) {
            return true;
        }

        return false;
    }

    /**
     * Determine if user can delete the product
     */
    public function delete(User $user, Product $product): bool
    {
        // Allow if user is the vendor who owns this product
        if ($user->isVendor() && $user->managedVendor->id === $product->vendor_id) {
            return true;
        }

        // Allow if user is admin
        if ($user->isAdmin()) {
            return true;
        }

        return false;
    }

    /**
     * Determine if user can create products
     */
    public function create(User $user): bool
    {
        // Allow if user is a vendor
        return $user->isVendor();
    }
}

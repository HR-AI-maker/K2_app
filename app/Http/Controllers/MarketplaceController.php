<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MarketplaceController extends Controller
{
    /**
     * Display marketplace listing
     */
    public function index(): View
    {
        $categories = ['equipment', 'clothing', 'guides', 'transport', 'lodging', 'food', 'other'];

        $query = Product::where('status', 'published')->with('vendor');

        if (request('search')) {
            $search = request('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('marketplace.index', compact('categories', 'products'));
    }

    /**
     * Show product by category
     */
    public function category($category): View
    {
        return view('marketplace.category', ['category' => $category]);
    }

    /**
     * Show vendor products
     */
    public function vendor($vendor): View
    {
        return view('marketplace.vendor', ['vendor' => $vendor]);
    }

    /**
     * Show product details
     */
    public function show(Product $product): View
    {
        $product->load('vendor');
        return view('marketplace.show', ['product' => $product]);
    }
}

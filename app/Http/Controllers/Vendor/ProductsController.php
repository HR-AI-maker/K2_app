<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProductsController extends Controller
{
    public function __construct(protected ProductService $productService)
    {
        $this->middleware('vendor');
    }

    public function index(): View
    {
        $products = auth()->user()->managedVendor->products()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('vendor.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = ['equipment', 'clothing', 'guides', 'transport', 'lodging', 'food', 'other'];

        return view('vendor.products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'description' => 'nullable|string|max:5000',
            'category' => 'required|in:equipment,clothing,guides,transport,lodging,food,other',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'is_unlimited_stock' => 'nullable|boolean',
            'images.*' => 'nullable|image|max:5120',
        ]);

        $vendor = auth()->user()->managedVendor;
        $product = $this->productService->createProduct($vendor, $validated);

        if ($request->hasFile('images')) {
            $this->productService->uploadProductImages($product, $request->file('images'));
        }

        return redirect()->route('vendor.products.edit', $product)->with('success', 'Product created successfully');
    }

    public function edit(Product $product): View
    {
        $this->authorize('update', $product);

        $categories = ['equipment', 'clothing', 'guides', 'transport', 'lodging', 'food', 'other'];

        return view('vendor.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $this->authorize('update', $product);

        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'description' => 'nullable|string|max:5000',
            'category' => 'required|in:equipment,clothing,guides,transport,lodging,food,other',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'is_unlimited_stock' => 'nullable|boolean',
            'images.*' => 'nullable|image|max:5120',
        ]);

        $this->productService->updateProduct($product, $validated);

        if ($request->hasFile('images')) {
            $this->productService->uploadProductImages($product, $request->file('images'));
        }

        return redirect()->route('vendor.products.index')->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->authorize('delete', $product);

        $product->delete();

        return redirect()->route('vendor.products.index')->with('success', 'Product deleted successfully');
    }
}

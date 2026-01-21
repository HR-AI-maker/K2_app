<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProductsController extends Controller
{
    /**
     * Display all products for moderation
     */
    public function index(): View
    {
        $pendingProducts = Product::where('status', 'pending')
            ->with('vendor')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'pending');

        $publishedProducts = Product::where('status', 'published')
            ->with('vendor')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'published');

        $rejectedProducts = Product::where('status', 'rejected')
            ->with('vendor')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'rejected');

        return view('admin.products.index', compact('pendingProducts', 'publishedProducts', 'rejectedProducts'));
    }

    /**
     * Display product details
     */
    public function show(Product $product): View
    {
        $product->load('vendor');

        return view('admin.products.show', ['product' => $product]);
    }

    /**
     * Approve a product
     */
    public function approve(Request $request, Product $product): RedirectResponse
    {
        if ($product->status === 'pending' || $product->status === 'rejected') {
            $product->update([
                'status' => 'published',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            return redirect()->back()->with('success', 'Product approved and published successfully!');
        }

        return redirect()->back()->with('error', 'Only pending or rejected products can be approved.');
    }

    /**
     * Reject a product
     */
    public function reject(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'reason' => 'required|string|min:10|max:1000',
        ]);

        $product->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['reason'],
        ]);

        // TODO: Send notification email to vendor about rejection

        return redirect()->back()->with('success', 'Product rejected. Vendor has been notified.');
    }

    /**
     * Delete a product
     */
    public function destroy(Product $product): RedirectResponse
    {
        $productName = $product->name;
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', "Product '{$productName}' deleted successfully.");
    }
}

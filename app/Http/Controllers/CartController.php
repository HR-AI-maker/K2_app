<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    /**
     * Display shopping cart
     */
    public function index(): View
    {
        $cartItems = auth()->user()->cartItems()->with('product.vendor')->get();

        $total = $cartItems->sum(function ($item) {
            return $item->price_snapshot * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add item to cart
     */
    public function add(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if (!$product->isAvailable()) {
            $message = 'This product is not available for purchase.';
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $message], 422);
            }
            return redirect()->back()->with('error', $message);
        }

        // Check if already in cart and update quantity
        $cartItem = auth()->user()->cartItems()
            ->where('product_id', $product->id)
            ->first();

        $requestedQuantity = $validated['quantity'] + ($cartItem?->quantity ?? 0);
        if (!$product->is_unlimited_stock && $requestedQuantity > $product->stock_quantity) {
            $message = 'Requested quantity exceeds available stock.';
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $message], 422);
            }
            return redirect()->back()->with('error', $message);
        }

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $requestedQuantity,
                'price_snapshot' => $product->price,
            ]);
        } else {
            // Add new item to cart
            CartItem::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $validated['quantity'],
                'price_snapshot' => $product->price,
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Product added to cart']);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart.');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, CartItem $cartItem): RedirectResponse
    {
        if ($cartItem->user_id !== auth()->id()) {
            abort(403, 'You do not have permission to update this cart item');
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $product = $cartItem->product;
        if (!$product || !$product->isAvailable()) {
            return redirect()->back()->with('error', 'This product is no longer available.');
        }

        if (!$product->is_unlimited_stock && $validated['quantity'] > $product->stock_quantity) {
            return redirect()->back()->with('error', 'Requested quantity exceeds available stock.');
        }

        $cartItem->update([
            'quantity' => $validated['quantity'],
            'price_snapshot' => $product->price,
        ]);

        return redirect()->back()->with('success', 'Cart updated successfully.');
    }

    /**
     * Remove item from cart
     */
    public function remove(CartItem $cartItem): RedirectResponse
    {
        if ($cartItem->user_id !== auth()->id()) {
            abort(403, 'You do not have permission to remove this cart item');
        }

        $cartItem->delete();

        return redirect()->back()->with('success', 'Item removed from cart.');
    }

    /**
     * Display checkout form
     */
    public function checkout(): View
    {
        $cartItems = auth()->user()->cartItems()->with('product.vendor')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('warning', 'Your cart is empty');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->price_snapshot * $item->quantity;
        });

        $tax = round($total * 0.05, 2); // 5% tax
        $shipping_fee = 0; // Free shipping
        $final_total = $total + $tax + $shipping_fee;

        $totals = [
            'subtotal' => $total,
            'tax' => $tax,
            'shipping_fee' => $shipping_fee,
            'total' => $final_total,
        ];

        return view('cart.checkout', compact('cartItems', 'total', 'totals'));
    }

    /**
     * Process checkout and create order
     */
    public function processCheckout(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'shipping_address' => 'required|string|min:10|max:500',
            'shipping_phone' => 'required|string|min:10|max:20',
            'notes' => 'nullable|string|max:500',
        ]);

        $cartItems = auth()->user()->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        // Validate availability and calculate totals
        foreach ($cartItems as $item) {
            $product = $item->product;
            if (!$product || !$product->isAvailable()) {
                return redirect()->route('cart.index')->with('error', "One or more items are no longer available.");
            }
            if (!$product->is_unlimited_stock && $item->quantity > $product->stock_quantity) {
                return redirect()->route('cart.index')->with('error', "Insufficient stock for {$product->name}.");
            }
        }

        // Calculate totals
        $subtotal = $cartItems->sum(function ($item) {
            return $item->price_snapshot * $item->quantity;
        });
        $tax = round($subtotal * 0.05, 2);
        $shipping_fee = 0;
        $total = $subtotal + $tax + $shipping_fee;

        // Create order
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => Order::generateOrderNumber(),
            'status' => 'payment_pending',
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping_fee' => $shipping_fee,
            'total' => $total,
            'amount_paid' => 0,
            'payment_method' => 'bank_transfer',
            'shipping_address' => $validated['shipping_address'],
            'shipping_phone' => $validated['shipping_phone'],
            'notes' => $validated['notes'] ?? null,
        ]);

        // Create order items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'vendor_id' => $item->product->vendor_id,
                'product_name' => $item->product->name,
                'quantity' => $item->quantity,
                'unit_price' => $item->price_snapshot,
                'total_price' => $item->subtotal,
                'fulfillment_status' => 'pending',
            ]);

            if (!$item->product->is_unlimited_stock) {
                $item->product->decrement('stock_quantity', $item->quantity);
            }
        }

        // Clear cart
        auth()->user()->cartItems()->delete();

        return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully! Please complete payment.');
    }
}

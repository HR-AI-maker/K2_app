<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

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
    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        // Check if already in cart and update quantity
        $cartItem = auth()->user()->cartItems()
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $cartItem->quantity + $validated['quantity'],
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

        return response()->json(['success' => true, 'message' => 'Product added to cart']);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $cartItem): RedirectResponse
    {
        return redirect()->back();
    }

    /**
     * Remove item from cart
     */
    public function remove($cartItem): RedirectResponse
    {
        return redirect()->back();
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
            'status' => 'pending',
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
        }

        // Clear cart
        auth()->user()->cartItems()->delete();

        return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully! Please complete payment.');
    }
}

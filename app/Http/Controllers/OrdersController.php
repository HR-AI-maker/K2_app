<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class OrdersController extends Controller
{
    /**
     * Display user's orders
     */
    public function index(): View
    {
        $orders = auth()->user()->orders()->with('items.product')->orderBy('created_at', 'desc')->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Display order details
     */
    public function show(Order $order): View
    {
        // Verify user owns this order
        if ($order->user_id !== auth()->id()) {
            abort(403, 'You do not have permission to view this order');
        }

        $order->load('items.product.vendor');

        return view('orders.show', compact('order'));
    }

    /**
     * Cancel an order
     */
    public function cancel(Request $request, Order $order): RedirectResponse
    {
        if ($order->user_id !== auth()->id()) {
            abort(403, 'You do not have permission to cancel this order');
        }

        if (!in_array($order->status, ['pending', 'payment_pending'], true)) {
            return redirect()->back()->with('error', 'This order cannot be cancelled.');
        }

        $order->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Order cancelled successfully.');
    }
}

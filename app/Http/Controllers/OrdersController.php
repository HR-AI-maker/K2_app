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
    public function cancel(Request $request, $order): RedirectResponse
    {
        return redirect()->back();
    }
}

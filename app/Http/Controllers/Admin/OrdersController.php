<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class OrdersController extends Controller
{
    /**
     * Display all orders
     */
    public function index(): View
    {
        return view('admin.orders.index');
    }

    /**
     * Display order details
     */
    public function show($order): View
    {
        return view('admin.orders.show', ['order' => $order]);
    }

    /**
     * Verify payment for an order
     */
    public function verifyPayment(Request $request, $order): RedirectResponse
    {
        return redirect()->back();
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, $order): RedirectResponse
    {
        return redirect()->back();
    }
}

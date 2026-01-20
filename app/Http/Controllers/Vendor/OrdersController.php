<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\View\View;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('vendor');
    }

    public function index(): View
    {
        $vendor = auth()->user()->managedVendor;

        $orders = Order::whereHas('items', function ($query) use ($vendor) {
            $query->where('vendor_id', $vendor->id);
        })
        ->with(['user', 'items' => function ($query) use ($vendor) {
            $query->where('vendor_id', $vendor->id);
        }])
        ->orderBy('created_at', 'desc')
        ->paginate(15);

        return view('vendor.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $vendor = auth()->user()->managedVendor;

        // Check if this order contains items from vendor
        if (!$order->items()->where('vendor_id', $vendor->id)->exists()) {
            abort(403);
        }

        $order->load(['user', 'items' => function ($query) use ($vendor) {
            $query->where('vendor_id', $vendor->id);
        }]);

        return view('vendor.orders.show', compact('order'));
    }
}

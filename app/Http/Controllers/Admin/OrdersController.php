<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
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
        $currentStatus = request('status', 'all');
        $currentPayment = request('payment', 'all');

        $query = Order::with('user');

        if ($currentStatus !== 'all') {
            $query->where('status', $currentStatus);
        }

        if ($currentPayment === 'verified') {
            $query->whereNotNull('payment_verified_at');
        } elseif ($currentPayment === 'pending') {
            $query->whereNull('payment_verified_at');
        }

        if (request('search')) {
            $search = request('search');
            $query->where(function ($builder) use ($search) {
                $builder->where('order_number', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('first_name', 'like', '%' . $search . '%')
                            ->orWhere('last_name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    });
            });
        }

        $allowedSorts = ['created_at', 'total', 'status'];
        $sortBy = request('sort_by', 'created_at');
        $sortBy = in_array($sortBy, $allowedSorts, true) ? $sortBy : 'created_at';
        $sortOrder = request('sort_order', 'desc') === 'asc' ? 'asc' : 'desc';

        $orders = $query->orderBy($sortBy, $sortOrder)
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'pending' => Order::where('status', 'pending')->count(),
            'payment_pending' => Order::where('status', 'payment_pending')->count(),
            'paid' => Order::where('status', 'paid')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
            'refunded' => Order::where('status', 'refunded')->count(),
            'total' => Order::count(),
        ];

        return view('admin.orders.index', compact('orders', 'stats', 'currentStatus', 'currentPayment'));
    }

    /**
     * Display order details
     */
    public function show(Order $order): View
    {
        $order->load(['user', 'items.vendor', 'paymentVerifiedBy']);

        return view('admin.orders.show', ['order' => $order]);
    }

    /**
     * Verify payment for an order
     */
    public function verifyPayment(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'amount_paid' => 'required|numeric|min:0',
        ]);

        $order->update([
            'amount_paid' => $validated['amount_paid'],
            'payment_verified_at' => now(),
            'payment_verified_by' => auth()->id(),
            'status' => $order->status === 'payment_pending' ? 'paid' : $order->status,
        ]);

        return redirect()->back()->with('success', 'Payment verified successfully.');
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,payment_pending,paid,processing,shipped,delivered,cancelled,refunded',
        ]);

        $order->update([
            'status' => $validated['status'],
        ]);

        return redirect()->back()->with('success', 'Order status updated.');
    }
}

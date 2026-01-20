<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('vendor');
    }

    public function index(): View
    {
        $vendor = auth()->user()->managedVendor;

        $stats = [
            'total_products' => $vendor->products()->count(),
            'pending_approval' => $vendor->products()->where('status', 'pending')->count(),
            'published_products' => $vendor->products()->where('status', 'published')->count(),
            'total_sales' => $vendor->products()->sum('sales_count'),
            'total_views' => $vendor->products()->sum('views_count'),
        ];

        $orders = $vendor->orderItems()
            ->with(['order', 'product'])
            ->whereIn('fulfillment_status', ['pending', 'processing'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $recentProducts = $vendor->products()
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('vendor.dashboard', compact('vendor', 'stats', 'orders', 'recentProducts'));
    }
}

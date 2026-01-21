@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="mb-6" style="padding: 1.5rem; background: white; border-radius: 0.5rem; box-shadow: 0 4px 24px 0 rgba(34,41,47,0.1); border: 1px solid #ebe9f1;">
    <h1 style="font-size: 1.5rem; font-weight: 600; color: #5e5873; margin: 0 0 0.25rem;">Vendor Dashboard</h1>
    <p style="color: #b9b9c3; margin: 0;">{{ $vendor->business_name }}</p>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Total Products -->
    <div style="background: white; border-radius: 0.5rem; box-shadow: 0 4px 24px 0 rgba(34,41,47,0.1); border: 1px solid #ebe9f1; padding: 1.5rem;">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div>
                <p style="font-size: 0.875rem; color: #b9b9c3; margin: 0;">Total Products</p>
                <h3 style="font-size: 1.75rem; font-weight: 600; color: #5e5873; margin: 0.5rem 0;">{{ $stats['total_products'] }}</h3>
            </div>
            <div style="width: 48px; height: 48px; background: rgba(115,103,240,0.12); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: #7367f0; font-size: 1.5rem;">
                📦
            </div>
        </div>
    </div>

    <!-- Pending Approval -->
    <div style="background: white; border-radius: 0.5rem; box-shadow: 0 4px 24px 0 rgba(34,41,47,0.1); border: 1px solid #ebe9f1; padding: 1.5rem;">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div>
                <p style="font-size: 0.875rem; color: #b9b9c3; margin: 0;">Pending Approval</p>
                <h3 style="font-size: 1.75rem; font-weight: 600; color: #5e5873; margin: 0.5rem 0;">{{ $stats['pending_approval'] }}</h3>
            </div>
            <div style="width: 48px; height: 48px; background: rgba(255,159,67,0.12); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: #ff9f43; font-size: 1.5rem;">
                ⏳
            </div>
        </div>
    </div>

    <!-- Total Sales -->
    <div style="background: white; border-radius: 0.5rem; box-shadow: 0 4px 24px 0 rgba(34,41,47,0.1); border: 1px solid #ebe9f1; padding: 1.5rem;">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div>
                <p style="font-size: 0.875rem; color: #b9b9c3; margin: 0;">Total Sales</p>
                <h3 style="font-size: 1.75rem; font-weight: 600; color: #5e5873; margin: 0.5rem 0;">{{ $stats['total_sales'] }}</h3>
            </div>
            <div style="width: 48px; height: 48px; background: rgba(40,199,111,0.12); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: #28c76f; font-size: 1.5rem;">
                ✓
            </div>
        </div>
    </div>

    <!-- Total Views -->
    <div style="background: white; border-radius: 0.5rem; box-shadow: 0 4px 24px 0 rgba(34,41,47,0.1); border: 1px solid #ebe9f1; padding: 1.5rem;">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div>
                <p style="font-size: 0.875rem; color: #b9b9c3; margin: 0;">Total Views</p>
                <h3 style="font-size: 1.75rem; font-weight: 600; color: #5e5873; margin: 0.5rem 0;">{{ $stats['total_views'] }}</h3>
            </div>
            <div style="width: 48px; height: 48px; background: rgba(0,207,232,0.12); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: #00cfe8; font-size: 1.5rem;">
                👁️
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div style="background: white; border-radius: 0.5rem; box-shadow: 0 4px 24px 0 rgba(34,41,47,0.1); border: 1px solid #ebe9f1; margin-bottom: 1.5rem; overflow: hidden;">
    <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #ebe9f1;">
        <h2 style="font-size: 1.125rem; font-weight: 600; color: #5e5873; margin: 0;">Quick Actions</h2>
    </div>
    <div style="padding: 1.5rem;">
        <div class="flex gap-3 flex-wrap">
            <a href="{{ route('vendor.products.create') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: linear-gradient(118deg, #7367f0, #9e95f5); color: white; padding: 0.75rem 1.25rem; border-radius: 0.375rem; font-weight: 500; font-size: 0.875rem; text-decoration: none;">
                ➕ Add New Product
            </a>
            <a href="{{ route('vendor.products.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: white; border: 1px solid #ebe9f1; color: #5e5873; padding: 0.75rem 1.25rem; border-radius: 0.375rem; font-weight: 500; font-size: 0.875rem; text-decoration: none;">
                📋 Manage Products
            </a>
            <a href="{{ route('vendor.orders.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: white; border: 1px solid #ebe9f1; color: #5e5873; padding: 0.75rem 1.25rem; border-radius: 0.375rem; font-weight: 500; font-size: 0.875rem; text-decoration: none;">
                📦 View Orders
            </a>
        </div>
    </div>
</div>

<!-- Pending Orders & Recent Products -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Pending Orders -->
    <div class="lg:col-span-2" style="background: white; border-radius: 0.5rem; box-shadow: 0 4px 24px 0 rgba(34,41,47,0.1); border: 1px solid #ebe9f1; overflow: hidden;">
        <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #ebe9f1;">
            <h2 style="font-size: 1.125rem; font-weight: 600; color: #5e5873; margin: 0;">Pending Orders</h2>
        </div>
        <div style="padding: 1.5rem;">
            @if($orders->count() > 0)
                <div style="space-y: 0.5rem; max-height: 400px; overflow-y: auto;">
                    @foreach($orders as $orderItem)
                        <a href="{{ route('vendor.orders.show', $orderItem->order) }}" style="display: flex; justify-content: space-between; align-items: flex-start; padding: 1rem; border: 1px solid #ebe9f1; border-radius: 0.5rem; margin-bottom: 0.75rem; text-decoration: none; transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='#f8f8f8'; this.style.borderColor='#7367f0';" onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='#ebe9f1';">
                            <div style="flex: 1;">
                                <p style="font-weight: 600; color: #5e5873; margin: 0 0 0.25rem;">{{ $orderItem->order->order_number }}</p>
                                <p style="font-size: 0.875rem; color: #b9b9c3; margin: 0 0 0.25rem;">{{ $orderItem->product_name }}</p>
                                <p style="font-size: 0.75rem; color: #b9b9c3; margin: 0;">Qty: {{ $orderItem->quantity }} | PKR {{ number_format($orderItem->total_price, 0) }}</p>
                            </div>
                            @if($orderItem->fulfillment_status === 'pending')
                                <span style="display: inline-flex; align-items: center; background: rgba(255,159,67,0.12); color: #ff9f43; padding: 0.25rem 0.625rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 500;">Pending</span>
                            @elseif($orderItem->fulfillment_status === 'processing')
                                <span style="display: inline-flex; align-items: center; background: rgba(115,103,240,0.12); color: #7367f0; padding: 0.25rem 0.625rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 500;">Processing</span>
                            @else
                                <span style="display: inline-flex; align-items: center; background: rgba(180,180,180,0.12); color: #b9b9c3; padding: 0.25rem 0.625rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 500;">{{ ucfirst($orderItem->fulfillment_status) }}</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 2rem; color: #b9b9c3;">
                    <p style="font-size: 0.875rem; margin: 0;">✓ No pending orders</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Products -->
    <div style="background: white; border-radius: 0.5rem; box-shadow: 0 4px 24px 0 rgba(34,41,47,0.1); border: 1px solid #ebe9f1; overflow: hidden;">
        <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #ebe9f1;">
            <h2 style="font-size: 1.125rem; font-weight: 600; color: #5e5873; margin: 0;">Recent Products</h2>
        </div>
        <div style="padding: 1.5rem;">
            @if($recentProducts->count() > 0)
                <div style="space-y: 0.5rem; max-height: 400px; overflow-y: auto;">
                    @foreach($recentProducts as $product)
                        <a href="{{ route('vendor.products.edit', $product) }}" style="display: block; padding: 1rem; border: 1px solid #ebe9f1; border-radius: 0.5rem; margin-bottom: 0.75rem; text-decoration: none; transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='#f8f8f8'; this.style.borderColor='#7367f0';" onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='#ebe9f1';">
                            <p style="font-weight: 600; color: #5e5873; margin: 0 0 0.25rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $product->name }}</p>
                            <p style="font-size: 0.875rem; color: #5e5873; margin: 0.25rem 0 0.75rem; font-weight: 600;">PKR {{ number_format($product->price, 0) }}</p>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                @if($product->status === 'draft')
                                    <span style="display: inline-flex; align-items: center; background: rgba(180,180,180,0.12); color: #b9b9c3; padding: 0.25rem 0.625rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 500;">Draft</span>
                                @elseif($product->status === 'pending')
                                    <span style="display: inline-flex; align-items: center; background: rgba(255,159,67,0.12); color: #ff9f43; padding: 0.25rem 0.625rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 500;">Pending</span>
                                @elseif($product->status === 'published')
                                    <span style="display: inline-flex; align-items: center; background: rgba(40,199,111,0.12); color: #28c76f; padding: 0.25rem 0.625rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 500;">Published</span>
                                @endif
                                <span style="font-size: 0.75rem; color: #b9b9c3;">{{ $product->views_count }} views</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 2rem;">
                    <p style="font-size: 0.875rem; color: #b9b9c3; margin: 0 0 1rem;">No products yet</p>
                    <a href="{{ route('vendor.products.create') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: linear-gradient(118deg, #7367f0, #9e95f5); color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 500; font-size: 0.875rem; text-decoration: none;">
                        Create Your First Product
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

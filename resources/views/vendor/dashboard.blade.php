@extends('layouts.vendor')

@section('content')
<!-- Page Header - Hero Section -->
<div style="margin-bottom: 2.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
            <h1 style="font-size: 2.75rem; font-weight: 900; color: #1E262A; margin: 0 0 0.75rem; line-height: 1.2;">Vendor Dashboard 🏪</h1>
            <p style="font-size: 1.25rem; color: #6C6C6C; margin: 0; line-height: 1.6;">Manage your business: <span style="font-weight: 700; color: #8b5cf6;">{{ $vendor->business_name }}</span></p>
        </div>
        <div style="text-align: right; color: #94A3B8; font-size: 1rem; font-weight: 500;">
            <p style="margin: 0;">{{ now()->format('l, F j, Y') }}</p>
        </div>
    </div>
</div>

<!-- KPI Cards - Business Metrics -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-bottom: 2rem;">
    <!-- Total Products -->
    <div style="background: white; border-radius: 1.5rem; border: 2px solid #E0E0E0; border-left: 5px solid #8b5cf6; padding: 2rem; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <p style="font-size: 1rem; color: #94A3B8; font-weight: 600; margin: 0 0 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Total Products</p>
        <h3 style="font-size: 2.5rem; font-weight: 900; color: #1E262A; margin: 0 0 1rem;">{{ $stats['total_products'] }}</h3>
        <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 1.125rem; color: #6C6C6C;">
            <span>📦</span>
            <a href="{{ route('vendor.products.index') }}" style="color: #8b5cf6; text-decoration: none; font-weight: 700;">View Products →</a>
        </div>
    </div>

    <!-- Pending Approval -->
    <div style="background: white; border-radius: 1.5rem; border: 2px solid #E0E0E0; border-left: 5px solid #FF771E; padding: 2rem; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <p style="font-size: 1rem; color: #94A3B8; font-weight: 600; margin: 0 0 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Pending Approval</p>
        <h3 style="font-size: 2.5rem; font-weight: 900; color: #1E262A; margin: 0 0 1rem;">{{ $stats['pending_approval'] }}</h3>
        <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 1.125rem; color: #6C6C6C;">
            <span>⏳</span>
            <a href="{{ route('vendor.products.index', ['status' => 'pending']) }}" style="color: #FF771E; text-decoration: none; font-weight: 700;">Review →</a>
        </div>
    </div>

    <!-- Total Sales -->
    <div style="background: white; border-radius: 1.5rem; border: 2px solid #E0E0E0; border-left: 5px solid #10b981; padding: 2rem; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <p style="font-size: 1rem; color: #94A3B8; font-weight: 600; margin: 0 0 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Total Sales</p>
        <h3 style="font-size: 2.5rem; font-weight: 900; color: #1E262A; margin: 0 0 1rem;">{{ $stats['total_sales'] }}</h3>
        <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 1.125rem; color: #6C6C6C;">
            <span>✓</span>
            <span style="color: #10b981; font-weight: 700;">Great performance</span>
        </div>
    </div>

    <!-- Total Views -->
    <div style="background: white; border-radius: 1.5rem; border: 2px solid #E0E0E0; border-left: 5px solid #06b6d4; padding: 2rem; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <p style="font-size: 1rem; color: #94A3B8; font-weight: 600; margin: 0 0 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Total Views</p>
        <h3 style="font-size: 2.5rem; font-weight: 900; color: #1E262A; margin: 0 0 1rem;">{{ $stats['total_views'] }}</h3>
        <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 1.125rem; color: #6C6C6C;">
            <span>👁️</span>
            <span style="color: #06b6d4; font-weight: 700;">Strong visibility</span>
        </div>
    </div>
</div>

<!-- Quick Actions - Featured -->
<div style="background: white; border-radius: 1.5rem; border: 2px solid #E0E0E0; margin-bottom: 2rem; padding: 2.5rem; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
    <h2 style="font-size: 1.75rem; font-weight: 800; color: #1E262A; margin: 0 0 1.75rem; line-height: 1.2;">Quick Actions ⚡</h2>
    <div style="display: flex; gap: 1.5rem; flex-wrap: wrap;">
        <a href="{{ route('vendor.products.create') }}" style="display: inline-flex; align-items: center; gap: 0.75rem; background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%); color: white; padding: 1rem 2rem; border-radius: 0.75rem; font-weight: 800; font-size: 1.125rem; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);"
            onmouseover="this.style.transform = 'translateY(-2px)'; this.style.boxShadow = '0 8px 25px rgba(139, 92, 246, 0.4)';"
            onmouseout="this.style.transform = 'translateY(0)'; this.style.boxShadow = '0 4px 15px rgba(139, 92, 246, 0.3)';">
            ➕ Create Product
        </a>
        <a href="{{ route('vendor.products.index') }}" style="display: inline-flex; align-items: center; gap: 0.75rem; background: white; border: 2px solid #E0E0E0; color: #1E262A; padding: 1rem 2rem; border-radius: 0.75rem; font-weight: 800; font-size: 1.125rem; text-decoration: none; transition: all 0.3s ease;"
            onmouseover="this.style.borderColor = '#8b5cf6'; this.style.color = '#8b5cf6'; this.style.boxShadow = '0 4px 15px rgba(139, 92, 246, 0.2)';"
            onmouseout="this.style.borderColor = '#E0E0E0'; this.style.color = '#1E262A'; this.style.boxShadow = 'none';">
            📋 Manage Products
        </a>
        <a href="{{ route('vendor.orders.index') }}" style="display: inline-flex; align-items: center; gap: 0.75rem; background: white; border: 2px solid #E0E0E0; color: #1E262A; padding: 1rem 2rem; border-radius: 0.75rem; font-weight: 800; font-size: 1.125rem; text-decoration: none; transition: all 0.3s ease;"
            onmouseover="this.style.borderColor = '#FF771E'; this.style.color = '#FF771E'; this.style.boxShadow = '0 4px 15px rgba(255, 119, 30, 0.2)';"
            onmouseout="this.style.borderColor = '#E0E0E0'; this.style.color = '#1E262A'; this.style.boxShadow = 'none';">
            📦 View Orders
        </a>
    </div>
</div>

<!-- Activity Section - Pending Orders & Recent Products -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Pending Orders -->
    <div class="lg:col-span-2 vendor-card" style="padding: 2rem;">
        <div style="margin-bottom: 1.5rem;">
            <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--text-primary); margin: 0;">Pending Orders 📦</h2>
            <p style="color: var(--text-muted); font-size: 0.875rem; margin: 0.5rem 0 0;">Orders awaiting fulfillment</p>
        </div>
        @if($orders->count() > 0)
            <div style="max-height: 450px; overflow-y: auto; space-y: 0.75rem;">
                @foreach($orders as $orderItem)
                    <a href="{{ route('vendor.orders.show', $orderItem->order) }}" style="display: flex; justify-content: space-between; align-items: flex-start; padding: 1rem; border: 1px solid var(--border); border-radius: 0.625rem; margin-bottom: 0.75rem; text-decoration: none; transition: all 0.2s ease; background: var(--light);">
                        <div style="flex: 1;">
                            <p style="font-weight: 700; color: var(--text-primary); margin: 0 0 0.25rem; font-size: 0.9375rem;">{{ $orderItem->order->order_number }}</p>
                            <p style="font-size: 0.875rem; color: var(--text-secondary); margin: 0 0 0.25rem;">{{ $orderItem->product_name }}</p>
                            <p style="font-size: 0.8125rem; color: var(--text-muted); margin: 0;">Qty: {{ $orderItem->quantity }} | PKR {{ number_format($orderItem->total_price, 0) }}</p>
                        </div>
                        @if($orderItem->fulfillment_status === 'pending')
                            <span style="display: inline-flex; align-items: center; background: rgba(249, 115, 22, 0.1); color: var(--warning); padding: 0.375rem 0.75rem; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600; white-space: nowrap;">⏳ Pending</span>
                        @elseif($orderItem->fulfillment_status === 'processing')
                            <span style="display: inline-flex; align-items: center; background: rgba(139, 92, 246, 0.1); color: var(--primary); padding: 0.375rem 0.75rem; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600; white-space: nowrap;">⚙️ Processing</span>
                        @else
                            <span style="display: inline-flex; align-items: center; background: rgba(34, 197, 94, 0.1); color: var(--success); padding: 0.375rem 0.75rem; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600; white-space: nowrap;">✓ {{ ucfirst($orderItem->fulfillment_status) }}</span>
                        @endif
                    </a>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 3rem 2rem;">
                <p style="font-size: 1.5rem; margin: 0 0 0.5rem;">✨</p>
                <p style="font-size: 0.9375rem; color: var(--text-muted); margin: 0;">No pending orders</p>
            </div>
        @endif
    </div>

    <!-- Recent Products -->
    <div class="vendor-card" style="padding: 2rem;">
        <div style="margin-bottom: 1.5rem;">
            <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--text-primary); margin: 0;">Recent Products 🎯</h2>
            <p style="color: var(--text-muted); font-size: 0.875rem; margin: 0.5rem 0 0;">Recently added items</p>
        </div>
        @if($recentProducts->count() > 0)
            <div style="max-height: 450px; overflow-y: auto;">
                @foreach($recentProducts as $product)
                    <a href="{{ route('vendor.products.edit', $product) }}" style="display: block; padding: 1rem; border: 1px solid var(--border); border-radius: 0.625rem; margin-bottom: 0.75rem; text-decoration: none; transition: all 0.2s ease; background: var(--light);">
                        <p style="font-weight: 700; color: var(--text-primary); margin: 0 0 0.25rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 0.9375rem;">{{ $product->name }}</p>
                        <p style="font-size: 0.875rem; color: var(--primary); margin: 0.25rem 0 0.75rem; font-weight: 600;">PKR {{ number_format($product->price, 0) }}</p>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            @if($product->status === 'draft')
                                <span style="display: inline-flex; align-items: center; background: rgba(148, 163, 184, 0.1); color: var(--text-muted); padding: 0.25rem 0.625rem; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600;">Draft</span>
                            @elseif($product->status === 'pending')
                                <span style="display: inline-flex; align-items: center; background: rgba(249, 115, 22, 0.1); color: var(--warning); padding: 0.25rem 0.625rem; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600;">Pending</span>
                            @elseif($product->status === 'published')
                                <span style="display: inline-flex; align-items: center; background: rgba(34, 197, 94, 0.1); color: var(--success); padding: 0.25rem 0.625rem; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600;">Published</span>
                            @endif
                            <span style="font-size: 0.75rem; color: var(--text-muted);">👁️ {{ $product->views_count }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 3rem 2rem;">
                <p style="font-size: 1.5rem; margin: 0 0 0.5rem;">📋</p>
                <p style="font-size: 0.875rem; color: var(--text-muted); margin: 0 0 1rem;">No products yet</p>
                <a href="{{ route('vendor.products.create') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); color: white; padding: 0.625rem 1.25rem; border-radius: 0.5rem; font-weight: 600; font-size: 0.875rem; text-decoration: none;">
                    Create Your First Product
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

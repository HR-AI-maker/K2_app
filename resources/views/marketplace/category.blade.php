@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <a href="{{ route('marketplace.index') }}" class="text-blue-600 hover:text-blue-800">&larr; Back to Marketplace</a>
            <h1 class="text-3xl font-bold text-gray-900 mt-4">{{ ucfirst($category) }}</h1>
        </div>

        <!-- Products Grid -->
        @if($products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
                @foreach($products as $product)
                    @include('marketplace.partials.product-card', ['product' => $product])
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">No products found in this category</p>
            </div>
        @endif
    </div>
</div>
@endsection

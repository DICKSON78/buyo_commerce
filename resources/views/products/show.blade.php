@extends('layouts.app')

@section('title', $product->name . ' - BidhaaHub')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="grid md:grid-cols-2 gap-8 p-8">
            <!-- Product Images -->
            <div>
                <div class="mb-4">
                    @if($product->images->count() > 0)
                        <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                             alt="{{ $product->name }}" class="w-full h-96 object-cover rounded-lg">
                    @else
                        <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                            <i class="fas fa-image text-gray-400 text-6xl"></i>
                        </div>
                    @endif
                </div>

                @if($product->images->count() > 1)
                <div class="grid grid-cols-4 gap-2">
                    @foreach($product->images as $image)
                    <img src="{{ asset('storage/' . $image->image_path) }}"
                         alt="{{ $product->name }}"
                         class="h-20 object-cover rounded cursor-pointer border-2 border-transparent hover:border-primary">
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Product Info -->
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>

                <div class="flex items-center mb-4">
                    <div class="flex text-yellow-400 mr-2">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star{{ $i <= 4 ? ' text-yellow-400' : '-half-alt text-gray-300' }}"></i>
                        @endfor
                    </div>
                    <span class="text-gray-600">(24 reviews)</span>
                </div>

                <p class="text-3xl font-bold text-secondary mb-6">TZS {{ number_format($product->price) }}</p>

                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 mb-2">Description</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                </div>

                <div class="space-y-3 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt text-primary mr-3"></i>
                        <span class="text-gray-600">Location: {{ $product->location }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-box text-primary mr-3"></i>
                        <span class="text-gray-600">Condition: {{ ucfirst($product->condition) }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-layer-group text-primary mr-3"></i>
                        <span class="text-gray-600">Category: {{ $product->category->name }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-calendar text-primary mr-3"></i>
                        <span class="text-gray-600">Listed: {{ $product->created_at->diffForHumans() }}</span>
                    </div>
                </div>

                <!-- Seller Info -->
                <div class="border-t border-gray-200 pt-6 mb-6">
                    <div class="flex items-center mb-4">
                        @if($product->seller->store_logo)
                            <img src="{{ asset('storage/' . $product->seller->store_logo) }}"
                                 alt="{{ $product->seller->store_name }}"
                                 class="w-12 h-12 rounded-full mr-4">
                        @else
                            <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white font-bold mr-4">
                                {{ substr($product->seller->store_name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h4 class="font-semibold">{{ $product->seller->store_name }}</h4>
                            <p class="text-gray-600 text-sm">Member since {{ $product->seller->created_at->format('M Y') }}</p>
                        </div>
                    </div>

                    <p class="text-gray-600 text-sm mb-4">{{ $product->seller->bio }}</p>

                    <div class="flex items-center text-sm text-gray-600">
                        <span class="mr-4"><i class="fas fa-star text-yellow-400 mr-1"></i> 4.5</span>
                        <span class="mr-4"><i class="fas fa-shopping-bag mr-1"></i> 45 products</span>
                        <span><i class="fas fa-check-circle text-green-500 mr-1"></i> Verified</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-4">
                    <button class="flex-1 bg-primary text-white py-3 px-6 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                        <i class="fas fa-shopping-cart mr-2"></i>Buy Now
                    </button>
                    <button class="flex-1 border border-primary text-primary py-3 px-6 rounded-lg font-semibold hover:bg-primary hover:text-white transition-colors">
                        <i class="fas fa-comment mr-2"></i>Chat Seller
                    </button>
                    <button class="w-12 h-12 border border-gray-300 rounded-lg flex items-center justify-center text-gray-400 hover:text-secondary hover:border-secondary">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <div class="mt-12">
        <h2 class="text-2xl font-bold mb-6">Related Products</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Related products would go here -->
        </div>
    </div>
</div>
@endsection

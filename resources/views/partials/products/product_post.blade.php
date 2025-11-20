<!-- Enhanced Main Product Feed -->
<div class="flex-1 min-w-0">
    <div id="productFeed" class="space-y-6 pb-8">
        <!-- Shimmer Loading Skeleton -->
        <div id="shimmerContainer" class="space-y-6">
            @for($i = 0; $i < 6; $i++)
            <div class="shimmer-card bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Seller Header Shimmer -->
                <div class="flex items-center justify-between p-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gray-300 dark:bg-gray-600 rounded-full shimmer"></div>
                        <div class="space-y-2">
                            <div class="w-32 h-4 bg-gray-300 dark:bg-gray-600 rounded shimmer"></div>
                            <div class="w-24 h-3 bg-gray-300 dark:bg-gray-600 rounded shimmer"></div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-6 h-6 bg-gray-300 dark:bg-gray-600 rounded shimmer"></div>
                        <div class="w-6 h-6 bg-gray-300 dark:bg-gray-600 rounded shimmer"></div>
                    </div>
                </div>

                <!-- Product Image Shimmer -->
                <div class="relative">
                    <div class="w-full h-80 bg-gray-300 dark:bg-gray-600 shimmer"></div>
                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                        <div class="w-3 h-3 bg-gray-400 rounded-full shimmer"></div>
                        <div class="w-3 h-3 bg-gray-400 rounded-full shimmer"></div>
                        <div class="w-3 h-3 bg-gray-400 rounded-full shimmer"></div>
                    </div>
                </div>

                <!-- Engagement Actions Shimmer -->
                <div class="flex items-center justify-between p-4 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center space-x-4">
                        <div class="w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded shimmer"></div>
                        <div class="w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded shimmer"></div>
                        <div class="w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded shimmer"></div>
                    </div>
                    <div class="w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded shimmer"></div>
                </div>

                <!-- Product Details Shimmer -->
                <div class="p-5 space-y-4">
                    <div class="w-3/4 h-6 bg-gray-300 dark:bg-gray-600 rounded shimmer"></div>
                    <div class="w-1/2 h-5 bg-gray-300 dark:bg-gray-600 rounded shimmer"></div>
                    <div class="space-y-2">
                        <div class="w-full h-4 bg-gray-300 dark:bg-gray-600 rounded shimmer"></div>
                        <div class="w-full h-4 bg-gray-300 dark:bg-gray-600 rounded shimmer"></div>
                        <div class="w-2/3 h-4 bg-gray-300 dark:bg-gray-600 rounded shimmer"></div>
                    </div>
                    <div class="space-y-3 pt-2">
                        <div class="w-full h-12 bg-gray-300 dark:bg-gray-600 rounded-xl shimmer"></div>
                        <div class="w-full h-12 bg-gray-300 dark:bg-gray-600 rounded-xl shimmer"></div>
                    </div>
                </div>
            </div>
            @endfor
        </div>

        <!-- Actual Content (Initially Hidden) -->
        <div id="actualContent" class="hidden space-y-6">
            @forelse($products as $product)
            <div class="product-card bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Seller Header -->
                <div class="flex items-center justify-between p-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg">
                            {{ substr($product->seller->store_name ?? 'SL', 0, 2) }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 dark:text-gray-100 text-sm">{{ $product->seller->store_name ?? 'Seller' }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center space-x-1">
                                <i class="fas fa-map-marker-alt text-green-600"></i>
                                <span>{{ $product->seller->business_place ?? 'Online' }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        @auth
                        <button onclick="openContactModal({{ $product->id }}, '{{ $product->seller->store_name ?? 'Seller' }}', {{ $product->seller->user_id ?? 0 }})" class="text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors duration-300" title="Message Seller">
                            <i class="fas fa-envelope text-lg"></i>
                        </button>
                        @else
                        <button onclick="showLoginAlert()" class="text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors duration-300" title="Message Seller">
                            <i class="fas fa-envelope text-lg"></i>
                        </button>
                        @endauth
                        <button class="share-btn text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors duration-300"
                                title="Share"
                                data-product-id="{{ $product->id }}"
                                data-product-name="{{ $product->name }}"
                                data-product-image="{{ $product->productImages->first() ? asset('storage/' . $product->productImages->first()->image_path) : 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=500' }}">
                            <i class="fas fa-share-alt text-lg"></i>
                        </button>
                    </div>
                </div>

                <!-- Product Images Carousel -->
                <div class="relative">
                    @if($product->productImages && $product->productImages->count() > 0)
                    <div class="carousel-container flex overflow-x-auto snap-x snap-mandatory scrollbar-hide" style="height: 450px;">
                        @foreach($product->productImages as $image)
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}"
                             class="carousel-image w-full h-full object-cover snap-center flex-shrink-0 transition-transform duration-500">
                        @endforeach
                    </div>
                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                        @foreach($product->productImages as $index => $image)
                        <div class="w-3 h-3 bg-white rounded-full opacity-{{ $index === 0 ? '100' : '50' }} indicator cursor-pointer transition-all duration-300 hover:opacity-100 hover:scale-125"></div>
                        @endforeach
                    </div>
                    @else
                    <div class="w-full h-80 bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                        <i class="fas fa-image text-gray-400 text-6xl"></i>
                    </div>
                    @endif

                    @if($product->compare_price && $product->compare_price > $product->price)
                    <div class="sale-badge absolute top-4 right-4">
                        <i class="fas fa-tag mr-1"></i>
                        {{ round((($product->compare_price - $product->price) / $product->compare_price) * 100) }}% OFF
                    </div>
                    @endif
                </div>

                <!-- Engagement Actions -->
                <div class="flex items-center justify-between p-4 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center space-x-4">
                        <button class="text-2xl text-gray-400 hover:text-red-500 transition-colors duration-300 like-btn" data-product-id="{{ $product->id }}">
                            <i class="far fa-heart"></i>
                        </button>
                        <button class="text-2xl text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors duration-300">
                            <i class="far fa-comment"></i>
                        </button>
                        <button class="share-btn text-2xl text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors duration-300"
                                data-product-id="{{ $product->id }}"
                                data-product-name="{{ $product->name }}"
                                data-product-image="{{ $product->productImages->first() ? asset('storage/' . $product->productImages->first()->image_path) : 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=500' }}">
                            <i class="far fa-share-square"></i>
                        </button>
                    </div>
                    <button class="text-2xl text-gray-400 hover:text-yellow-500 transition-colors duration-300">
                        <i class="far fa-bookmark"></i>
                    </button>
                </div>

                <!-- Product Details -->
                <div class="p-5">
                    <h3 class="font-bold text-xl text-gray-800 dark:text-gray-100 mb-3 leading-tight">{{ $product->name }}</h3>

                    <div class="flex items-center space-x-3 mb-4">
                        <span class="price-tag">
                            <i class="fas fa-tag mr-1"></i>
                            TZS {{ number_format($product->price) }}
                        </span>
                        @if($product->compare_price && $product->compare_price > $product->price)
                        <span class="text-gray-500 text-sm line-through font-medium">TZS {{ number_format($product->compare_price) }}</span>
                        @endif
                    </div>

                    <p class="text-gray-600 dark:text-gray-400 text-base leading-relaxed mb-5">{{ Str::limit($product->description, 200) }}</p>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <button onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }})"
                                class="w-full bg-green-600 hover:bg-green-700 text-white py-3.5 rounded-xl font-semibold transition-all duration-300 flex items-center justify-center space-x-3 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <i class="fas fa-shopping-cart text-lg"></i>
                            <span class="text-base">Add to Cart</span>
                        </button>

                        @auth
                        <button onclick="openContactModal({{ $product->id }}, '{{ $product->seller->store_name ?? 'Seller' }}', {{ $product->seller->user_id ?? 0 }})"
                                class="w-full border-2 border-green-600 text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900 py-3.5 rounded-xl font-semibold transition-all duration-300 flex items-center justify-center space-x-3 hover:shadow-lg">
                            <i class="fas fa-envelope text-lg"></i>
                            <span class="text-base">Message Seller</span>
                        </button>
                        @else
                        <button onclick="showLoginAlert()"
                                class="w-full border-2 border-green-600 text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900 py-3.5 rounded-xl font-semibold transition-all duration-300 flex items-center justify-center space-x-3 hover:shadow-lg">
                            <i class="fas fa-envelope text-lg"></i>
                            <span class="text-base">Message Seller</span>
                        </button>
                        @endauth
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-12 text-center">
                <div class="w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-search text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-3">No products found</h3>
                <p class="text-gray-600 dark:text-gray-400 text-lg mb-6">Try adjusting your search criteria or browse different categories.</p>
                <button onclick="clearFilters()" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-xl font-semibold transition-colors duration-300">
                    Clear Filters
                </button>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Add this CSS to your stylesheet -->
<style>
    .shimmer {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
        border-radius: 4px;
    }

    .dark .shimmer {
        background: linear-gradient(90deg, #374151 25%, #4b5563 50%, #374151 75%);
        background-size: 200% 100%;
    }

    @keyframes shimmer {
        0% {
            background-position: -200% 0;
        }
        100% {
            background-position: 200% 0;
        }
    }

    .shimmer-card {
        opacity: 0.7;
    }

    /* Ensure consistent spacing */
    #productFeed {
        gap: 1.5rem;
    }
    
    .space-y-6 > * + * {
        margin-top: 1.5rem;
    }
</style>

<!-- JavaScript to handle loading states -->
<script>
    // Show shimmer effect when loading
    function showShimmer() {
        document.getElementById('shimmerContainer').classList.remove('hidden');
        document.getElementById('actualContent').classList.add('hidden');
    }

    // Hide shimmer and show actual content
    function hideShimmer() {
        document.getElementById('shimmerContainer').classList.add('hidden');
        document.getElementById('actualContent').classList.remove('hidden');
    }

    // Simulate loading (replace with your actual data loading)
    document.addEventListener('DOMContentLoaded', function() {
        // Show shimmer initially
        showShimmer();
        
        // Simulate API call delay
        setTimeout(() => {
            hideShimmer();
        }, 1500); // Adjust based on your actual loading time
    });

    // You can also use this for AJAX calls
    function loadProducts() {
        showShimmer();
        
        // Your AJAX call here
        fetch('/your-api-endpoint')
            .then(response => response.json())
            .then(data => {
                hideShimmer();
                // Update your content
            })
            .catch(error => {
                hideShimmer();
                console.error('Error:', error);
            });
    }
</script>
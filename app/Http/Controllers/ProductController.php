<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Seller;
use App\Models\ProductImage;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // Add this static method to get category icons
    public static function getCategoryIconStatic($categoryName)
    {
        $icons = [
            'electronics' => 'mobile-alt',
            'fashion' => 'tshirt',
            'home' => 'home',
            'sports' => 'futbol',
            'books' => 'book',
            'beauty' => 'spa',
            'toys' => 'gamepad',
            'food' => 'utensils',
            'health' => 'heartbeat',
            'automotive' => 'car',
            'garden' => 'seedling',
            'music' => 'music',
            'art' => 'palette',
            'jewelry' => 'gem',
            'shoes' => 'shoe-prints',
            'bags' => 'shopping-bag',
            'watches' => 'clock',
            'furniture' => 'couch',
            'phones' => 'mobile',
            'laptops' => 'laptop',
            'cameras' => 'camera',
            'tv' => 'tv',
            'clothing' => 'tshirt',
            'computers' => 'laptop',
            'accessories' => 'gem',
            'default' => 'tag'
        ];
        
        $name = strtolower($categoryName);
        foreach ($icons as $key => $icon) {
            if (str_contains($name, $key)) {
                return $icon;
            }
        }
        
        return $icons['default'];
    }

    // Instance method for non-static usage
    private function getCategoryIcon($categoryName)
    {
        return self::getCategoryIconStatic($categoryName);
    }

    public function index(Request $request) 
    {
        // Query products with relationships - FIXED: Removed brand references
        $query = Product::with(['seller', 'category', 'productImages'])
            ->where('status', 'active')
            ->where('is_approved', true);

        // Search functionality - FIXED: Removed brand search
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%')
                  ->orWhere('name_sw', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description_sw', 'like', '%' . $searchTerm . '%')
                  ->orWhere('sku', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('seller', function($sellerQuery) use ($searchTerm) {
                      $sellerQuery->where('store_name', 'like', '%' . $searchTerm . '%');
                  })
                  ->orWhereHas('category', function($categoryQuery) use ($searchTerm) {
                      $categoryQuery->where('name', 'like', '%' . $searchTerm . '%');
                  });
            });
        }

        // Filter by categories
        if ($request->has('categories') && $request->categories != '') {
            $categoryIds = explode(',', $request->categories);
            $query->whereIn('category_id', $categoryIds);
        }

        // Filter by seller - FIXED: Using correct relationship
        if ($request->has('seller') && $request->seller) {
            $query->whereHas('seller', function($q) use ($request) {
                $q->where('store_name', 'like', '%' . $request->seller . '%');
            });
        }

        // Price range
        if ($request->has('min_price') && is_numeric($request->min_price)) {
            $query->where('price', '>=', floatval($request->min_price));
        }
        if ($request->has('max_price') && is_numeric($request->max_price)) {
            $query->where('price', '<=', floatval($request->max_price));
        }

        // Region filter - FIXED: Using business_place from sellers table
        if ($request->has('region') && $request->region) {
            $query->whereHas('seller', function($q) use ($request) {
                $q->where('business_place', 'like', '%' . $request->region . '%')
                  ->orWhere('business_region', 'like', '%' . $request->region . '%');
            });
        }

        // Condition filter - FIXED: Using condition from products table
        if ($request->has('condition') && $request->condition) {
            $query->where('condition', $request->condition);
        }

        // Location filter - FIXED: Using location from products table
        if ($request->has('location') && $request->location) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Sort options
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('view_count', 'desc');
                break;
            case 'featured':
                $query->where('is_featured', true)->orderBy('created_at', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);
        
        // Fetch all data from database - FIXED: Using correct relationships
        $categories = Category::where('is_active', true)
            ->withCount(['products' => function($query) {
                $query->where('status', 'active')->where('is_approved', true);
            }])
            ->orderBy('name')
            ->get();
        
        // Get conditions from products table - FIXED: Removed brand
        $conditions = ['new', 'used', 'refurbished']; // Static since it's enum in database

        // Get regions from database - FIXED: Using regions table
        $regions = Region::where('is_active', true)
            ->orderBy('name')
            ->pluck('name')
            ->toArray();

        // Get recent sellers with product count - FIXED: Correct relationship
        $recentSellers = Seller::withCount(['products' => function($query) {
                $query->where('status', 'active')->where('is_approved', true);
            }])
            ->with(['user'])
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get trending products
        $trendingProducts = Product::with(['seller', 'category', 'productImages'])
            ->where('status', 'active')
            ->where('is_approved', true)
            ->orderBy('view_count', 'desc')
            ->limit(8)
            ->get();

        return view('products.index', compact(
            'products', 
            'categories', 
            'recentSellers', 
            'trendingProducts',
            'regions',
            'conditions'
        ));
    }

    // AJAX FILTER METHOD - FIXED: Removed brand references
    public function filter(Request $request)
    {
        try {
            // Start with base query
            $query = Product::with(['seller', 'category', 'productImages'])
                ->where('status', 'active')
                ->where('is_approved', true);

            // Filter by categories (AJAX)
            if ($request->has('categories') && $request->categories != '') {
                $categoryIds = explode(',', $request->categories);
                $query->whereIn('category_id', $categoryIds);
            }

            // Apply other filters if provided
            if ($request->has('min_price') && $request->min_price != '') {
                $query->where('price', '>=', floatval($request->min_price));
            }

            if ($request->has('max_price') && $request->max_price != '') {
                $query->where('price', '<=', floatval($request->max_price));
            }

            // FIXED: Removed brand filter

            if ($request->has('region') && $request->region != '') {
                $query->whereHas('seller', function($q) use ($request) {
                    $q->where('business_place', 'like', '%' . $request->region . '%')
                      ->orWhere('business_region', 'like', '%' . $request->region . '%');
                });
            }

            if ($request->has('seller') && $request->seller != '') {
                $query->whereHas('seller', function($q) use ($request) {
                    $q->where('store_name', 'like', '%' . $request->seller . '%');
                });
            }

            if ($request->has('condition') && $request->condition != '') {
                $query->where('condition', $request->condition);
            }

            // Default ordering
            $query->orderBy('created_at', 'desc');

            $products = $query->get();

            // Format products for JSON response
            $formattedProducts = $products->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'compare_price' => $product->compare_price,
                    'description' => $product->description,
                    'seller_store_name' => $product->seller->store_name ?? null,
                    'seller_business_place' => $product->seller->business_place ?? null,
                    'product_images' => $product->productImages->map(function($image) {
                        return [
                            'image_path' => $image->image_path,
                            'id' => $image->id
                        ];
                    }),
                    'view_count' => $product->view_count
                ];
            });

            return response()->json([
                'success' => true,
                'products' => $formattedProducts,
                'message' => 'Products filtered successfully',
                'count' => $products->count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error filtering products: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($slug) 
    {
        $product = Product::with([
            'seller', 
            'category', 
            'productImages',
            'seller.user'
        ])
        ->where('slug', $slug)
        ->where('status', 'active')
        ->where('is_approved', true)
        ->firstOrFail();

        // Increment view count
        $product->increment('view_count');

        // Related products
        $relatedProducts = Product::with(['seller', 'category', 'productImages'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->where('is_approved', true)
            ->inRandomOrder()
            ->limit(6)
            ->get();

        // Get seller's other products
        $sellerProducts = Product::with(['category', 'productImages'])
            ->where('seller_id', $product->seller_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        return view('products.show', compact(
            'product', 
            'relatedProducts', 
            'sellerProducts'
        ));
    }

    public function byCategory($categorySlug) 
    {
        $category = Category::where('slug', $categorySlug)
            ->where('is_active', true)
            ->firstOrFail();

        $products = Product::with(['seller', 'category', 'productImages'])
            ->where('category_id', $category->id)
            ->where('status', 'active')
            ->where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = Category::where('is_active', true)->get();

        $recentSellers = Seller::withCount(['products' => function($query) use ($category) {
                $query->where('status', 'active')
                      ->where('is_approved', true)
                      ->where('category_id', $category->id);
            }])
            ->with(['user'])
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $trendingProducts = Product::with(['seller', 'category', 'productImages'])
            ->where('category_id', $category->id)
            ->where('status', 'active')
            ->where('is_approved', true)
            ->orderBy('view_count', 'desc')
            ->limit(5)
            ->get();

        return view('products.by-category', compact(
            'products', 
            'categories', 
            'category', 
            'recentSellers', 
            'trendingProducts'
        ));
    }

    public function featured() 
    {
        $products = Product::with(['seller', 'category', 'productImages'])
            ->where('status', 'active')
            ->where('is_approved', true)
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = Category::where('is_active', true)->get();

        $recentSellers = Seller::withCount(['products' => function($query) {
                $query->where('status', 'active')->where('is_approved', true);
            }])
            ->with(['user'])
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $trendingProducts = Product::with(['seller', 'category', 'productImages'])
            ->where('status', 'active')
            ->where('is_approved', true)
            ->orderBy('view_count', 'desc')
            ->limit(5)
            ->get();

        return view('products.featured', compact(
            'products', 
            'categories', 
            'recentSellers', 
            'trendingProducts'
        ));
    }

    public function search(Request $request) 
    {
        $request->validate([
            'q' => 'required|string|min:2|max:255'
        ]);

        $searchTerm = $request->get('q');

        $products = Product::with(['seller', 'category', 'productImages'])
            ->where('status', 'active')
            ->where('is_approved', true)
            ->where(function($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                      ->orWhere('description', 'like', '%' . $searchTerm . '%')
                      ->orWhere('name_sw', 'like', '%' . $searchTerm . '%')
                      ->orWhere('description_sw', 'like', '%' . $searchTerm . '%')
                      ->orWhere('sku', 'like', '%' . $searchTerm . '%')
                      ->orWhere('location', 'like', '%' . $searchTerm . '%')
                      ->orWhereHas('category', function($q) use ($searchTerm) {
                          $q->where('name', 'like', '%' . $searchTerm . '%')
                            ->orWhere('name_sw', 'like', '%' . $searchTerm . '%');
                      })
                      ->orWhereHas('seller', function($q) use ($searchTerm) {
                          $q->where('store_name', 'like', '%' . $searchTerm . '%')
                            ->orWhereHas('user', function($userQuery) use ($searchTerm) {
                                $userQuery->where('full_name', 'like', '%' . $searchTerm . '%');
                            });
                      });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = Category::where('is_active', true)->get();

        $recentSellers = Seller::withCount(['products' => function($query) {
                $query->where('status', 'active')->where('is_approved', true);
            }])
            ->with(['user'])
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $trendingProducts = Product::with(['seller', 'category', 'productImages'])
            ->where('status', 'active')
            ->where('is_approved', true)
            ->orderBy('view_count', 'desc')
            ->limit(5)
            ->get();

        $searchSuggestions = Product::where('status', 'active')
            ->where('is_approved', true)
            ->where('name', 'like', '%' . $searchTerm . '%')
            ->select('name')
            ->distinct()
            ->limit(5)
            ->get()
            ->pluck('name');

        return view('products.search', compact(
            'products', 
            'categories', 
            'searchTerm', 
            'recentSellers', 
            'trendingProducts',
            'searchSuggestions'
        ));
    }

    public function bySeller($sellerId)
    {
        $seller = Seller::with(['user', 'sellerProfile'])
            ->where('id', $sellerId)
            ->where('is_active', true)
            ->firstOrFail();

        $products = Product::with(['category', 'productImages'])
            ->where('seller_id', $seller->user_id)
            ->where('status', 'active')
            ->where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('products.by-seller', compact('products', 'seller'));
    }

    public function discounted()
    {
        $products = Product::with(['seller', 'category', 'productImages'])
            ->where('status', 'active')
            ->where('is_approved', true)
            ->whereNotNull('compare_price')
            ->whereRaw('compare_price > price')
            ->orderByRaw('(compare_price - price) / compare_price DESC')
            ->paginate(12);

        $categories = Category::where('is_active', true)->get();

        return view('products.discounted', compact('products', 'categories'));
    }

    public function newArrivals()
    {
        $products = Product::with(['seller', 'category', 'productImages'])
            ->where('status', 'active')
            ->where('is_approved', true)
            ->where('created_at', '>=', now()->subDays(30))
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = Category::where('is_active', true)->get();

        return view('products.new-arrivals', compact('products', 'categories'));
    }

    // API methods
    public function getFeaturedProducts()
    {
        $products = Product::with(['seller', 'category', 'productImages'])
            ->where('status', 'active')
            ->where('is_approved', true)
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        return response()->json($products);
    }

    public function getCategories()
    {
        $categories = Category::where('is_active', true)
            ->withCount(['products' => function($query) {
                $query->where('status', 'active')->where('is_approved', true);
            }])
            ->get();

        return response()->json($categories);
    }
}
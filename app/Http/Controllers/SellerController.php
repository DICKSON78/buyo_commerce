<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Seller;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Models\Message;
use App\Models\Conversation;
use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class SellerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get unread messages count for seller
     */
    private function getUnreadMessagesCount($user)
    {
        try {
            return Message::whereHas('conversation', function($query) use ($user) {
                $query->where('seller_user_id', $user->id);
            })->whereNull('read_at')
              ->where('user_id', '!=', $user->id)
              ->count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Seller Dashboard - COMPLETELY UPDATED WITH ALL VARIABLES
     */
    public function dashboard() {
        $user = Auth::user();

        if ($user->user_type !== 'seller') {
            return redirect()->route('register.seller')
                ->with('error', 'Tafadhali jisajili kama muuzaji kwanza.');
        }

        if (!$user->seller) {
            return redirect()->route('seller.register')
                ->with('error', 'Tafadhali kamilisha usajili wako kama muuzaji.');
        }

        $seller = $user->seller;

        // Calculate real stats
        $totalRevenue = Order::whereHas('items.product', function($query) use ($seller) {
            $query->where('seller_id', $seller->user_id);
        })->where('status', 'delivered')->sum('total_amount') ?? 0;

        $totalOrders = Order::whereHas('items.product', function($query) use ($seller) {
            $query->where('seller_id', $seller->user_id);
        })->count();

        $productCount = $seller->products()->count();

        $pendingOrders = Order::whereHas('items.product', function($query) use ($seller) {
            $query->where('seller_id', $seller->user_id);
        })->where('status', 'pending')->count();

        $unreadMessages = $this->getUnreadMessagesCount($user);

        // Calculate growth percentages
        $lastMonthRevenue = Order::whereHas('items.product', function($query) use ($seller) {
            $query->where('seller_id', $seller->user_id);
        })->where('status', 'delivered')
          ->where('created_at', '>=', Carbon::now()->subMonth())
          ->sum('total_amount') ?? 0;

        $previousMonthRevenue = Order::whereHas('items.product', function($query) use ($seller) {
            $query->where('seller_id', $seller->user_id);
        })->where('status', 'delivered')
          ->whereBetween('created_at', [Carbon::now()->subMonths(2), Carbon::now()->subMonth()])
          ->sum('total_amount') ?? 0;

        $revenueGrowth = $previousMonthRevenue > 0 ?
            (($lastMonthRevenue - $previousMonthRevenue) / $previousMonthRevenue) * 100 : 
            ($lastMonthRevenue > 0 ? 100 : 0);

        $lastMonthOrders = Order::whereHas('items.product', function($query) use ($seller) {
            $query->where('seller_id', $seller->user_id);
        })->where('created_at', '>=', Carbon::now()->subMonth())->count();

        $previousMonthOrders = Order::whereHas('items.product', function($query) use ($seller) {
            $query->where('seller_id', $seller->user_id);
        })->whereBetween('created_at', [Carbon::now()->subMonths(2), Carbon::now()->subMonth()])->count();

        $orderGrowth = $previousMonthOrders > 0 ?
            (($lastMonthOrders - $previousMonthOrders) / $previousMonthOrders) * 100 : 
            ($lastMonthOrders > 0 ? 100 : 0);

        // New products this week
        $newProducts = $seller->products()
            ->where('created_at', '>=', Carbon::now()->subWeek())
            ->count();

        // Calculate average order value
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Calculate conversion rate (simplified)
        $totalProductViews = $seller->products()->sum('view_count');
        $conversionRate = $totalProductViews > 0 ? ($totalOrders / $totalProductViews) * 100 : 0;

        // Calculate rating and reviews
        $reviews = Review::whereHas('product', function($query) use ($seller) {
            $query->where('seller_id', $seller->user_id);
        });

        $totalReviews = $reviews->count();
        $averageRating = $totalReviews > 0 ? $reviews->avg('rating') : 0;

        $stats = [
            'total_revenue' => $totalRevenue,
            'total_orders' => $totalOrders,
            'product_count' => $productCount,
            'rating' => round($averageRating, 1),
            'pending_orders' => $pendingOrders,
            'unread_messages' => $unreadMessages,
            'revenue_growth' => round($revenueGrowth, 1),
            'order_growth' => round($orderGrowth, 1),
            'new_products' => $newProducts,
            'average_order_value' => round($averageOrderValue, 2),
            'conversion_rate' => round($conversionRate, 2),
            'satisfaction_rate' => round($averageRating, 1),
            'total_reviews' => $totalReviews,
        ];

        // Recent orders (orders from customers who bought seller's products)
        $recentOrders = Order::whereHas('items.product', function($query) use ($seller) {
            $query->where('seller_id', $seller->user_id);
        })
        ->with(['user', 'items.product'])
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();

        // Recent products
        $recentProducts = $seller->products()
            ->with(['category', 'images'])
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // Recent messages
        $recentMessages = Conversation::where('seller_user_id', $user->id)
            ->with(['user', 'messages' => function($query) {
                $query->orderBy('created_at', 'desc')->limit(1);
            }])
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function($conversation) {
                $latestMessage = $conversation->messages->first();
                return [
                    'customer_name' => $conversation->user->username ?? 'Customer',
                    'customer_email' => $conversation->user->email ?? '',
                    'preview' => $latestMessage ? substr($latestMessage->content, 0, 50) . '...' : 'No messages',
                    'time_ago' => $latestMessage ? $latestMessage->created_at->diffForHumans() : $conversation->updated_at->diffForHumans(),
                ];
            });

        // Get all orders for the seller (for pagination)
        $allOrders = Order::whereHas('items.product', function($query) use ($seller) {
            $query->where('seller_id', $seller->user_id);
        })
        ->with(['user', 'items.product'])
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        // Get seller's purchase orders (orders where seller is the customer)
        $purchaseOrders = Order::where('user_id', $user->id)
            ->with(['items.product.seller'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get payments data for the seller
        $payments = Order::whereHas('items.product', function($query) use ($seller) {
            $query->where('seller_id', $seller->user_id);
        })
        ->where('status', '!=', 'cancelled')
        ->with(['user', 'items.product'])
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function($order) {
            return [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'amount' => $order->total_amount,
                'status' => $order->status === 'delivered' ? 'completed' : 'pending',
                'date' => $order->created_at,
                'customer_name' => $order->user->username ?? 'Customer'
            ];
        });

        // Get tracking orders (orders that are shipped or in transit)
        $trackingOrders = Order::whereHas('items.product', function($query) use ($seller) {
            $query->where('seller_id', $seller->user_id);
        })
        ->whereIn('status', ['shipped', 'processing'])
        ->with(['user', 'items.product'])
        ->orderBy('created_at', 'desc')
        ->get();

        // Get receipts (completed orders)
        $receipts = Order::whereHas('items.product', function($query) use ($seller) {
            $query->where('seller_id', $seller->user_id);
        })
        ->where('status', 'delivered')
        ->with(['user', 'items.product'])
        ->orderBy('created_at', 'desc')
        ->get();

        $categories = Category::where('is_active', true)->get();

        // Get recent sellers for sidebar
        $recentSellers = Seller::withCount(['products' => function($query) {
            $query->where('status', 'active');
        }])
        ->where('is_active', true)
        ->where('user_id', '!=', $seller->user_id)
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();

        return view('seller.dashboard', compact(
            'user',
            'seller',
            'stats',
            'recentOrders',
            'recentProducts',
            'recentMessages',
            'categories',
            'recentSellers',
            'allOrders',
            'purchaseOrders',
            'payments',
            'trackingOrders',
            'receipts',
            'unreadMessages'
        ));
    }

    /**
     * Seller's Purchase Orders - FIXED VERSION
     */
    public function myPurchaseOrders(Request $request) {
        $user = Auth::user();

        if ($user->user_type !== 'seller') {
            return redirect()->route('register.seller')
                ->with('error', 'Tafadhali jisajili kama muuzaji kwanza.');
        }

        $query = Order::where('user_id', $user->id)
            ->with(['items.product.seller']);

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('items.product', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $orders = $query->orderBy('created_at', 'desc')
            ->paginate(15);

        // Get unread messages count
        $unreadMessages = $this->getUnreadMessagesCount($user);

        // Get seller data if exists
        $seller = $user->seller;

        // Calculate stats for customer dashboard
        $stats = [
            'total_orders' => Order::where('user_id', $user->id)->count(),
            'total_spent' => Order::where('user_id', $user->id)->where('status', 'delivered')->sum('total_amount') ?? 0,
            'pending_orders' => Order::where('user_id', $user->id)->where('status', 'pending')->count(),
            'completed_orders' => Order::where('user_id', $user->id)->where('status', 'delivered')->count(),
            'average_order_value' => Order::where('user_id', $user->id)->count() > 0 ? 
                Order::where('user_id', $user->id)->sum('total_amount') / Order::where('user_id', $user->id)->count() : 0,
            'order_growth' => 0,
            'spending_growth' => 0,
        ];

        // Recent orders for customer dashboard
        $recentOrders = Order::where('user_id', $user->id)
            ->with(['items.product.seller'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // All orders for customer dashboard
        $allOrders = Order::where('user_id', $user->id)
            ->with(['items.product.seller'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Payments data
        $payments = Order::where('user_id', $user->id)
            ->where('status', '!=', 'cancelled')
            ->with(['items.product.seller'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($order) {
                return [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'amount' => $order->total_amount,
                    'status' => $order->status === 'delivered' ? 'completed' : 'pending',
                    'date' => $order->created_at,
                ];
            });

        // Tracking orders
        $trackingOrders = Order::where('user_id', $user->id)
            ->whereIn('status', ['shipped', 'processing'])
            ->with(['items.product.seller'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Receipts
        $receipts = Order::where('user_id', $user->id)
            ->where('status', 'delivered')
            ->with(['items.product.seller'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Recent messages (empty for now as this is purchase orders view)
        $recentMessages = collect([]);

        return view('customer.dashboard', compact(
            'orders', 
            'unreadMessages',
            'user',
            'seller',
            'stats',
            'recentOrders',
            'allOrders',
            'payments',
            'trackingOrders',
            'receipts',
            'recentMessages'
        ));
    }

    /**
     * Products Management
     */
    public function products(Request $request) {
        $user = Auth::user();

        if ($user->user_type !== 'seller' || !$user->seller) {
            return redirect()->route('register.seller')
                ->with('error', 'Tafadhali jisajili kama muuzaji kwanza.');
        }

        $seller = $user->seller;

        $query = $seller->products()->with(['category', 'images']);

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('status') && $request->status) {
            if ($request->status === 'active') {
                $query->where('status', 'active');
            } elseif ($request->status === 'inactive') {
                $query->where('status', 'inactive');
            } elseif ($request->status === 'out_of_stock') {
                $query->where('quantity', 0);
            }
        }

        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'name':
                $query->orderBy('name');
                break;
            case 'price_low':
                $query->orderBy('price');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('view_count', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);
        $categories = Category::where('is_active', true)->get();

        // Get unread messages count
        $unreadMessages = $this->getUnreadMessagesCount($user);

        return view('seller.products.index', compact(
            'products', 
            'categories',
            'unreadMessages',
            'user',
            'seller'
        ));
    }

    /**
     * Show add product form
     */
    public function createProduct() {
        $user = Auth::user();

        if ($user->user_type !== 'seller' || !$user->seller) {
            return redirect()->route('register.seller')
                ->with('error', 'Tafadhali jisajili kama muuzaji kwanza.');
        }

        $categories = Category::where('is_active', true)->get();
        
        // Get unread messages count
        $unreadMessages = $this->getUnreadMessagesCount($user);
        $seller = $user->seller;

        return view('seller.products.create', compact(
            'categories',
            'unreadMessages',
            'user',
            'seller'
        ));
    }

    /**
     * Store new product
     */
    public function storeProduct(Request $request) {
        $user = Auth::user();

        if ($user->user_type !== 'seller' || !$user->seller) {
            return redirect()->route('register.seller')
                ->with('error', 'Tafadhali jisajili kama muuzaji kwanza.');
        }

        $seller = $user->seller;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'images' => 'required|array|min:1|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'condition' => 'required|in:new,used,refurbished',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $imagePaths = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('products', 'public');
                    $imagePaths[] = $path;
                }
            }

            $product = Product::create([
                'seller_id' => $seller->user_id,
                'category_id' => $request->category_id,
                'name' => $request->name,
                'slug' => Str::slug($request->name) . '-' . uniqid(),
                'description' => $request->description,
                'price' => $request->price,
                'quantity' => $request->stock_quantity,
                'condition' => $request->condition,
                'status' => 'active',
                'is_approved' => true,
            ]);

            foreach ($imagePaths as $index => $imagePath) {
                \App\Models\ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'is_primary' => $index === 0, // First image is primary
                ]);
            }

            DB::commit();

            return redirect()->route('seller.products')
                ->with('success', 'Bidhaa imeongezwa kikamilifu!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Imeshindikana kuongeza bidhaa. Tafadhali jaribu tena.')
                ->withInput();
        }
    }

    /**
     * Edit product
     */
    public function editProduct($id) {
        $user = Auth::user();

        if ($user->user_type !== 'seller' || !$user->seller) {
            return redirect()->route('register.seller')
                ->with('error', 'Tafadhali jisajili kama muuzaji kwanza.');
        }

        $seller = $user->seller;

        $product = Product::where('seller_id', $seller->user_id)
            ->with('images')
            ->findOrFail($id);
        $categories = Category::where('is_active', true)->get();

        // Get unread messages count
        $unreadMessages = $this->getUnreadMessagesCount($user);

        return view('seller.products.edit', compact(
            'product', 
            'categories',
            'unreadMessages',
            'user',
            'seller'
        ));
    }

    /**
     * Update product
     */
    public function updateProduct(Request $request, $id) {
        $user = Auth::user();

        if ($user->user_type !== 'seller' || !$user->seller) {
            return redirect()->route('register.seller')
                ->with('error', 'Tafadhali jisajili kama muuzaji kwanza.');
        }

        $seller = $user->seller;

        $product = Product::where('seller_id', $seller->user_id)
            ->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'condition' => 'required|in:new,used,refurbished',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            if ($request->hasFile('images')) {
                // Delete old images
                foreach ($product->images as $image) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }

                // Upload new images
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('products', 'public');
                    \App\Models\ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_primary' => $index === 0,
                    ]);
                }
            }

            $product->update([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'slug' => Str::slug($request->name) . '-' . $product->id,
                'description' => $request->description,
                'price' => $request->price,
                'quantity' => $request->stock_quantity,
                'condition' => $request->condition,
                'status' => $request->boolean('is_active') ? 'active' : 'inactive',
            ]);

            DB::commit();

            return redirect()->route('seller.products')
                ->with('success', 'Bidhaa imesasishwa kikamilifu!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Imeshindikana kusasisha bidhaa. Tafadhali jaribu tena.')
                ->withInput();
        }
    }

    /**
     * Delete product
     */
    public function deleteProduct($id) {
        $user = Auth::user();

        if ($user->user_type !== 'seller' || !$user->seller) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $seller = $user->seller;

        $product = Product::where('seller_id', $seller->user_id)
            ->findOrFail($id);

        try {
            DB::beginTransaction();

            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }

            $product->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Bidhaa imefutwa kikamilifu!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Imeshindikana kufuta bidhaa.'
            ], 500);
        }
    }

    /**
     * Orders Management (Orders from customers who bought seller's products)
     */
    public function orders(Request $request) {
        $user = Auth::user();

        if ($user->user_type !== 'seller' || !$user->seller) {
            return redirect()->route('register.seller')
                ->with('error', 'Tafadhali jisajili kama muuzaji kwanza.');
        }

        $seller = $user->seller;

        $query = Order::whereHas('items.product', function($query) use ($seller) {
            $query->where('seller_id', $seller->user_id);
        })
        ->with(['user', 'items.product']);

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q) use ($request) {
                      $q->where('username', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $orders = $query->orderBy('created_at', 'desc')
            ->paginate(15);

        // Get unread messages count
        $unreadMessages = $this->getUnreadMessagesCount($user);

        return view('seller.orders.index', compact(
            'orders',
            'unreadMessages',
            'user',
            'seller'
        ));
    }

    /**
     * View order details (seller's sales order)
     */
    public function viewOrder($id) {
        $user = Auth::user();

        if ($user->user_type !== 'seller' || !$user->seller) {
            return redirect()->route('register.seller')
                ->with('error', 'Tafadhali jisajili kama muuzaji kwanza.');
        }

        $seller = $user->seller;

        $order = Order::whereHas('items.product', function($query) use ($seller) {
            $query->where('seller_id', $seller->user_id);
        })
        ->with(['user', 'items.product'])
        ->findOrFail($id);

        // Get unread messages count
        $unreadMessages = $this->getUnreadMessagesCount($user);

        return view('seller.orders.show', compact(
            'order',
            'unreadMessages',
            'user',
            'seller'
        ));
    }

    /**
     * View purchase order details (seller's purchase order)
     */
    public function viewPurchaseOrder($id) {
        $user = Auth::user();

        if ($user->user_type !== 'seller') {
            return redirect()->route('register.seller')
                ->with('error', 'Tafadhali jisajili kama muuzaji kwanza.');
        }

        $order = Order::where('user_id', $user->id)
            ->with(['items.product.seller', 'user'])
            ->findOrFail($id);

        // Get unread messages count
        $unreadMessages = $this->getUnreadMessagesCount($user);
        $seller = $user->seller;

        return view('seller.purchase-orders.show', compact(
            'order',
            'unreadMessages',
            'user',
            'seller'
        ));
    }

    /**
     * Update order status (seller's sales order)
     */
    public function updateOrderStatus(Request $request, $id) {
        $user = Auth::user();

        if ($user->user_type !== 'seller' || !$user->seller) {
            return redirect()->route('register.seller')
                ->with('error', 'Tafadhali jisajili kama muuzaji kwanza.');
        }

        $seller = $user->seller;

        $order = Order::whereHas('items.product', function($query) use ($seller) {
            $query->where('seller_id', $seller->user_id);
        })
        ->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $order->update(['status' => $request->status]);

            \App\Models\OrderHistory::create([
                'order_id' => $order->id,
                'status' => $request->status,
                'note' => 'Status updated by seller',
                'created_by' => Auth::id(),
            ]);

            if ($request->status === 'delivered') {
                $seller->increment('total_sales');
            }

            DB::commit();

            return redirect()->back()
                ->with('success', 'Hali ya agizo imesasishwa kikamilifu!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Imeshindikana kusasisha hali ya agizo. Tafadhali jaribu tena.');
        }
    }

    /**
     * Seller Profile
     */
    public function profile() {
        $user = Auth::user();

        if ($user->user_type !== 'seller' || !$user->seller) {
            return redirect()->route('register.seller')
                ->with('error', 'Tafadhali jisajili kama muuzaji kwanza.');
        }

        $seller = $user->seller;

        // Get unread messages count
        $unreadMessages = $this->getUnreadMessagesCount($user);

        return view('seller.profile', compact(
            'user', 
            'seller',
            'unreadMessages'
        ));
    }

    /**
     * Update seller profile
     */
    public function updateProfile(Request $request) {
        $user = Auth::user();

        if ($user->user_type !== 'seller' || !$user->seller) {
            return redirect()->route('register.seller')
                ->with('error', 'Tafadhali jisajili kama muuzaji kwanza.');
        }

        $seller = $user->seller;

        $validator = Validator::make($request->all(), [
            'store_name' => 'required|string|max:255|unique:sellers,store_name,' . $seller->id,
            'store_description' => 'nullable|string',
            'business_place' => 'required|string|max:255',
            'business_region' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|unique:users,phone,' . $user->id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            if ($request->hasFile('logo')) {
                if ($seller->logo) {
                    Storage::disk('public')->delete($seller->logo);
                }
                $logoPath = $request->file('logo')->store('sellers/logos', 'public');
                $seller->logo = $logoPath;
            }

            if ($request->hasFile('banner')) {
                if ($seller->banner) {
                    Storage::disk('public')->delete($seller->banner);
                }
                $bannerPath = $request->file('banner')->store('sellers/banners', 'public');
                $seller->banner = $bannerPath;
            }

            $seller->update([
                'store_name' => $request->store_name,
                'store_description' => $request->store_description,
                'business_place' => $request->business_place,
                'business_region' => $request->business_region,
            ]);

            $user->update([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'location' => $request->business_place,
                'region' => $request->business_region,
            ]);

            DB::commit();

            return redirect()->back()
                ->with('success', 'Wasifu umesasishwa kikamilifu!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Imeshindikana kusasisha wasifu. Tafadhali jaribu tena.');
        }
    }

    /**
     * Get dashboard stats for AJAX
     */
    public function getDashboardStats() {
        $user = Auth::user();

        if ($user->user_type !== 'seller' || !$user->seller) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $seller = $user->seller;

        if (!$seller) {
            return response()->json([
                'success' => false,
                'message' => 'Seller not found'
            ], 404);
        }

        $stats = [
            'total_revenue' => Order::whereHas('items.product', function($query) use ($seller) {
                $query->where('seller_id', $seller->user_id);
            })->where('status', 'delivered')->sum('total_amount') ?? 0,

            'total_orders' => Order::whereHas('items.product', function($query) use ($seller) {
                $query->where('seller_id', $seller->user_id);
            })->count(),

            'product_count' => $seller->products()->count(),

            'pending_orders' => Order::whereHas('items.product', function($query) use ($seller) {
                $query->where('seller_id', $seller->user_id);
            })->where('status', 'pending')->count(),
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }

    /**
     * Seller Conversations
     */
    public function conversations() {
        $user = Auth::user();

        if ($user->user_type !== 'seller') {
            return redirect()->route('register.seller')
                ->with('error', 'Tafadhali jisajili kama muuzaji kwanza.');
        }

        $conversations = Conversation::where('seller_user_id', $user->id)
            ->with(['user', 'messages' => function($query) {
                $query->orderBy('created_at', 'desc');
            }])
            ->orderBy('updated_at', 'desc')
            ->get();

        // Get unread messages count
        $unreadMessages = $this->getUnreadMessagesCount($user);
        $seller = $user->seller;

        return view('seller.conversations', compact(
            'conversations',
            'unreadMessages',
            'user',
            'seller'
        ));
    }
}
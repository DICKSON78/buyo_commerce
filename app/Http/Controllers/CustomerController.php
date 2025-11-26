<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Favorite;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class CustomerController extends Controller
{
    /**
     * Get unread messages count for customer
     */
    private function getUnreadMessagesCount($user)
    {
        if (!$user) {
            return 0;
        }

        try {
            return Message::whereHas('conversation', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->whereNull('read_at')
              ->where('user_id', '!=', $user->id)
              ->count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Get support tickets count for customer
     */
    private function getSupportTicketsCount($user)
    {
        if (!$user) {
            return 0;
        }

        try {
            // Assuming you have a SupportTicket model
            // return SupportTicket::where('user_id', $user->id)->where('status', 'open')->count();
            return 0; // Placeholder for now
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Create empty paginator for guest users
     */
    private function createEmptyPaginator($perPage = 10)
    {
        $items = collect([]);
        $currentPage = Paginator::resolveCurrentPage('page');
        $total = 0;
        
        return new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath()]
        );
    }

    /**
     * Customer Dashboard - PUBLIC ACCESS
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();

        // For guests, create temporary user data
        $isGuest = !$user;

        if ($isGuest) {
            $user = (object)[
                'id' => null,
                'username' => 'Guest',
                'user_type' => 'guest',
                'customer' => null
            ];
            $customer = null;
        } else {
            $customer = $user->customer;
        }

        // Calculate stats - for guests, show empty stats
        if ($isGuest) {
            $stats = [
                'total_orders' => 0,
                'total_spent' => 0,
                'pending_orders' => 0,
                'completed_orders' => 0,
                'cancelled_orders' => 0,
                'average_order_value' => 0,
                'order_growth' => 0,
                'spending_growth' => 0,
            ];

            $recentOrders = collect([]);
            $allOrders = $this->createEmptyPaginator(10); // Empty paginator instead of collection
            $payments = collect([]);
            $trackingOrders = collect([]);
            $receipts = collect([]);
            $recentMessages = collect([]);
            $unreadMessages = 0;
            $seller = null;
            $supportTicketsCount = 0;
        } else {
            // Calculate stats for authenticated users
            $totalOrders = Order::where('user_id', $user->id)->count();
            $totalSpent = Order::where('user_id', $user->id)->where('status', 'delivered')->sum('total_amount') ?? 0;
            $pendingOrders = Order::where('user_id', $user->id)->where('status', 'pending')->count();
            $completedOrders = Order::where('user_id', $user->id)->where('status', 'delivered')->count();
            $cancelledOrders = Order::where('user_id', $user->id)->where('status', 'cancelled')->count();

            // Calculate growth
            $lastMonthOrders = Order::where('user_id', $user->id)
                ->where('created_at', '>=', Carbon::now()->subMonth())
                ->count();

            $previousMonthOrders = Order::where('user_id', $user->id)
                ->whereBetween('created_at', [Carbon::now()->subMonths(2), Carbon::now()->subMonth()])
                ->count();

            $orderGrowth = $previousMonthOrders > 0 ?
                (($lastMonthOrders - $previousMonthOrders) / $previousMonthOrders) * 100 :
                ($lastMonthOrders > 0 ? 100 : 0);

            $lastMonthSpent = Order::where('user_id', $user->id)
                ->where('status', 'delivered')
                ->where('created_at', '>=', Carbon::now()->subMonth())
                ->sum('total_amount') ?? 0;

            $previousMonthSpent = Order::where('user_id', $user->id)
                ->where('status', 'delivered')
                ->whereBetween('created_at', [Carbon::now()->subMonths(2), Carbon::now()->subMonth()])
                ->sum('total_amount') ?? 0;

            $spendingGrowth = $previousMonthSpent > 0 ?
                (($lastMonthSpent - $previousMonthSpent) / $previousMonthSpent) * 100 :
                ($lastMonthSpent > 0 ? 100 : 0);

            $averageOrderValue = $totalOrders > 0 ? $totalSpent / $totalOrders : 0;

            $stats = [
                'total_orders' => $totalOrders,
                'total_spent' => $totalSpent,
                'pending_orders' => $pendingOrders,
                'completed_orders' => $completedOrders,
                'cancelled_orders' => $cancelledOrders,
                'average_order_value' => round($averageOrderValue, 2),
                'order_growth' => round($orderGrowth, 1),
                'spending_growth' => round($spendingGrowth, 1),
            ];

            // Recent orders
            $recentOrders = Order::where('user_id', $user->id)
                ->with(['items.product.seller'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            // All orders for pagination
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

            // Recent messages
            $recentMessages = Conversation::where('user_id', $user->id)
                ->with(['seller.user', 'messages' => function($query) {
                    $query->orderBy('created_at', 'desc')->limit(1);
                }])
                ->orderBy('updated_at', 'desc')
                ->limit(5)
                ->get()
                ->map(function($conversation) {
                    $latestMessage = $conversation->messages->first();
                    return [
                        'seller_name' => $conversation->seller->store_name ?? 'Seller',
                        'preview' => $latestMessage ? substr($latestMessage->content, 0, 50) . '...' : 'No messages',
                        'time_ago' => $latestMessage ? $latestMessage->created_at->diffForHumans() : $conversation->updated_at->diffForHumans(),
                    ];
                });

            // Get unread messages count
            $unreadMessages = $this->getUnreadMessagesCount($user);

            // Get support tickets count
            $supportTicketsCount = $this->getSupportTicketsCount($user);

            // Get seller data if exists
            $seller = $user->seller;
        }

        return view('customer.dashboard', compact(
            'user',
            'customer',
            'stats',
            'recentOrders',
            'allOrders',
            'payments',
            'trackingOrders',
            'receipts',
            'recentMessages',
            'unreadMessages',
            'seller',
            'isGuest',
            'supportTicketsCount'
        ));
    }

    /**
     * Customer Shop - PUBLIC ACCESS
     */
public function shop(Request $request)
{
    $user = Auth::user();
    $isGuest = !$user;

    $categories = Category::where('is_active', true)->get();
    $allOrders = $user ? $user->orders()->paginate(10) : [];

    $query = Product::with(['seller', 'images', 'category'])
        ->where('status', 'active')
        ->where('is_approved', true);

    // Search filter
    if ($request->has('search') && $request->search) {
        $query->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
    }

    // Category filter
    if ($request->has('category') && $request->category) {
        $query->where('category_id', $request->category);
    }

    // Price filter
    if ($request->has('min_price') && $request->min_price) {
        $query->where('price', '>=', $request->min_price);
    }
    if ($request->has('max_price') && $request->max_price) {
        $query->where('price', '<=', $request->max_price);
    }

    // Sort options
    $sort = $request->get('sort', 'newest');
    switch ($sort) {
        case 'price_low':
            $query->orderBy('price');
            break;
        case 'price_high':
            $query->orderBy('price', 'desc');
            break;
        case 'popular':
            $query->orderBy('view_count', 'desc');
            break;
        case 'name':
            $query->orderBy('name');
            break;
        default:
            $query->orderBy('created_at', 'desc');
    }

    $products = $query->paginate(12);

    $unreadMessages = $isGuest ? 0 : $this->getUnreadMessagesCount($user);
    $seller = $isGuest ? null : $user->seller;
    $supportTicketsCount = $isGuest ? 0 : $this->getSupportTicketsCount($user);
    
    // Add all the missing variables for the dashboard
    $payments = $user ? $user->payments()->get() : [];
    $receipts = $user ? $user->receipts()->get() : []; // Add this line
    $trackingOrders = $user ? $user->orders()->whereIn('status', ['shipped', 'in_transit'])->get() : [];

    return view('customer.dashboard', compact(
        'products',
        'categories',
        'unreadMessages',
        'user',
        'seller',
        'isGuest',
        'allOrders',
        'supportTicketsCount',
        'payments',
        'receipts', // Add this
        'trackingOrders' // Add this if missing
    ));
}

/**
 * Customer Profile - PUBLIC ACCESS (Redirects guests to products)
 */
    public function profile()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('products.index')
                ->with('info', 'Unaweza kuona bidhaa zote bila kujiandikisha. Kujiandikisha ni hiari tu.');
        }

        $customer = $user->customer;
        $unreadMessages = $this->getUnreadMessagesCount($user);
        $seller = $user->seller;
        $isGuest = false;
        $supportTicketsCount = $this->getSupportTicketsCount($user);

        return view('customer.profile', compact(
            'user',
            'customer',
            'unreadMessages',
            'seller',
            'isGuest',
            'supportTicketsCount'
        ));
    }

    /**
     * Update Customer Profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login.customer')
                ->with('error', 'Tafadhali ingia kwenye akaunti yako kwanza.');
        }

        $customer = $user->customer;

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|unique:users,phone,' . $user->id,
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'location' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Update user
            $user->update([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'location' => $request->location,
                'region' => $request->region,
            ]);

            // Handle profile picture upload
            $profilePicturePath = $customer->profile_picture;
            if ($request->hasFile('profile_picture')) {
                if ($profilePicturePath) {
                    Storage::disk('public')->delete($profilePicturePath);
                }
                $profilePicturePath = $request->file('profile_picture')->store('customers/profile-pictures', 'public');
            }

            // Calculate profile completion
            $completion = 20; // Base completion
            $fields = ['full_name', 'email', 'phone', 'date_of_birth', 'gender', 'location', 'address', 'city'];
            foreach ($fields as $field) {
                if (!empty($request->$field)) {
                    $completion += 10;
                }
            }
            $completion = min($completion, 100);

            // Update customer
            $customer->update([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'location' => $request->location,
                'region' => $request->region,
                'address' => $request->address,
                'city' => $request->city,
                'country' => $request->country,
                'profile_picture' => $profilePicturePath,
                'profile_completion' => $completion,
            ]);

            DB::commit();

            return redirect()->back()
                ->with('success', 'Wasifu umesasishwa kikamilifu!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Imeshindikana kusasisha wasifu. Tafadhali jaribu tena.')
                ->withInput();
        }
    }

    /**
     * Customer Orders - PUBLIC ACCESS
     */
    public function orders(Request $request)
    {
        $user = Auth::user();
        $isGuest = !$user;

        if ($isGuest) {
            // For guests, show empty orders page with info message
            $orders = $this->createEmptyPaginator(15); // Empty paginator instead of collection
            $unreadMessages = 0;
            $seller = null;
            $supportTicketsCount = 0;
        } else {
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

            $unreadMessages = $this->getUnreadMessagesCount($user);
            $seller = $user->seller;
            $supportTicketsCount = $this->getSupportTicketsCount($user);
        }

        return view('customer.orders', compact(
            'orders',
            'unreadMessages',
            'user',
            'seller',
            'isGuest',
            'supportTicketsCount'
        ));
    }

    /**
     * View Order Details - PUBLIC ACCESS
     */
    public function showOrder($id)
    {
        $user = Auth::user();
        $isGuest = !$user;

        if ($isGuest) {
            return redirect()->route('customer.orders')
                ->with('info', 'Tafadhali ingia kwenye akaunti yako kuona maelezo ya agizo.');
        }

        $order = Order::where('user_id', $user->id)
            ->with(['items.product.seller', 'user'])
            ->findOrFail($id);

        $unreadMessages = $this->getUnreadMessagesCount($user);
        $seller = $user->seller;
        $supportTicketsCount = $this->getSupportTicketsCount($user);

        return view('customer.order-details', compact(
            'order',
            'unreadMessages',
            'user',
            'seller',
            'isGuest',
            'supportTicketsCount'
        ));
    }

    /**
     * Customer Cart - PUBLIC ACCESS
     */
    public function viewCart()
    {
        $user = Auth::user();
        $isGuest = !$user;

        $unreadMessages = $isGuest ? 0 : $this->getUnreadMessagesCount($user);
        $seller = $isGuest ? null : $user->seller;
        $supportTicketsCount = $isGuest ? 0 : $this->getSupportTicketsCount($user);

        return view('customer.cart', compact(
            'user',
            'unreadMessages',
            'seller',
            'isGuest',
            'supportTicketsCount'
        ));
    }

    /**
     * Add to Cart - GUEST FRIENDLY
     */
    public function addToCart(Request $request)
    {
        // Guest users can add to cart without authentication
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data si sahihi.'
            ], 422);
        }

        try {
            // For guest users, we'll handle cart in session or localStorage
            // This is typically handled in the frontend JavaScript
            return response()->json([
                'success' => true,
                'message' => 'Bidhaa imeongezwa kwenye cart!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Imeshindikana kuongeza bidhaa kwenye cart.'
            ], 500);
        }
    }

    /**
     * Update Cart - GUEST FRIENDLY
     */
    public function updateCart(Request $request)
    {
        // Guest users can update cart without authentication
        // This is typically handled in the frontend JavaScript
        return response()->json([
            'success' => true,
            'message' => 'Cart imesasishwa!'
        ]);
    }

    /**
     * Remove from Cart - GUEST FRIENDLY
     */
    public function removeFromCart(Request $request)
    {
        // Guest users can remove from cart without authentication
        // This is typically handled in the frontend JavaScript
        return response()->json([
            'success' => true,
            'message' => 'Bidhaa imeondolewa kwenye cart!'
        ]);
    }

    /**
     * Checkout - PUBLIC ACCESS (GUEST FRIENDLY)
     */
/**
 * Checkout - PUBLIC ACCESS (GUEST FRIENDLY)
 */
public function checkout()
{
    $user = Auth::user();
    $isGuest = !$user;

    // For guests, create temporary user data
    if ($isGuest) {
        $user = (object)[
            'id' => null,
            'username' => 'Guest',
            'user_type' => 'guest',
            'customer' => null
        ];
        $cartItems = []; // Empty array for guests
    } else {
        // For authenticated users, get cart items from database or session
        $cartItems = []; // Placeholder - adjust based on your cart implementation
    }

    $unreadMessages = $isGuest ? 0 : $this->getUnreadMessagesCount($user);
    $seller = $isGuest ? null : $user->seller;
    $supportTicketsCount = $isGuest ? 0 : $this->getSupportTicketsCount($user);

    return view('products.checkout', compact(
        'user',
        'unreadMessages',
        'seller',
        'isGuest',
        'supportTicketsCount',
        'cartItems' // Add cartItems to the view
    ));
}

    /**
     * Place Order - GUEST FRIENDLY
     */
    public function placeOrder(Request $request)
    {
        $user = Auth::user();
        $isGuest = !$user;

        $validator = Validator::make($request->all(), [
            'shipping_address' => 'required|string|max:500',
            'payment_method' => 'required|in:cash,card,mobile_money',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email',
            'items' => 'required|array|min:1'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            if ($isGuest) {
                // Handle guest order
                // Create temporary user account or guest order record
                $guestOrderNumber = 'GST-' . time() . rand(100, 999);
                
                // Create order for guest
                $order = Order::create([
                    'order_number' => $guestOrderNumber,
                    'user_id' => null, // No user ID for guest orders
                    'total_amount' => $request->total_amount,
                    'status' => 'pending',
                    'payment_method' => $request->payment_method,
                    'shipping_address' => $request->shipping_address,
                    'customer_name' => $request->customer_name,
                    'customer_phone' => $request->customer_phone,
                    'customer_email' => $request->customer_email,
                    'is_guest_order' => true,
                ]);

                // Here you would also create order items
                // foreach ($request->items as $item) {
                //     OrderItem::create([...]);
                // }

                DB::commit();

                // Clear guest cart
                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Agizo lako limewekwa kikamilifu! Nambari yako ya agizo ni: ' . $guestOrderNumber,
                        'order_number' => $guestOrderNumber
                    ]);
                }

                return redirect()->route('customer.orders')
                    ->with('success', 'Agizo lako limewekwa kikamilifu! Nambari yako ya agizo ni: ' . $guestOrderNumber);

            } else {
                // Handle authenticated user order (existing logic)
                // Place order logic here for registered users
                // This would create an order record and order items

                DB::commit();

                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Agizo lako limewekwa kikamilifu!'
                    ]);
                }

                return redirect()->route('customer.orders')
                    ->with('success', 'Agizo lako limewekwa kikamilifu!');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Imeshindikana kuweka agizo. Tafadhali jaribu tena.'
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Imeshindikana kuweka agizo. Tafadhali jaribu tena.')
                ->withInput();
        }
    }

    /**
     * Customer Settings - PUBLIC ACCESS
     */
    public function settings()
    {
        $user = Auth::user();
        $isGuest = !$user;

        $unreadMessages = $isGuest ? 0 : $this->getUnreadMessagesCount($user);
        $seller = $isGuest ? null : $user->seller;
        $supportTicketsCount = $isGuest ? 0 : $this->getSupportTicketsCount($user);

        return view('customer.settings', compact(
            'user',
            'unreadMessages',
            'seller',
            'isGuest',
            'supportTicketsCount'
        ));
    }

    /**
     * Update Settings
     */
    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login.customer')
                ->with('error', 'Tafadhali ingia kwenye akaunti yako kwanza.');
        }

        $validator = Validator::make($request->all(), [
            'notifications' => 'nullable|boolean',
            'newsletter' => 'nullable|boolean',
            'language' => 'nullable|in:en,sw',
            'theme' => 'nullable|in:light,dark',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Update settings logic here
            // This would update user preferences

            return redirect()->back()
                ->with('success', 'Mipangilio imesasishwa kikamilifu!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Imeshindikana kusasisha mipangilio. Tafadhali jaribu tena.');
        }
    }

    /**
     * Customer Account - PUBLIC ACCESS
     */
    public function account()
    {
        $user = Auth::user();
        $isGuest = !$user;

        if ($isGuest) {
            return redirect()->route('products.index')
                ->with('info', 'Unaweza kuona bidhaa zote bila kujiandikisha. Kujiandikisha ni hiari tu.');
        }

        $unreadMessages = $this->getUnreadMessagesCount($user);
        $seller = $user->seller;
        $supportTicketsCount = $this->getSupportTicketsCount($user);

        return view('customer.account', compact(
            'user',
            'unreadMessages',
            'seller',
            'isGuest',
            'supportTicketsCount'
        ));
    }

    /**
     * Update Account
     */
    public function updateAccount(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login.customer')
                ->with('error', 'Tafadhali ingia kwenye akaunti yako kwanza.');
        }

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'current_password' => 'required_with:new_password',
            'new_password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Update username
            $user->update([
                'username' => $request->username,
            ]);

            // Update password if provided
            if ($request->new_password) {
                if (!Hash::check($request->current_password, $user->password)) {
                    return redirect()->back()
                        ->with('error', 'Nenosiri la sasa si sahihi.')
                        ->withInput();
                }

                $user->update([
                    'password' => Hash::make($request->new_password),
                ]);
            }

            return redirect()->back()
                ->with('success', 'Akaunti imesasishwa kikamilifu!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Imeshindikana kusasisha akaunti. Tafadhali jaribu tena.');
        }
    }

    /**
     * Customer Conversations
     */
    public function conversations()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login.customer')
                ->with('error', 'Tafadhali ingia kwenye akaunti yako kwanza kuona mazungumzo.');
        }

        $conversations = Conversation::where('user_id', $user->id)
            ->with(['seller.user', 'messages' => function($query) {
                $query->orderBy('created_at', 'desc');
            }])
            ->orderBy('updated_at', 'desc')
            ->get();

        $unreadMessages = $this->getUnreadMessagesCount($user);
        $seller = $user->seller;
        $isGuest = false;
        $supportTicketsCount = $this->getSupportTicketsCount($user);

        return view('customer.conversations', compact(
            'conversations',
            'unreadMessages',
            'user',
            'seller',
            'isGuest',
            'supportTicketsCount'
        ));
    }

    /**
     * Customer Favorites
     */
    public function favorites()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login.customer')
                ->with('error', 'Tafadhali ingia kwenye akaunti yako kwanza kuona orodha ya vipendiwe.');
        }

        $favorites = $user->favorites()
            ->with(['product.seller', 'product.images'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $unreadMessages = $this->getUnreadMessagesCount($user);
        $seller = $user->seller;
        $isGuest = false;
        $supportTicketsCount = $this->getSupportTicketsCount($user);

        return view('customer.favorites', compact(
            'favorites',
            'unreadMessages',
            'user',
            'seller',
            'isGuest',
            'supportTicketsCount'
        ));
    }

    /**
     * Add to Favorites
     */
    public function addToFavorites(Request $request, $productId)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Tafadhali ingia kwenye akaunti yako kwanza kuongeza kwenye vipendiwe.'
            ], 401);
        }

        try {
            $favorite = $user->favorites()->firstOrCreate([
                'product_id' => $productId
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Bidhaa imeongezwa kwenye orodha ya vipendiwe!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Imeshindikana kuongeza bidhaa kwenye vipendiwe.'
            ], 500);
        }
    }

    /**
     * Remove from Favorites
     */
    public function removeFromFavorites(Request $request, $productId)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Tafadhali ingia kwenye akaunti yako.'
            ], 401);
        }

        try {
            $user->favorites()->where('product_id', $productId)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Bidhaa imeondolewa kwenye orodha ya vipendiwe!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Imeshindikana kuondoa bidhaa kwenye vipendiwe.'
            ], 500);
        }
    }

    /**
     * Contact Seller from Product Page - PUBLIC ACCESS
     */
    public function contactSellerFromProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'message' => 'required|string|max:1000',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $product = Product::with('seller')->findOrFail($request->product_id);

            // Create conversation or send message logic here
            // This would typically create a conversation between guest and seller

            return redirect()->back()
                ->with('success', 'Ujumbe wako umetumwa kikamilifu kwa muuzaji!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Imeshindikana kutuma ujumbe. Tafadhali jaribu tena.')
                ->withInput();
        }
    }

    /**
     * Get Dashboard Stats for AJAX
     */
    public function getDashboardStats()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        $totalOrders = Order::where('user_id', $user->id)->count();
        $totalSpent = Order::where('user_id', $user->id)->where('status', 'delivered')->sum('total_amount') ?? 0;
        $pendingOrders = Order::where('user_id', $user->id)->where('status', 'pending')->count();
        $completedOrders = Order::where('user_id', $user->id)->where('status', 'delivered')->count();
        $supportTicketsCount = $this->getSupportTicketsCount($user);

        $stats = [
            'total_orders' => $totalOrders,
            'total_spent' => $totalSpent,
            'pending_orders' => $pendingOrders,
            'completed_orders' => $completedOrders,
            'support_tickets' => $supportTicketsCount,
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }

    /**
     * Get Seller Conversations for AJAX
     */
    public function getSellerConversations()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        $conversations = Conversation::where('user_id', $user->id)
            ->with(['seller', 'messages' => function($query) {
                $query->orderBy('created_at', 'desc')->limit(1);
            }])
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function($conversation) use ($user) {
                $latestMessage = $conversation->messages->first();
                $unreadCount = $conversation->messages()->whereNull('read_at')->where('user_id', '!=', $user->id)->count();
                
                return [
                    'id' => $conversation->id,
                    'seller_name' => $conversation->seller->store_name ?? 'Seller',
                    'last_message' => $latestMessage ? $latestMessage->content : 'No messages yet',
                    'last_message_time' => $latestMessage ? $latestMessage->created_at : $conversation->created_at,
                    'unread_count' => $unreadCount,
                ];
            });

        return response()->json([
            'success' => true,
            'conversations' => $conversations
        ]);
    }

    /**
     * Start Conversation with Seller
     */
    public function startConversation(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Tafadhali ingia kwenye akaunti yako kwanza.'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'seller_id' => 'required|exists:sellers,id',
            'product_id' => 'required|exists:products,id',
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data si sahihi.'
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Check if conversation already exists
            $conversation = Conversation::where('user_id', $user->id)
                ->where('seller_id', $request->seller_id)
                ->where('product_id', $request->product_id)
                ->first();

            if (!$conversation) {
                $conversation = Conversation::create([
                    'user_id' => $user->id,
                    'seller_id' => $request->seller_id,
                    'product_id' => $request->product_id,
                ]);
            }

            // Create message
            $message = Message::create([
                'conversation_id' => $conversation->id,
                'user_id' => $user->id,
                'content' => $request->message,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Ujumbe umetumwa kikamilifu!',
                'conversation_id' => $conversation->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Imeshindikana kutuma ujumbe. Tafadhali jaribu tena.'
            ], 500);
        }
    }

    /**
     * Send Message to Seller
     */
    public function sendMessageToSeller(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Tafadhali ingia kwenye akaunti yako kwanza.'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'conversation_id' => 'required|exists:conversations,id',
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data si sahihi.'
            ], 422);
        }

        try {
            $conversation = Conversation::where('user_id', $user->id)
                ->where('id', $request->conversation_id)
                ->firstOrFail();

            $message = Message::create([
                'conversation_id' => $conversation->id,
                'user_id' => $user->id,
                'content' => $request->message,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Ujumbe umetumwa kikamilifu!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Imeshindikana kutuma ujumbe. Tafadhali jaribu tena.'
            ], 500);
        }
    }

    /**
     * Send Message from Product Page
     */
    public function sendMessageFromProduct(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Tafadhali ingia kwenye akaunti yako kwanza.'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'seller_id' => 'required|exists:sellers,id',
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data si sahihi.'
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Check if conversation already exists
            $conversation = Conversation::where('user_id', $user->id)
                ->where('seller_id', $request->seller_id)
                ->where('product_id', $request->product_id)
                ->first();

            if (!$conversation) {
                $conversation = Conversation::create([
                    'user_id' => $user->id,
                    'seller_id' => $request->seller_id,
                    'product_id' => $request->product_id,
                ]);
            }

            // Create message
            $message = Message::create([
                'conversation_id' => $conversation->id,
                'user_id' => $user->id,
                'content' => $request->message,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Ujumbe umetumwa kikamilifu kwa muuzaji!',
                'conversation_id' => $conversation->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Imeshindikana kutuma ujumbe. Tafadhali jaribu tena.'
            ], 500);
        }
    }

    /**
     * Get Notifications for AJAX
     */
    public function getNotifications()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        // Get notifications logic here
        $notifications = []; // Placeholder

        return response()->json([
            'success' => true,
            'notifications' => $notifications
        ]);
    }

    /**
     * Mark Notification as Read
     */
    public function markNotificationAsRead(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        // Mark notification as read logic here

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read'
        ]);
    }

    /**
     * View Order for AJAX
     */
    public function viewOrder($id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        $order = Order::where('user_id', $user->id)
            ->with(['items.product.seller', 'user'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'status' => $order->status,
                'total_amount' => $order->total_amount,
                'order_date' => $order->created_at->format('d M Y'),
                'estimated_delivery' => $order->created_at->addDays(5)->format('d M Y'),
                'delivery_date' => $order->status === 'delivered' ? $order->updated_at->format('d M Y') : null,
                'payment_status' => $order->getPaymentStatus(),
                'shipping_address' => $order->shipping_address,
                'city' => $order->city,
                'country' => $order->country,
                'items' => $order->items->map(function($item) {
                    return [
                        'product_name' => $item->product->name ?? 'Product',
                        'quantity' => $item->quantity,
                        'subtotal' => number_format($item->price * $item->quantity, 2),
                    ];
                }),
            ]
        ]);
    }

    /**
     * Track Order for AJAX
     */
    public function trackOrder($id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        $order = Order::where('user_id', $user->id)
            ->with(['items.product.seller'])
            ->findOrFail($id);

        // Generate tracking steps based on order status
        $trackingSteps = $this->generateTrackingSteps($order);

        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'status' => $order->status,
                'tracking_steps' => $trackingSteps,
            ]
        ]);
    }

    /**
     * Generate Tracking Steps
     */
    private function generateTrackingSteps($order)
    {
        $steps = [
            [
                'title' => 'Order Placed',
                'description' => 'Your order has been received',
                'completed' => true,
                'date' => $order->created_at->format('d M Y, H:i'),
            ],
            [
                'title' => 'Order Confirmed',
                'description' => 'Seller has confirmed your order',
                'completed' => in_array($order->status, ['processing', 'shipped', 'delivered']),
                'date' => $order->created_at->addMinutes(30)->format('d M Y, H:i'),
            ],
            [
                'title' => 'Processing',
                'description' => 'Seller is preparing your order',
                'completed' => in_array($order->status, ['processing', 'shipped', 'delivered']),
                'date' => $order->created_at->addHours(1)->format('d M Y, H:i'),
            ],
            [
                'title' => 'Shipped',
                'description' => 'Your order has been shipped',
                'completed' => in_array($order->status, ['shipped', 'delivered']),
                'date' => $order->status === 'shipped' ? $order->updated_at->format('d M Y, H:i') : 'Pending',
            ],
            [
                'title' => 'Delivered',
                'description' => 'Your order has been delivered',
                'completed' => $order->status === 'delivered',
                'date' => $order->status === 'delivered' ? $order->updated_at->format('d M Y, H:i') : 'Pending',
            ],
        ];

        return $steps;
    }

    /**
     * Download Receipt for AJAX
     */
    public function downloadReceipt($id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        $order = Order::where('user_id', $user->id)
            ->with(['items.product.seller', 'user'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'receipt' => [
                'order_number' => $order->order_number,
                'order_date' => $order->created_at->format('d M Y'),
                'total_amount' => $order->total_amount,
                'items' => $order->items->map(function($item) {
                    return [
                        'name' => $item->product->name ?? 'Product',
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                    ];
                }),
            ]
        ]);
    }

    /**
     * Print Receipt for AJAX
     */
    public function printReceipt($id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        $order = Order::where('user_id', $user->id)
            ->with(['items.product.seller', 'user'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'order_number' => $order->order_number,
            'message' => 'Receipt ready for printing'
        ]);
    }

    /**
     * Guest Checkout Registration
     */
    public function guestCheckoutRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20|unique:users,phone',
            'password' => 'required|string|min:6|confirmed',
            'order_data' => 'required|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Create user account
            $user = User::create([
                'username' => $request->email,
                'full_name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'user_type' => 'customer',
                'terms_accepted' => true,
            ]);

            // Create customer record
            Customer::create([
                'id' => $user->id,
                'full_name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'profile_completion' => 50,
            ]);

            // Log in the user
            Auth::login($user);

            // Process the order with the new user account
            // Here you would process the order data from $request->order_data

            DB::commit();

            return redirect()->route('customer.orders')
                ->with('success', 'Akaunti yako imeundwa kikamilifu na agizo lako limewekwa!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Imeshindikana kukusanya agizo. Tafadhali jaribu tena.')
                ->withInput();
        }
    }
}
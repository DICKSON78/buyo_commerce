<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Conversation;
use App\Models\Message;
use Carbon\Carbon;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get unread messages count for customer
     */
    private function getUnreadMessagesCount($user)
    {
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
     * Customer Dashboard
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $customer = $user->customer;

        // Calculate stats
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

        // Get seller data if exists
        $seller = $user->seller;

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
            'seller'
        ));
    }

    /**
     * Customer Profile
     */
    public function profile()
    {
        $user = Auth::user();
        $customer = $user->customer;

        // Get unread messages count
        $unreadMessages = $this->getUnreadMessagesCount($user);

        // Get seller data if exists
        $seller = $user->seller;

        return view('customer.profile', compact(
            'user',
            'customer',
            'unreadMessages',
            'seller'
        ));
    }

    /**
     * Update Customer Profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
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
     * Customer Orders
     */
    public function orders(Request $request)
    {
        $user = Auth::user();

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

        return view('customer.orders', compact(
            'orders',
            'unreadMessages',
            'user',
            'seller'
        ));
    }

    /**
     * View Order Details
     */
    public function viewOrder($id)
    {
        $user = Auth::user();

        $order = Order::where('user_id', $user->id)
            ->with(['items.product.seller', 'user'])
            ->findOrFail($id);

        // Get unread messages count
        $unreadMessages = $this->getUnreadMessagesCount($user);

        // Get seller data if exists
        $seller = $user->seller;

        return view('customer.order-details', compact(
            'order',
            'unreadMessages',
            'user',
            'seller'
        ));
    }

    /**
     * Customer Conversations
     */
    public function conversations()
    {
        $user = Auth::user();

        $conversations = Conversation::where('user_id', $user->id)
            ->with(['seller.user', 'messages' => function($query) {
                $query->orderBy('created_at', 'desc');
            }])
            ->orderBy('updated_at', 'desc')
            ->get();

        // Get unread messages count
        $unreadMessages = $this->getUnreadMessagesCount($user);

        // Get seller data if exists
        $seller = $user->seller;

        return view('customer.conversations', compact(
            'conversations',
            'unreadMessages',
            'user',
            'seller'
        ));
    }

    /**
     * Customer Favorites
     */
    public function favorites()
    {
        $user = Auth::user();

        $favorites = $user->favorites()
            ->with(['product.seller', 'product.images'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // Get unread messages count
        $unreadMessages = $this->getUnreadMessagesCount($user);

        // Get seller data if exists
        $seller = $user->seller;

        return view('customer.favorites', compact(
            'favorites',
            'unreadMessages',
            'user',
            'seller'
        ));
    }

    /**
     * Add to Favorites
     */
    public function addToFavorites(Request $request, $productId)
    {
        $user = Auth::user();

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
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show checkout page
     */
    public function showCheckout()
    {
        $user = Auth::user();
        
        // Get cart items from session or database
        $cartItems = $this->getCartItems($user);
        
        if (empty($cartItems)) {
            return redirect()->route('products.index')
                ->with('error', 'Cart yako ni tupu. Ongeza bidhaa kwanza.');
        }

        // Calculate totals
        $subtotal = collect($cartItems)->sum(function($item) {
            return $item['price'] * $item['quantity'];
        });
        
        $shippingFee = 15000; // Fixed shipping fee
        $taxAmount = $subtotal * 0.18; // 18% VAT
        $totalAmount = $subtotal + $shippingFee + $taxAmount;

        return view('checkout.index', compact(
            'cartItems',
            'subtotal',
            'shippingFee',
            'taxAmount',
            'totalAmount'
        ));
    }

    /**
     * Process checkout
     */
    public function processCheckout(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'shipping_address_line1' => 'required|string|max:255',
            'shipping_address_line2' => 'nullable|string|max:255',
            'shipping_city' => 'required|string|max:255',
            'shipping_country' => 'required|string|max:255',
            'shipping_zip_code' => 'required|string|max:20',
            'payment_method' => 'required|in:cash_on_delivery,mobile_money,card',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Get cart items
        $cartItems = $this->getCartItems($user);
        
        if (empty($cartItems)) {
            return redirect()->route('products.index')
                ->with('error', 'Cart yako ni tupu. Ongeza bidhaa kwanza.');
        }

        try {
            DB::beginTransaction();

            // Calculate totals
            $subtotal = collect($cartItems)->sum(function($item) {
                return $item['price'] * $item['quantity'];
            });
            
            $shippingFee = 15000;
            $taxAmount = $subtotal * 0.18;
            $totalAmount = $subtotal + $shippingFee + $taxAmount;

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . Str::upper(Str::random(10)),
                'status' => 'pending',
                'total_amount' => $totalAmount,
                'shipping_fee' => $shippingFee,
                'tax_amount' => $taxAmount,
                'shipping_address_line1' => $request->shipping_address_line1,
                'shipping_address_line2' => $request->shipping_address_line2,
                'shipping_city' => $request->shipping_city,
                'shipping_country' => $request->shipping_country,
                'shipping_zip_code' => $request->shipping_zip_code,
            ]);

            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // Update product quantity
                $product = Product::find($item['id']);
                if ($product) {
                    $product->decrement('quantity', $item['quantity']);
                }
            }

            // Create order history
            \App\Models\OrderHistory::create([
                'order_id' => $order->id,
                'status' => 'pending',
                'note' => 'Order placed successfully',
                'created_by' => $user->id,
            ]);

            // Clear cart
            $this->clearCart($user);

            DB::commit();

            return redirect()->route('customer.orders')
                ->with('success', 'Umefanikiwa kuweka agizo! Namba yako ya agizo ni: ' . $order->order_number);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Imeshindikana kuweka agizo. Tafadhali jaribu tena.')
                ->withInput();
        }
    }

    /**
     * Get cart items from session or database
     */
    private function getCartItems($user)
    {
        // Try to get from session first
        $cartItems = session()->get('buyo_cart', []);

        // If session is empty, try to get from database
        if (empty($cartItems)) {
            $dbCartItems = Cart::where('user_id', $user->id)
                ->with('product')
                ->get()
                ->map(function($cartItem) {
                    return [
                        'id' => $cartItem->product_id,
                        'name' => $cartItem->product->name,
                        'price' => $cartItem->price,
                        'quantity' => $cartItem->quantity,
                    ];
                })
                ->toArray();

            $cartItems = $dbCartItems;
        }

        return $cartItems;
    }

    /**
     * Clear cart after successful order
     */
    private function clearCart($user)
    {
        // Clear session cart
        session()->forget('buyo_cart');

        // Clear database cart
        Cart::where('user_id', $user->id)->delete();
    }

    /**
     * Order confirmation page
     */
    public function confirmation($orderId)
    {
        $user = Auth::user();
        
        $order = Order::where('user_id', $user->id)
            ->with(['items.product.seller', 'user'])
            ->findOrFail($orderId);

        return view('checkout.confirmation', compact('order'));
    }
}
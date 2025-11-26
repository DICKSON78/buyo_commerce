<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
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

        // HAKIKISHA UNATUMA VARIABLE ZOTE
        return view('products.checkout', [
            'user' => $user,
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'shippingFee' => $shippingFee, // HII NI MUHIMU!
            'taxAmount' => $taxAmount,
            'totalAmount' => $totalAmount
        ]);
    }

    /**
     * Process checkout
     */
    public function processCheckout(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'shipping_region' => 'required|string|max:255',
            'shipping_city' => 'required|string|max:255',
            'shipping_address' => 'required|string|max:255',
            'shipping_method' => 'required|in:standard,express',
            'payment_method' => 'required|in:cash_on_delivery,mpesa,tigopesa,airtel,card',
            'additional_notes' => 'nullable|string',
            'delivery_instructions' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Tafadhali jaza sehemu zote zinazohitajika.',
                'errors' => $validator->errors()
            ], 422);
        }

        // Get cart items
        $cartItems = $this->getCartItems($user);
        
        if (empty($cartItems)) {
            return response()->json([
                'success' => false,
                'message' => 'Cart yako ni tupu. Ongeza bidhaa kwanza.'
            ], 400);
        }

        try {
            DB::beginTransaction();

            // Calculate totals
            $subtotal = collect($cartItems)->sum(function($item) {
                return $item['price'] * $item['quantity'];
            });
            
            $shippingFee = 15000;
            if ($request->shipping_method === 'express') {
                $shippingFee += 15000; // Express shipping extra charge
            }
            
            $taxAmount = $subtotal * 0.18;
            $totalAmount = $subtotal + $shippingFee + $taxAmount;

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . Str::upper(Str::random(10)),
                'status' => 'pending',
                'total_amount' => $totalAmount,
                'subtotal_amount' => $subtotal,
                'shipping_fee' => $shippingFee,
                'tax_amount' => $taxAmount,
                'customer_first_name' => $request->first_name,
                'customer_last_name' => $request->last_name,
                'customer_email' => $request->email,
                'customer_phone' => $request->phone,
                'shipping_region' => $request->shipping_region,
                'shipping_city' => $request->shipping_city,
                'shipping_address' => $request->shipping_address,
                'shipping_method' => $request->shipping_method,
                'payment_method' => $request->payment_method,
                'additional_notes' => $request->additional_notes,
                'delivery_instructions' => $request->delivery_instructions,
            ]);

            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'total_price' => $item['price'] * $item['quantity'],
                ]);

                // Update product quantity
                $product = Product::find($item['id']);
                if ($product) {
                    if ($product->quantity < $item['quantity']) {
                        throw new \Exception('Bidhaa ' . $product->name . ' haitoshi kwenye hisa.');
                    }
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

            return response()->json([
                'success' => true,
                'message' => 'Umefanikiwa kuweka agizo! Namba yako ya agizo ni: ' . $order->order_number,
                'order_number' => $order->order_number,
                'redirect_url' => route('customer.orders')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Imeshindikana kuweka agizo: ' . $e->getMessage()
            ], 500);
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
        if (empty($cartItems) && $user) {
            $dbCartItems = Cart::where('user_id', $user->id)
                ->with('product')
                ->get()
                ->map(function($cartItem) {
                    return [
                        'id' => $cartItem->product_id,
                        'name' => $cartItem->product->name,
                        'price' => $cartItem->product->price,
                        'quantity' => $cartItem->quantity,
                        'image' => $cartItem->product->images->first()->image_path ?? null,
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
        if ($user) {
            Cart::where('user_id', $user->id)->delete();
        }
    }

    /**
     * Order confirmation page
     */
    public function confirmation($orderId)
    {
        $user = Auth::user();
        
        $order = Order::where('user_id', $user->id)
            ->with(['items.product', 'user'])
            ->findOrFail($orderId);

        return view('checkout.confirmation', compact('order'));
    }
}
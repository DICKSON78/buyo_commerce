<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Seller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'seller_id' => 'required|exists:users,id',
            'message' => 'required|string|min:5|max:1000'
        ]);

        try {
            $product = Product::findOrFail($request->product_id);
            $seller = User::findOrFail($request->seller_id);
            
            // Check if user is messaging themselves
            if (Auth::id() === $seller->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot message yourself'
                ], 422);
            }

            // Find or create conversation
            $conversation = Conversation::where('user_id', Auth::id())
                ->where('seller_user_id', $seller->id)
                ->first();

            if (!$conversation) {
                $conversation = Conversation::create([
                    'user_id' => Auth::id(),
                    'seller_user_id' => $seller->id
                ]);
            }

            // Create message
            $message = Message::create([
                'conversation_id' => $conversation->id,
                'user_id' => Auth::id(),
                'content' => $request->message
            ]);

            // Send notification to seller (you can implement this later)
            // $this->sendNotificationToSeller($seller, $product, $request->message);

            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully!',
                'conversation_id' => $conversation->id
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send message. Please try again.'
            ], 500);
        }
    }

    public function index()
    {
        $user = Auth::user();
        
        // Get conversations where user is either the customer or seller
        $conversations = Conversation::with(['user', 'seller', 'messages' => function($query) {
            $query->orderBy('created_at', 'desc')->limit(1);
        }])
        ->where(function($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->orWhere('seller_user_id', $user->id);
        })
        ->orderBy('updated_at', 'desc')
        ->get();

        return view('messages.index', compact('conversations'));
    }

    public function conversation($sellerId)
    {
        $seller = User::findOrFail($sellerId);
        $user = Auth::user();

        // Find or create conversation
        $conversation = Conversation::with(['messages.user'])
            ->where('user_id', $user->id)
            ->where('seller_user_id', $seller->id)
            ->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'user_id' => $user->id,
                'seller_user_id' => $seller->id
            ]);
        }

        // Mark messages as read
        Message::where('conversation_id', $conversation->id)
            ->where('user_id', '!=', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('messages.conversation', compact('conversation', 'seller'));
    }

    public function sendMessage(Request $request, $sellerId)
    {
        $request->validate([
            'message' => 'required|string|min:1|max:1000'
        ]);

        $seller = User::findOrFail($sellerId);
        $user = Auth::user();

        $conversation = Conversation::where('user_id', $user->id)
            ->where('seller_user_id', $seller->id)
            ->firstOrFail();

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => $user->id,
            'content' => $request->message
        ]);

        // Update conversation updated_at
        $conversation->touch();

        return response()->json([
            'success' => true,
            'message' => $message->load('user')
        ]);
    }

    // Helper method to send notifications (to be implemented)
    private function sendNotificationToSeller($seller, $product, $message)
    {
        // You can implement email, push notifications, or in-app notifications here
        // For example:
        // Notification::send($seller, new NewMessageNotification($product, $message, Auth::user()));
    }
}
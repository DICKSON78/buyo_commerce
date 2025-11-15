<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login.seller')
                ->with('error', 'Tafadhali ingia kwanza.');
        }

        $user = Auth::user();

        // Ruhusu wateja NA wauzaji kufikia seller routes
        if (!in_array($user->user_type, ['customer', 'seller'])) {
            return redirect()->route('home')
                ->with('error', 'Huna ruhusa ya kufikia ukurasa huu.');
        }

        return $next($request);
    }
}
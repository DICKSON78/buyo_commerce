<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login.customer')
                ->with('error', 'Tafadhali ingia kwanza.');
        }

        $user = Auth::user();
        
        // Ruhusu customer NA seller kufikia customer routes
        if (!in_array($user->user_type, ['customer', 'seller'])) {
            return redirect()->route('home')
                ->with('error', 'Huna ruhusa ya kufikia ukurasa huu.');
        }

        return $next($request);
    }
}
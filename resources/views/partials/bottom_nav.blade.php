<!-- Bottom Navigation - For ALL devices (Mobile, Tablet, Desktop) -->
<div class="fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 z-40">
    <div class="flex justify-around items-center h-16 max-w-7xl mx-auto">
        <!-- Browser - ACCESSIBLE TO ALL -->
        <a href="{{ route('products.index') }}"
           class="flex flex-col items-center justify-center flex-1 {{ request()->routeIs('products.index') || request()->is('/') ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }} hover:text-green-600 dark:hover:text-green-400 transition-colors">
            <i class="fas fa-search text-lg mb-1"></i>
            <span class="text-xs font-medium">Browser</span>
        </a>

        <!-- My Orders - ACCESSIBLE TO ALL -->
        <a href="{{ route('customer.dashboard') }}"
           class="flex flex-col items-center justify-center flex-1 {{ request()->routeIs('customer.dashboard') || request()->routeIs('customer.orders*') ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }} hover:text-green-600 dark:hover:text-green-400 transition-colors">
            <i class="fas fa-shopping-bag text-lg mb-1"></i>
            <span class="text-xs font-medium">My Orders</span>
        </a>

        <!-- My Store - ONLY FOR SELLERS -->
        @auth
            @if(Auth::user()->user_type === 'seller')
                <a href="{{ route('seller.dashboard') }}"
                   class="flex flex-col items-center justify-center flex-1 {{ request()->routeIs('seller.dashboard') || (request()->is('seller/*') && !request()->routeIs('seller.my-purchase-orders') && !request()->routeIs('seller.profile') && !request()->routeIs('seller.settings')) ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }} hover:text-green-600 dark:hover:text-green-400 transition-colors">
                    <i class="fas fa-store text-lg mb-1"></i>
                    <span class="text-xs font-medium">My Store</span>
                </a>
            @endif
        @endauth

        <!-- Settings - ONLY FOR REGISTERED USERS (NOT GUESTS) -->
        @auth
            @if(Auth::user()->user_type === 'seller')
                <a href="{{ route('seller.settings') }}"
                   class="flex flex-col items-center justify-center flex-1 {{ request()->routeIs('seller.settings') ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }} hover:text-green-600 dark:hover:text-green-400 transition-colors">
                    <i class="fas fa-cog text-lg mb-1"></i>
                    <span class="text-xs font-medium">Settings</span>
                </a>
            @else
                <a href="{{ route('customer.settings') }}"
                   class="flex flex-col items-center justify-center flex-1 {{ request()->routeIs('customer.settings') ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }} hover:text-green-600 dark:hover:text-green-400 transition-colors">
                    <i class="fas fa-cog text-lg mb-1"></i>
                    <span class="text-xs font-medium">Settings</span>
                </a>
            @endif
        @endauth

        <!-- My Account - ONLY FOR REGISTERED USERS (NOT GUESTS) -->
        @auth
            @if(Auth::user()->user_type === 'seller')
                <a href="{{ route('seller.profile') }}"
                   class="flex flex-col items-center justify-center flex-1 {{ request()->routeIs('seller.profile') ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }} hover:text-green-600 dark:hover:text-green-400 transition-colors">
                    <i class="fas fa-user-circle text-lg mb-1"></i>
                    <span class="text-xs font-medium">My Account</span>
                </a>
            @else
                <a href="{{ route('customer.profile') }}"
                   class="flex flex-col items-center justify-center flex-1 {{ request()->routeIs('customer.profile') ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }} hover:text-green-600 dark:hover:text-green-400 transition-colors">
                    <i class="fas fa-user-circle text-lg mb-1"></i>
                    <span class="text-xs font-medium">My Account</span>
                </a>
            @endif
        @endauth
    </div>
</div>
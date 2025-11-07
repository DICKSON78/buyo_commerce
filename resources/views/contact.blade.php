@extends('layouts.app')

@section('title', 'About Us - BidhaaHub')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl font-bold text-center text-gray-900 mb-8">About BidhaaHub</h1>

        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <h2 class="text-2xl font-bold text-primary mb-4">Our Mission</h2>
            <p class="text-gray-600 leading-relaxed mb-6">
                BidhaaHub is Tanzania's premier online marketplace dedicated to connecting local sellers with buyers
                across the country. Our mission is to empower Tanzanian entrepreneurs and make buying and selling
                accessible to everyone.
            </p>

            <h2 class="text-2xl font-bold text-primary mb-4">What We Offer</h2>
            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <div class="flex items-start">
                    <div class="bg-primary rounded-full p-3 mr-4">
                        <i class="fas fa-store text-white"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-lg mb-2">For Sellers</h3>
                        <p class="text-gray-600">Reach more customers, manage your inventory, and grow your business with our easy-to-use platform.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="bg-secondary rounded-full p-3 mr-4">
                        <i class="fas fa-shopping-bag text-white"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-lg mb-2">For Buyers</h3>
                        <p class="text-gray-600">Discover unique products from local sellers, compare prices, and shop with confidence.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Customer;
use App\Models\Seller;
use App\Models\Category;
use App\Models\Region;

class AuthController extends Controller
{
    /**
     * Display choice page for login/register
     */
    public function choose()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->user_type === 'seller') {
                return redirect()->route('seller.dashboard');
            }
            return redirect()->route('customer.dashboard');
        }

        return view('auth.choose');
    }

    /**
     * Display customer login form
     */
    public function customerLogin()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->user_type === 'seller') {
                return redirect()->route('seller.dashboard');
            }
            return redirect()->route('customer.dashboard');
        }

        return view('customer.auth.login');
    }

    /**
     * Display customer registration form
     */
    public function customerRegister()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->user_type === 'seller') {
                return redirect()->route('seller.dashboard');
            }
            return redirect()->route('customer.dashboard');
        }

        $regions = Region::where('is_active', true)->get();
        return view('customer.auth.register', compact('regions'));
    }

    /**
     * Display seller login form
     */
    public function sellerLogin()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->user_type === 'customer') {
                return redirect()->route('customer.dashboard');
            }
            return redirect()->route('seller.dashboard');
        }

        return view('seller.auth.login');
    }

    /**
     * Display seller registration form
     */
    public function sellerRegister()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->user_type === 'customer') {
                $regions = Region::where('is_active', true)->get();
                return view('seller.auth.register', compact('regions'))->with('user', $user);
            }
            return redirect()->route('seller.dashboard');
        }

        $regions = Region::where('is_active', true)->get();
        return view('seller.auth.register', compact('regions'));
    }

    /**
     * Process customer registration
     */
    public function processCustomerRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users|max:255',
            'phone_country_code' => 'required|string|max:5',
            'phone_number' => 'required|string|max:15|unique:users,phone_number',
            'password' => 'required|string|min:6|confirmed',
            'terms' => 'required|accepted'
        ], [
            'username.required' => 'Username is required',
            'username.unique' => 'This username is already taken',
            'phone_number.required' => 'Phone number is required',
            'phone_number.unique' => 'This phone number is already registered',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 6 characters',
            'password.confirmed' => 'Passwords do not match',
            'terms.required' => 'You must accept the terms and conditions',
            'terms.accepted' => 'You must accept the terms and conditions'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            // Create user account with customer type
            $user = User::create([
                'username' => $request->username,
                'phone_country_code' => $request->phone_country_code,
                'phone_number' => $request->phone_number,
                'phone' => $request->phone_country_code . $request->phone_number,
                'password' => Hash::make($request->password),
                'user_type' => 'customer',
                'terms_accepted' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Create customer record
            Customer::create([
                'id' => $user->id,
                'full_name' => $request->username,
                'profile_completion' => 20,
                'sms_notifications' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            // Log in the user automatically after registration
            Auth::login($user);

            // Redirect back to intended URL or products page
            $intendedUrl = session('intended_url', route('products.index'));
            session()->forget('intended_url');

            return redirect($intendedUrl)
                ->with('success', 'Your account has been created successfully! Welcome to Buyo.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'An error occurred during registration. Please try again.')
                ->withInput();
        }
    }

    /**
     * Process seller registration
     */
    public function processSellerRegistration(Request $request)
    {
        $user = Auth::user();
        $isExistingCustomer = Auth::check() && $user->user_type === 'customer';

        // Create validation rules
        $validationRules = [
            'store_name' => 'required|string|max:255|unique:sellers,store_name',
            'business_place' => 'required|string|max:255',
            'region_id' => 'required|exists:regions,id',
            'terms' => 'required|accepted'
        ];

        $validationMessages = [
            'store_name.required' => 'Jina la duka linahitajika',
            'store_name.unique' => 'Jina la duka tayari limechukuliwa',
            'business_place.required' => 'Mahali pa biashara linahitajika',
            'region_id.required' => 'Mkoa wa biashara unahitajika',
            'terms.required' => 'Lazima ukubali sheria na masharti',
            'terms.accepted' => 'Lazima ukubali sheria na masharti'
        ];

        if (!$isExistingCustomer) {
            $validationRules['username'] = 'required|string|unique:users|max:255';
            $validationRules['phone_country_code'] = 'required|string|max:5';
            $validationRules['phone_number'] = 'required|string|max:15|unique:users,phone_number';
            $validationRules['password'] = 'required|string|min:6|confirmed';

            $validationMessages['username.required'] = 'Jina la mtumiaji linahitajika';
            $validationMessages['username.unique'] = 'Jina la mtumiaji tayari limechukuliwa';
            $validationMessages['phone_number.required'] = 'Namba ya simu inahitajika';
            $validationMessages['phone_number.unique'] = 'Namba ya simu tayari imesajiliwa';
            $validationMessages['password.required'] = 'Nenosiri linahitajika';
            $validationMessages['password.min'] = 'Nenosiri lazima liwe na herufi angalau 6';
            $validationMessages['password.confirmed'] = 'Nenosiri halifanani';
        } else {
            $validationRules['phone_country_code'] = 'required|string|max:5';
            $validationRules['phone_number'] = 'required|string|max:15';
        }

        $validator = Validator::make($request->all(), $validationRules, $validationMessages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $user = null;
            if ($isExistingCustomer) {
                // Existing customer wants to become seller
                $user = Auth::user();
                $user->update([
                    'user_type' => 'seller',
                    'phone_country_code' => $request->phone_country_code,
                    'phone_number' => $request->phone_number,
                    'phone' => $request->phone_country_code . $request->phone_number,
                    'updated_at' => now()
                ]);
            } else {
                // New seller registration
                $user = User::create([
                    'username' => $request->username,
                    'phone_country_code' => $request->phone_country_code,
                    'phone_number' => $request->phone_number,
                    'phone' => $request->phone_country_code . $request->phone_number,
                    'password' => Hash::make($request->password),
                    'user_type' => 'seller',
                    'terms_accepted' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            // Get region name
            $region = Region::find($request->region_id);

            // Create seller profile - CORRECTED
            Seller::create([
                'user_id' => $user->id, // Use user_id instead of id
                'store_name' => $request->store_name,
                'business_place' => $request->business_place,
                'business_region' => $region->name,
                'rating' => 0,
                'total_sales' => 0,
                'is_verified' => false,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // If this was a customer converting to seller, delete customer record
            if ($isExistingCustomer) {
                Customer::where('id', $user->id)->delete();
            }

            DB::commit();

            // Log in the user if not already logged in
            if (!Auth::check()) {
                Auth::login($user);
            }

            // Redirect to products page after successful registration
            return redirect()->route('products.index')
                ->with('success', 'Akaunti ya muuzaji imeundwa kikamilifu! Sasa unaweza kuuza bidhaa zako.');

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Seller registration error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Kumetokea kosa wakati wa usajili: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Process customer login
     */
    public function processCustomerLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $username = $credentials['username'];

        if (Auth::attempt(['username' => $username, 'password' => $credentials['password'], 'user_type' => 'customer'], $request->boolean('remember'))) {
            $request->session()->regenerate();

            $customer = Customer::find(Auth::id());
            if ($customer) {
                $customer->update(['last_login_at' => now()]);
            }

            return redirect()->route('customer.dashboard')
                ->with('success', 'Welcome back! You have successfully logged in.');
        }

        return back()->withErrors([
            'username' => 'Invalid username or password.',
        ])->onlyInput('username');
    }

    /**
     * Process seller login
     */
    public function processSellerLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $username = $credentials['username'];

        if (Auth::attempt(['username' => $username, 'password' => $credentials['password'], 'user_type' => 'seller'], $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->route('seller.dashboard')
                ->with('success', 'Welcome back to seller dashboard!');
        }

        return back()->withErrors([
            'username' => 'Invalid username or password.',
        ])->onlyInput('username');
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'You have been logged out successfully.');
    }

    /**
     * Get user status for AJAX requests
     */
    public function getUserStatus(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            return response()->json([
                'is_logged_in' => true,
                'user_type' => $user->user_type,
                'has_seller_profile' => $user->seller ? true : false,
                'username' => $user->username
            ]);
        }

        return response()->json([
            'is_logged_in' => false,
            'user_type' => null,
            'has_seller_profile' => false,
            'username' => null
        ]);
    }

    /**
     * Store intended URL for guest checkout
     */
    public function storeIntendedUrl(Request $request)
    {
        $request->validate([
            'intended_url' => 'required|string'
        ]);

        session(['intended_url' => $request->intended_url]);

        return response()->json(['success' => true]);
    }
}

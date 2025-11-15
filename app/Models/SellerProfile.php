<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerProfile extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'seller_profiles';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'shop_name',
        'description',
        'contact_number',
        'address',
        'logo',
        'banner',
        'website',
        'social_media_links',
        'business_hours',
        'is_verified',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'social_media_links' => 'array',
        'business_hours' => 'array',
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // Add any hidden attributes if needed
    ];

    /**
     * Get the user that owns the seller profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the seller associated with the profile.
     */
    public function seller()
    {
        return $this->belongsTo(Seller::class, 'user_id', 'user_id');
    }

    /**
     * Get the products for the seller.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id', 'user_id');
    }

    /**
     * Get the conversations for the seller.
     */
    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'seller_user_id', 'user_id');
    }

    /**
     * Scope a query to only include active sellers.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include verified sellers.
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Get the seller's full address.
     */
    public function getFullAddressAttribute()
    {
        return $this->address ?: 'Address not specified';
    }

    /**
     * Get the seller's contact information.
     */
    public function getContactInfoAttribute()
    {
        return [
            'phone' => $this->contact_number,
            'address' => $this->full_address,
        ];
    }

    /**
     * Check if seller is open for business based on business hours.
     */
    public function isOpen()
    {
        if (empty($this->business_hours)) {
            return true; // Assume open if no business hours specified
        }

        $currentDay = strtolower(now()->englishDayOfWeek);
        $currentTime = now()->format('H:i');

        if (isset($this->business_hours[$currentDay])) {
            $hours = $this->business_hours[$currentDay];
            
            if ($hours['closed'] ?? false) {
                return false;
            }

            if (isset($hours['open']) && isset($hours['close'])) {
                return $currentTime >= $hours['open'] && $currentTime <= $hours['close'];
            }
        }

        return true;
    }

    /**
     * Get the seller's rating from the seller table.
     */
    public function getRatingAttribute()
    {
        return $this->seller->rating ?? 0;
    }

    /**
     * Get the seller's total sales from the seller table.
     */
    public function getTotalSalesAttribute()
    {
        return $this->seller->total_sales ?? 0;
    }

    /**
     * Get the seller's store name from the seller table.
     */
    public function getStoreNameAttribute()
    {
        return $this->seller->store_name ?? $this->shop_name;
    }

    /**
     * Get the seller's business place from the seller table.
     */
    public function getBusinessPlaceAttribute()
    {
        return $this->seller->business_place ?? null;
    }

    /**
     * Get the seller's business region from the seller table.
     */
    public function getBusinessRegionAttribute()
    {
        return $this->seller->business_region ?? null;
    }

    /**
     * Get the seller's verification status from the seller table.
     */
    public function getIsVerifiedAttribute()
    {
        return $this->seller->is_verified ?? false;
    }

    /**
     * Get the seller's active status from the seller table.
     */
    public function getIsActiveAttribute()
    {
        return $this->seller->is_active ?? true;
    }

    /**
     * Get the number of active products for this seller.
     */
    public function getActiveProductsCountAttribute()
    {
        return $this->products()->where('status', 'active')->count();
    }

    /**
     * Get the seller's profile completion percentage.
     */
    public function getProfileCompletionAttribute()
    {
        $fields = [
            'shop_name' => !empty($this->shop_name),
            'description' => !empty($this->description),
            'contact_number' => !empty($this->contact_number),
            'address' => !empty($this->address),
            'logo' => !empty($this->logo),
        ];

        $completed = array_sum($fields);
        $total = count($fields);

        return ($completed / $total) * 100;
    }

    /**
     * Update seller profile with validation.
     */
    public function updateProfile(array $data)
    {
        $allowedFields = [
            'shop_name',
            'description',
            'contact_number',
            'address',
            'website',
            'social_media_links',
            'business_hours',
        ];

        $updateData = array_intersect_key($data, array_flip($allowedFields));

        return $this->update($updateData);
    }

    /**
     * Upload and set seller logo.
     */
    public function setLogo($logoFile)
    {
        if ($this->logo) {
            // Delete old logo
            \Storage::disk('public')->delete($this->logo);
        }

        $path = $logoFile->store('sellers/logos', 'public');
        $this->update(['logo' => $path]);

        return $path;
    }

    /**
     * Upload and set seller banner.
     */
    public function setBanner($bannerFile)
    {
        if ($this->banner) {
            // Delete old banner
            \Storage::disk('public')->delete($this->banner);
        }

        $path = $bannerFile->store('sellers/banners', 'public');
        $this->update(['banner' => $path]);

        return $path;
    }

    /**
     * Get seller's social media links as array.
     */
    public function getSocialMediaLinksAttribute($value)
    {
        if (is_string($value)) {
            return json_decode($value, true) ?? [];
        }

        return $value ?? [];
    }

    /**
     * Set seller's social media links as JSON.
     */
    public function setSocialMediaLinksAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['social_media_links'] = json_encode($value);
        } else {
            $this->attributes['social_media_links'] = $value;
        }
    }

    /**
     * Get seller's business hours as array.
     */
    public function getBusinessHoursAttribute($value)
    {
        if (is_string($value)) {
            return json_decode($value, true) ?? $this->getDefaultBusinessHours();
        }

        return $value ?? $this->getDefaultBusinessHours();
    }

    /**
     * Set seller's business hours as JSON.
     */
    public function setBusinessHoursAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['business_hours'] = json_encode($value);
        } else {
            $this->attributes['business_hours'] = $value;
        }
    }

    /**
     * Get default business hours structure.
     */
    protected function getDefaultBusinessHours()
    {
        return [
            'monday' => ['open' => '08:00', 'close' => '18:00'],
            'tuesday' => ['open' => '08:00', 'close' => '18:00'],
            'wednesday' => ['open' => '08:00', 'close' => '18:00'],
            'thursday' => ['open' => '08:00', 'close' => '18:00'],
            'friday' => ['open' => '08:00', 'close' => '18:00'],
            'saturday' => ['open' => '09:00', 'close' => '16:00'],
            'sunday' => ['closed' => true],
        ];
    }

    /**
     * Get seller's statistics.
     */
    public function getStatsAttribute()
    {
        return [
            'total_products' => $this->products()->count(),
            'active_products' => $this->active_products_count,
            'total_orders' => $this->seller->total_sales ?? 0,
            'rating' => $this->rating,
            'profile_completion' => $this->profile_completion,
        ];
    }

    /**
     * Boot function for model events.
     */
    protected static function boot()
    {
        parent::boot();

        // When a seller profile is created, also create/update the seller record
        static::created(function ($sellerProfile) {
            $seller = Seller::where('user_id', $sellerProfile->user_id)->first();
            
            if (!$seller) {
                Seller::create([
                    'user_id' => $sellerProfile->user_id,
                    'store_name' => $sellerProfile->shop_name,
                    'store_description' => $sellerProfile->description,
                    'business_place' => $sellerProfile->user->location ?? 'Unknown',
                    'business_region' => $sellerProfile->user->region ?? 'Unknown',
                    'is_verified' => false,
                    'is_active' => true,
                ]);
            }
        });

        // When a seller profile is updated, also update the seller record
        static::updated(function ($sellerProfile) {
            $seller = Seller::where('user_id', $sellerProfile->user_id)->first();
            
            if ($seller) {
                $seller->update([
                    'store_name' => $sellerProfile->shop_name,
                    'store_description' => $sellerProfile->description,
                ]);
            }
        });
    }
}
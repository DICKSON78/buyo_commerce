<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'capital',
        'population',
        'area',
        'is_active',
        'description',
        'latitude',
        'longitude',
        'zone',
        'district_count',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'population' => 'integer',
        'area' => 'decimal:2',
        'is_active' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'district_count' => 'integer',
    ];

    /**
     * Get the users for the region.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the sellers for the region.
     */
    public function sellers(): HasMany
    {
        return $this->hasMany(Seller::class, 'business_region_id');
    }

    /**
     * Get the customers for the region.
     */
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    /**
     * Get the products for the region.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Scope a query to only include active regions.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order regions by name.
     */
    public function scopeOrderByName($query)
    {
        return $query->orderBy('name');
    }

    /**
     * Scope a query to search regions by name or capital.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
              ->orWhere('capital', 'like', '%' . $search . '%');
        });
    }

    /**
     * Get the population density of the region.
     */
    public function getPopulationDensityAttribute(): float
    {
        if ($this->area && $this->area > 0) {
            return round($this->population / $this->area, 2);
        }
        
        return 0;
    }

    /**
     * Get the formatted area with unit.
     */
    public function getFormattedAreaAttribute(): string
    {
        return number_format($this->area) . ' km²';
    }

    /**
     * Get the formatted population.
     */
    public function getFormattedPopulationAttribute(): string
    {
        if ($this->population >= 1000000) {
            return round($this->population / 1000000, 1) . 'M';
        } elseif ($this->population >= 1000) {
            return round($this->population / 1000, 1) . 'K';
        }
        
        return number_format($this->population);
    }

    /**
     * Check if region has high population density.
     */
    public function getIsDenselyPopulatedAttribute(): bool
    {
        return $this->population_density > 100;
    }

    /**
     * Get regions by zone.
     */
    public static function getByZone(string $zone)
    {
        return static::where('zone', $zone)->active()->orderByName()->get();
    }

    /**
     * Get popular regions (with most users).
     */
    public static function getPopularRegions($limit = 10)
    {
        return static::withCount('users')
            ->active()
            ->orderBy('users_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get regions with statistics.
     */
    public static function getWithStatistics()
    {
        return static::withCount(['users', 'sellers', 'products'])
            ->active()
            ->orderByName()
            ->get();
    }
}
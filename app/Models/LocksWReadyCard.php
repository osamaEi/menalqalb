<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocksWReadyCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'photo',
        'name_ar',
        'name_en',
        'desc_ar',
        'desc_en',
        'price',
        'points',
        'type',
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'points' => 'integer',
        'is_active' => 'boolean'
    ];

    public function getNameAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->name_ar : $this->name_en;
    }

    public function getDescriptionAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->desc_ar : $this->desc_en;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Add this method to the LocksWReadyCard model
public function requests()
{
    return $this->hasMany(Request::class);
}

// Add these methods to get request statistics
public function getPendingRequestsCountAttribute()
{
    return $this->requests()->pending()->count();
}

public function getCompletedRequestsCountAttribute()
{
    return $this->requests()->completed()->count();
}

public function getTotalRequestedQuantityAttribute()
{
    return $this->requests()->sum('quantity');
}

public function getTotalRevenueAttribute()
{
    return $this->requests()->completed()->sum('total_price');
}
}
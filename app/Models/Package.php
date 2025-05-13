<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_ar',
        'title_en',
        'amount',
        'price',
        'is_active'
    ];

    protected $casts = [
        'amount' => 'integer',
        'price' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    // Accessors
    public function getTitleAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->title_ar : $this->title_en;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
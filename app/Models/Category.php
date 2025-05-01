<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'image',
        'name_ar',
        'name_en',
        'is_main',
        'parent_id',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_main' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the parent category.
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the subcategories.
     */
    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Get the products in this category.
     */
  
    /**
     * Get the category name based on the current locale.
     */
    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        return $locale == 'ar' ? $this->name_ar : $this->name_en;
    }

    /**
     * Scope a query to only include main categories.
     */
    public function scopeMain($query)
    {
        return $query->where('is_main', true);
    }

    /**
     * Scope a query to only include subcategories.
     */
    public function scopeSubcategories($query)
    {
        return $query->where('is_main', false);
    }

    /**
     * Scope a query to only include active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include inactive categories.
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Get all parent categories.
     */
    public static function getParentCategories()
    {
        return self::whereNull('parent_id')->orderBy('name_en')->get();
    }
}
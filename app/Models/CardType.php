<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'icon',
        'name_ar',
        'name_en',
        'photo',
        'type',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the cards associated with this card type.
     */
    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    /**
     * Get the card type name based on the current locale.
     */
    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        return $locale == 'ar' ? $this->name_ar : $this->name_en;
    }

    /**
     * Scope a query to only include active card types.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include inactive card types.
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Scope a query to filter by type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Get available card type options.
     */
    public static function getTypeOptions()
    {
        return [
            'image' => 'Image',
            'video' => 'Video',
            'animated_image' => 'Animated Image'
        ];
    }

    /**
     * Get available icon options.
     */
    public static function getIconOptions()
    {
        return [
            'ri-heart-line' => 'Heart',
            'ri-cake-2-line' => 'Cake',
            'ri-gift-line' => 'Gift',
            'ri-mail-send-line' => 'Mail',
            'ri-calendar-event-line' => 'Calendar',
            'ri-film-line' => 'Film',
            'ri-star-line' => 'Star',
            'ri-user-heart-line' => 'User Heart',
            'ri-user-smile-line' => 'User Smile',
            'ri-emotion-happy-line' => 'Happy Face',
            'ri-parent-line' => 'Family',
            'ri-home-heart-line' => 'Home Heart',
            'ri-briefcase-4-line' => 'Briefcase',
            'ri-graduation-cap-line' => 'Graduation Cap',
            'ri-flower-line' => 'Flower',
            'ri-sparkling-line' => 'Sparkle',
            'ri-trophy-line' => 'Trophy',
            'ri-medal-line' => 'Medal',
            'ri-hearts-line' => 'Hearts',
            'ri-game-line' => 'Game',
            'ri-music-2-line' => 'Music',
            'ri-book-open-line' => 'Book',
            'ri-building-2-line' => 'Building',
            'ri-magic-line' => 'Magic Wand',
            'ri-rainbow-line' => 'Rainbow',
            'ri-sun-line' => 'Sun',
            'ri-moon-line' => 'Moon',
            'ri-cloud-line' => 'Cloud',
            'ri-shopping-bag-line' => 'Shopping Bag',
            'ri-shopping-cart-line' => 'Shopping Cart'
        ];
    }
}
<?php

namespace App\Models;

use App\Models\User;
use App\Models\CardType;
use App\Models\Category;
use App\Models\ReadyCard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Card extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'file_path',
        'language',
        'main_category_id',
        'sub_category_id',
        'card_type_id',
        'title',
        'cost_price',
        'selling_price',
        'usage_count',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'cost_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'usage_count' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the designer who created the card.
     */
    public function user()
    {
        return $this->belongsTo(User::class); 
    }

    /**
     * Get the main category of the card.
     */
    public function mainCategory()
    {
        return $this->belongsTo(Category::class, 'main_category_id');
    }

    /**
     * Get the sub category of the card.
     */
    public function subCategory()
    {
        return $this->belongsTo(Category::class, 'sub_category_id');
    }

    /**
     * Get the card type.
     */
    public function cardType()
    {
        return $this->belongsTo(CardType::class);
    }

    /**
     * Get the ready cards based on this card.
     */
    public function readyCards()
    {
        return $this->hasMany(ReadyCard::class);
    }

    /**
     * Scope a query to only include active cards.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include inactive cards.
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Scope a query to only include cards of a specific language.
     */
    public function scopeLanguage($query, $language)
    {
        return $query->where('language', $language);
    }

    /**
     * Scope a query to only include cards of a specific type.
     */
    public function scopeOfType($query, $cardTypeId)
    {
        return $query->where('card_type_id', $cardTypeId);
    }

    /**
     * Scope a query to only include cards of a specific main category.
     */
    public function scopeMainCategory($query, $mainCategoryId)
    {
        return $query->where('main_category_id', $mainCategoryId);
    }

    /**
     * Scope a query to only include cards of a specific sub category.
     */
    public function scopeSubCategory($query, $subCategoryId)
    {
        return $query->where('sub_category_id', $subCategoryId);
    }

    /**
     * Scope a query to only include cards of a specific designer.
     */
    public function scopeDesigner($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Get the file extension.
     */
    public function getFileExtensionAttribute()
    {
        return pathinfo($this->file_path, PATHINFO_EXTENSION);
    }

    /**
     * Determine if the card is an image.
     */
    public function getIsImageAttribute()
    {
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'];
        return in_array(strtolower($this->file_extension), $imageExtensions);
    }

    /**
     * Determine if the card is a video.
     */
    public function getIsVideoAttribute()
    {
        $videoExtensions = ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm', 'mkv'];
        return in_array(strtolower($this->file_extension), $videoExtensions);
    }

    /**
     * Get available language options.
     */
    public static function getLanguageOptions()
    {
        return [
            'en' => 'English',
            'ar' => 'العربية', // Arabic
            'fr' => 'Français', // French
            'es' => 'Español', // Spanish
            'de' => 'Deutsch', // German
            'it' => 'Italiano', // Italian
            'ru' => 'Русский', // Russian
            'zh' => '中文', // Chinese
            'ja' => '日本語', // Japanese
            'ko' => '한국어', // Korean
            'pt' => 'Português', // Portuguese
            'tr' => 'Türkçe', // Turkish
            'hi' => 'हिन्दी', // Hindi
            'ur' => 'اردو', // Urdu
        ];
    }

    /**
     * Get the profit margin as a percentage.
     */
    public function getProfitMarginAttribute()
    {
        if ($this->cost_price == 0) {
            return 100;
        }
        
        return round((($this->selling_price - $this->cost_price) / $this->cost_price) * 100, 2);
    }
}
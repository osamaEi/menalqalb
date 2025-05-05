<?php

namespace App\Models;

use App\Models\Card;
use App\Models\User;
use App\Models\ReadyCardItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReadyCard extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'card_count',
        'customer_id',
        'received_card_image',
        'cost',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'card_count' => 'integer',
        'cost' => 'decimal:2',
    ];

    /**
     * Get the customer who ordered the ready cards.
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Get the ready card items for the ready card.
     */
    public function items()
    {
        return $this->hasMany(ReadyCardItem::class);
    }

    /**
     * Get the cards included in this ready card set.
     */
  
    /**
     * Get the full URL for the received card image.
     */
    public function getReceivedCardImageUrlAttribute()
    {
        return $this->received_card_image ? url('storage/' . $this->received_card_image) : null;
    }

    /**
     * Scope a query to filter by customer.
     */
    public function scopeByCustomer($query, $customerId)
    {
        return $query->where('customer_id', $customerId);
    }

    /**
     * Scope a query to order by newest.
     */
    public function scopeNewest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope a query to order by oldest.
     */
    public function scopeOldest($query)
    {
        return $query->orderBy('created_at', 'asc');
    }
}

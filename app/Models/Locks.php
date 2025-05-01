<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locks extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'supplier',
        'cost',
        'image',
        'quantity',
        'notes',
        'invoice_image',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'cost' => 'decimal:2',
        'quantity' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the invoice items for the lock.
     */
    public function invoiceItems()
    {
        return $this->morphMany(InvoiceItem::class, 'itemable');
    }

    /**
     * Decrement the quantity when a lock is sold.
     */
    public function decrementQuantity($amount = 1)
    {
        if ($this->quantity >= $amount) {
            $this->decrement('quantity', $amount);
            return true;
        }
        return false;
    }

    /**
     * Increment the quantity when locks are added.
     */
    public function incrementQuantity($amount = 1)
    {
        $this->increment('quantity', $amount);
        return true;
    }

    /**
     * Scope a query to only include active locks.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include inactive locks.
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Scope a query to only include locks that are in stock.
     */
    public function scopeInStock($query)
    {
        return $query->where('quantity', '>', 0);
    }

    /**
     * Scope a query to only include locks that are out of stock.
     */
    public function scopeOutOfStock($query)
    {
        return $query->where('quantity', '<=', 0);
    }

    /**
     * Scope a query to order by quantity (ascending).
     */
    public function scopeOrderByQuantityAsc($query)
    {
        return $query->orderBy('quantity', 'asc');
    }

    /**
     * Scope a query to order by quantity (descending).
     */
    public function scopeOrderByQuantityDesc($query)
    {
        return $query->orderBy('quantity', 'desc');
    }

    /**
     * Get the full URL for the lock image.
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? url('storage/' . $this->image) : null;
    }

    /**
     * Get the full URL for the invoice image.
     */
    public function getInvoiceImageUrlAttribute()
    {
        return $this->invoice_image ? url('storage/' . $this->invoice_image) : null;
    }
}
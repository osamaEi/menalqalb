<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'payment_intent_id',
        'order_id',
        'amount',
        'currency',
        'status',
        'redirect_url',
        'error_message',
        'type', // Added type field: 'package', 'card', 'lock'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /**
     * Get the user that owns the payment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include payments of a specific type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Check if payment is for a package.
     */
    public function isPackagePayment()
    {
        return $this->type === 'package';
    }

    /**
     * Check if payment is for a card.
     */
    public function isCardPayment()
    {
        return $this->type === 'card';
    }

    /**
     * Check if payment is for a lock.
     */
    public function isLockPayment()
    {
        return $this->type === 'lock';
    }
}
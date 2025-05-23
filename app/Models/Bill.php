<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_id',
        'type',
        'entity_id',
        'entity_name',
        'amount',
        'currency',
        'quantity',
        'status',
    ];

    /**
     * Get the user that owns the bill.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the payment associated with the bill.
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
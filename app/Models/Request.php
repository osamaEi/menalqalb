<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'locks_w_ready_card_id',
        'name',
        'email',
        'address',
        'phone',
        'quantity',
        'status',
        'total_price',
        'total_points'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'total_price' => 'decimal:2',
        'total_points' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationships
    public function locksWReadyCard()
    {
        return $this->belongsTo(LocksWReadyCard::class);
    }

    // Accessors
    public function getStatusColorAttribute()
    {
        return [
            'pending' => 'warning',
            'processing' => 'info',
            'approved' => 'primary',
            'rejected' => 'danger',
            'completed' => 'success'
        ][$this->status] ?? 'secondary';
    }

    public function getStatusLabelAttribute()
    {
        return ucfirst($this->status);
    }

    // Mutators
    public function setTotalPriceAttribute($value)
    {
        $this->attributes['total_price'] = $value ?: ($this->quantity * $this->locksWReadyCard->price);
    }

    public function setTotalPointsAttribute($value)
    {
        $this->attributes['total_points'] = $value ?: ($this->quantity * $this->locksWReadyCard->points);
    }

    // Boot method to calculate totals automatically
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($request) {
            if (!$request->total_price && $request->locks_w_ready_card_id) {
                $item = LocksWReadyCard::find($request->locks_w_ready_card_id);
                if ($item) {
                    $request->total_price = $request->quantity * $item->price;
                    $request->total_points = $request->quantity * $item->points;
                }
            }
        });

        static::updating(function ($request) {
            if ($request->isDirty('quantity') || $request->isDirty('locks_w_ready_card_id')) {
                $item = LocksWReadyCard::find($request->locks_w_ready_card_id);
                if ($item) {
                    $request->total_price = $request->quantity * $item->price;
                    $request->total_points = $request->quantity * $item->points;
                }
            }
        });
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Methods
    public function approve()
    {
        $this->update(['status' => 'approved']);
    }

    public function reject()
    {
        $this->update(['status' => 'rejected']);
    }

    public function markAsProcessing()
    {
        $this->update(['status' => 'processing']);
    }

    public function markAsCompleted()
    {
        $this->update(['status' => 'completed']);
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    // Calculate total with different quantity
    public function calculateTotal($quantity = null)
    {
        $qty = $quantity ?: $this->quantity;
        return [
            'price' => $qty * $this->locksWReadyCard->price,
            'points' => $qty * $this->locksWReadyCard->points
        ];
    }
}
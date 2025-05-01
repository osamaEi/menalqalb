<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadyCardItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ready_card_id',
        'card_id',
    ];

    /**
     * Get the ready card that owns the item.
     */
    public function readyCard()
    {
        return $this->belongsTo(ReadyCard::class);
    }

    /**
     * Get the card that is included in this item.
     */
    public function card()
    {
        return $this->belongsTo(Card::class);
    }
}
<?php

namespace App\Models;

use App\Models\ReadyCard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'identity_number',
        'qr_code',
        'sequence_number',
        'unique_identifier',
        'status',
    ];
    
    /**
     * Get the ready card that owns the item.
     */
    public function readyCard()
    {
        return $this->belongsTo(ReadyCard::class);
    }
    
    /**
     * Check if the card is open.
     */
    public function isOpen()
    {
        return $this->status === 'open';
    }
    
    /**
     * Check if the card is closed.
     */
    public function isClosed()
    {
        return $this->status === 'closed';
    }
    
    /**
     * Open the card.
     */
    public function open()
    {
        $this->update(['status' => 'open']);
    }
    
    /**
     * Close the card.
     */
    public function close()
    {
        $this->update(['status' => 'closed']);
    }
}
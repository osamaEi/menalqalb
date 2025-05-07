<?php

namespace App\Models;

use App\Models\Card;
use App\Models\User;
use App\Models\Category;
use App\Models\DedicationType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipient_language',
        'main_category_id',
        'sub_category_id',
        'dedication_type_id',
        'ready_card_item_id',
        'card_number',
        'card_id',
        'message_content',
        'sender_name',
        'sender_phone',
        'recipient_name',
        'lock_type', // 'no_lock', 'lock_without_heart', 'lock_with_heart'
        'recipient_phone',
        'unlock_code',
        'scheduled_at',
        'manually_sent',
        'status',
        'user_id',
        'sales_outlet_id',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'manually_sent' => 'boolean',
    ];

    protected $appends = [
        'masked_unlock_code',
    ];

    /**
     * Get the user who created the message.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the sales outlet associated with the message.
     */
    // public function salesOutlet()
    // {
    //     return $this->belongsTo(SalesOutlet::class);
    // }

    /**
     * Get the main category of the message.
     */
    public function mainCategory()
    {
        return $this->belongsTo(Category::class, 'main_category_id');
    }

    /**
     * Get the sub category of the message.
     */
    public function subCategory()
    {
        return $this->belongsTo(Category::class, 'sub_category_id');
    }

    /**
     * Get the dedication type of the message.
     */
    public function dedicationType()
    {
        return $this->belongsTo(DedicationType::class);
    }

    /**
     * Get the card associated with the message.
     */
    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    /**
     * Get the masked unlock code (show only last 3 digits).
     */
    public function getMaskedUnlockCodeAttribute()
    {
        if (!$this->unlock_code) {
            return null;
        }
        
        $codeLength = strlen($this->unlock_code);
        if ($codeLength <= 3) {
            return $this->unlock_code;
        }
        
        return str_repeat('*', $codeLength - 3) . substr($this->unlock_code, -3);
    }

    /**
     * Generate a random unlock code.
     */
    public function generateUnlockCode()
    {
        $this->unlock_code = mt_rand(100000, 999999);
        return $this->unlock_code;
    }
}
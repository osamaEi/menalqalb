<?php

// app/Models/Locker.php
namespace App\Models;

use App\Models\User;
use App\Models\LockerItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Locker extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'quantity', 'price', 'photo'];

    public function items()
    {
        return $this->hasMany(LockerItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
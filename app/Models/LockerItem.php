<?php
// app/Models/LockerItem.php
namespace App\Models;

use App\Models\Locker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LockerItem extends Model
{
    use HasFactory;

    protected $fillable = ['locker_id', 'number_locker', 'status'];

    protected $casts = [
        'status' => 'string',
    ];

    public const STATUS_OPEN = 'open';
    public const STATUS_CLOSED = 'closed';
    public const STATUS_CANCELED = 'canceled';

    public static function statuses(): array
    {
        return [
            self::STATUS_OPEN => 'Open',
            self::STATUS_CLOSED => 'Closed',
            self::STATUS_CANCELED => 'Canceled',
        ];
    }

    public function locker()
    {
        return $this->belongsTo(Locker::class);
    }
}
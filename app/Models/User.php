<?php

namespace App\Models;

use App\Models\Request;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
//use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'country_id',
        'whatsapp',
        'email_verified',
        'whatsapp_verified',
        'user_type',
        'company_name',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'email_verified' => 'boolean',
        'whatsapp_verified' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    // In app/Models/User.php

    public function requests()
    {
        return $this->hasMany(Request::class);
    }

    // Add these helper methods
    public function pendingRequests()
    {
        return $this->requests()->where('status', 'pending');
    }

    public function completedRequests()
    {
        return $this->requests()->where('status', 'completed');
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    /**
     * Get the ready cards ordered by the user.
     */
    public function readyCards()
    {
        return $this->hasMany(ReadyCard::class, 'customer_id');
    }

    /**
     * Scope a query to only include admin users.
     */
    public function scopeAdmin($query)
    {
        return $query->where('user_type', 'admin');
    }

    /**
     * Scope a query to only include privileged users.
     */
    public function scopePrivilegedUser($query)
    {
        return $query->where('user_type', 'privileged_user');
    }

    /**
     * Scope a query to only include regular users.
     */
    public function scopeRegularUser($query)
    {
        return $query->where('user_type', 'regular_user');
    }

    /**
     * Scope a query to only include designer users.
     */
    public function scopeDesigner($query)
    {
        return $query->where('user_type', 'designer');
    }

    /**
     * Scope a query to only include sales point users.
     */
    public function scopeSalesPoint($query)
    {
        return $query->where('user_type', 'sales_point');
    }

    /**
     * Scope a query to only include active users.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include inactive users.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Scope a query to only include blocked users.
     */
    public function scopeBlocked($query)
    {
        return $query->where('status', 'blocked');
    }

    /**
     * Scope a query to only include deleted users.
     */
    public function scopeDeleted($query)
    {
        return $query->where('status', 'deleted');
    }
}
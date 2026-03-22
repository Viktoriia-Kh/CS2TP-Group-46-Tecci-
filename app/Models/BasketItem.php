<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasketItem extends Model
{
    use HasFactory;

    protected $table = 'basket_items';

    /**
     * Attributes that are mass assignable
     */
    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'quantity',
    ];

    /**
     * Attributes that should be cast
     */
    protected $casts = [
        'quantity' => 'integer',
    ];

    /**
     * Relationship - A basket item belongs to a user (nullable for guests)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship - A basket item belongs to a product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope - Get basket items for a specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId)->whereNull('session_id');
    }

    /**
     * Scope - Get basket items for a specific session (guest)
     */
    public function scopeForSession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId)->whereNull('user_id');
    }

    /**
     * Scope - Get all items for current user or session
     * Main method used in the controller
     */
    public function scopeForCurrentUserOrSession($query, $userId = null, $sessionId = null)
    {
        if ($userId) {
            return $query->forUser($userId);
        } elseif ($sessionId) {
            return $query->forSession($sessionId);
        }
        return $query->whereRaw('1 = 0'); // Return empty if neither provided
    }
}

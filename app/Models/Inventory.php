<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    // Allow to assign these fields 
    protected $fillable = [
        'product_id',
        'quantity_available',
        'reorder_threshold',
        'last_reordered',
    ];

    // Inventory belongs to one product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
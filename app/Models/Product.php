<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'brand',
        'description',
        'price',
        'student_price',
        'image_url',
    ];


    // A product BELONGS TO one category.
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Product can only have one inventory record
    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }

    // Allows us to keep track of our stock logic
    public function getStockStatusAttribute()
    {
        if (!$this->inventory) {
            return 'unknown';
        }

        $qty = $this->inventory->quantity_available;
        $threshold = $this->inventory->reorder_threshold;

        if ($qty <= 0) {
            return 'out_of_stock';
        }

        if ($qty <= $threshold) {
            return 'low_stock';
        }

        return 'in_stock';
    }
}
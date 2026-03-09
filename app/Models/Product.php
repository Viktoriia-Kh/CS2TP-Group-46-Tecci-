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

    // Product belongs to one category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Product has one inventory record
    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }

    // FinalSub: Product can have many images
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // FinalSub: Product can have many specs
    public function specs()
    {
        return $this->hasMany(ProductSpec::class);
    }

    // FinalSub: Product can have many reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

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
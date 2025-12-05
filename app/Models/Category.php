<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Allow to assign these fields 
    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    // A catagory will have many products
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
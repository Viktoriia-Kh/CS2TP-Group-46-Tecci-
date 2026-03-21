<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
protected $fillable = [
    'name',
    'rating',
    'message',
    'is_approved',
    'product_id',
    'user_id',
    'review_text'
];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(ReviewImage::class);
    }
}

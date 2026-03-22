<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteReview extends Model
{
    protected $table = 'website_reviews';

    protected $fillable = [
        'name',
        'rating',
        'message',
        'is_approved',
    ];
}
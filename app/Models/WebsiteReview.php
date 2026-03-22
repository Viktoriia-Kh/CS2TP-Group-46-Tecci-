<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteReview extends Model
{
    protected $fillable = [
        'name',
        'rating',
        'message',
        'is_approved',
    ];
}
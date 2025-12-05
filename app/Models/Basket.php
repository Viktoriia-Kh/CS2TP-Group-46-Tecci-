<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Basket extends Model
{
    //
 use HasFactory;

    protected $table = 'basket';

    // Allow these fields to be filled
    protected $fillable = ['product', 'price', 'quantity', 'image_url'];
}

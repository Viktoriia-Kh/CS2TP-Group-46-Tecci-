<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatCategory extends Model
{
    protected $fillable = ['title', 'sort_order', 'is_active'];

    public function faqs(): HasMany
    {
        return $this->hasMany(ChatFaq::class, 'category_id');
    }
}

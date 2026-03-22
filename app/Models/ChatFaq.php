<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatFaq extends Model
{
    protected $fillable = ['category_id', 'question', 'answer', 'sort_order', 'is_active'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ChatCategory::class, 'category_id');
    }
}

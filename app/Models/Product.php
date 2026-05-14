<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Product extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'name', 'description', 'price', 'stock',
        'category_id', 'image_path', 'is_active'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}

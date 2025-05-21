<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    protected $casts = [
        'images' => 'array',
    ];

    public function product_variant()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function developer()
    {
        return $this->belongsTo(Developer::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $guarded = [];

    protected $casts = [
        'images' => 'array',
        'public_facilities' => 'array',
    ];

    public function product_variant(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function developer()
    {
        return $this->belongsTo(Developer::class);
    }

    public function deleteImages()
    {
        foreach ($this->images ?? [] as $image) {
            Storage::disk('public')->delete($image);
        }


        $variant = $this->product_variant ?? collect();

        if (count($variant) > 0) {
            foreach ($variant as $var) {
                foreach ($var['images'] as $img) {
                    Storage::disk('public')->delete($img);
                };
                $var->delete();
            }
        }
    }
}

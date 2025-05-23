<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Sale extends Model
{
    protected $guarded = [];
    protected $casts = [
        'product' => 'object',
        'attachment' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deleteAttachment()
    {
        foreach ($this->attachment ?? [] as $image) {
            Storage::disk('public')->delete($image);
        }
    }

    public function product_variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function coordinator()
    {
        return $this->belongsTo(Coordinator::class, 'agent_coordinator');
    }

    public function developer()
    {
        return $this->belongsTo(Developer::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function principal()
    {
        return $this->belongsToMany(User::class,'principal_sale')->withPivot(['commission_fee', 'is_payment', 'ppn', 'pph']);
    }
}

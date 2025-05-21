<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $guarded = [];
    protected $casts = [
        'product' => 'object',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

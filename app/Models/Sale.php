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

    public function deleteAttachment(){
        foreach ($this->attachment ?? [] as $image) {
            Storage::disk('public')->delete($image);
        }
    }
}

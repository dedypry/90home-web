<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    protected $guarded = [];

    public function coordinators()
    {
        return $this->hasMany(Coordinator::class);
    }
}

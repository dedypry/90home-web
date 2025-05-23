<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
    public function developer()
    {
        return $this->belongsTo(Developer::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'invoice_principal')->withPivot(['commission_fee', 'is_payment', 'ppn', 'pph']);
    }
}

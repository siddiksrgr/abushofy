<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Confirmation extends Model
{
    protected $guarded= [
        'id'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function shipping()
    { 
        return $this->hasOne(Shipping::class);
    }
}
 
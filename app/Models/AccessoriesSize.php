<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessoriesSize extends Model
{
    protected $guarded= [
        'id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function stock()
    {
        return $this->hasOne(AccessoriesStock::class);
    }
}

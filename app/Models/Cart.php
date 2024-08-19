<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded= [
        'id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function accessories_size()
    {
        return $this->belongsTo(AccessoriesSize::class);
    }

    public function clothing_size()
    {
        return $this->belongsTo(ClothingSize::class);
    }
}

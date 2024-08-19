<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 

class TransactionDetail extends Model
{
    
    protected $guarded= [
        'id'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
     
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function accessories_size()
    {
        return $this->belongsTo(AccessoriesSize::class);
    }

    public function clothing_size()
    {
        return $this->belongsTo(ClothingSize::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function complain()
    {
        return $this->hasOne(Complain::class);
    }
}

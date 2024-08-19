<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    protected $guarded= [
        'id'
    ];

    public function transaction_detail()
    {
        return $this->belongsTo(TransactionDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function shipping()
    { 
        return $this->hasOne(Shipping::class);
    }
}

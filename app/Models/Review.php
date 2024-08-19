<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $guarded= [
        'id'
    ];

    public function transaction_detail()
    {
        return $this->belongsTo(TransactionDetail::class);
    }
}

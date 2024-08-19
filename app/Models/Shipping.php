<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{    
    protected $guarded= [
        'id' 
    ];

    public function confirmation()
    {
        return $this->belongsTo(Confirmation::class);
    }

    public function complain()
    {
        return $this->belongsTo(Complain::class);
    }
}
 
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClothingStock extends Model
{
    protected $guarded= [
        'id'
    ];

    public function clothing_size()
    {
        return $this->belongsTo(ClothingSize::class);
    }
}

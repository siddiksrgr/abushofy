<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessoriesStock extends Model
{
    protected $guarded= [
        'id'
    ];

    public function accessories_size()
    {
        return $this->belongsTo(AccessoriesSize::class);
    }
}

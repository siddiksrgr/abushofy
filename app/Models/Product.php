<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded= [
        'id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function galleries()
    {
        return $this->hasMany(ProductGallery::class);
    }

    public function clothing_sizes()
    {
        return $this->hasMany(ClothingSize::class);
    }

    public function accessories_sizes()
    {
        return $this->hasMany(AccessoriesSize::class);
    }
    
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
} 
 
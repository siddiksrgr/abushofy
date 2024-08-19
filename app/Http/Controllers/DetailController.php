<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class DetailController extends Controller 
{
    public function index($id) 
    {
        $product = Product::where('slug', $id)->firstOrFail();
        return view('pages.detail', ['product' => $product]); 
    }
}
 
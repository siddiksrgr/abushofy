<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductGallery;
use App\Models\Product;

class ProductGalleryController extends Controller
{
    public function store(Request $request)
    {    
        foreach ($request->file('photos') as $photo) {
            ProductGallery::create([
                'product_id' => $request->product_id,
                'photo' => $photo->store('products', 'public')
            ]);
        }
        return redirect()->back();
    }
    
    public function destroy($id)
    {
        $item = ProductGallery::findOrFail($id);
        $item->delete();
        return redirect()->back();
    }
}

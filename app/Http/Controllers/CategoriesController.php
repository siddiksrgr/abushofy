<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::paginate(16);
        return view('pages.categories', [ 
            'categories' => $categories, 
            'products' => $products
        ]); 
    }

    public function detail(Request $request, $name_category)
    {
        $category = Category::where('name_category', $name_category)->firstOrFail();
        $products = $category->products;
        return view('pages.category', ['products' => $products, 'category' => $category]);
    }
}

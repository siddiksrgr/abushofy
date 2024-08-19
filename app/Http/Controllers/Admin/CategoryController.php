<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('pages.admin.category.index', ['categories' => $categories]);
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('pages.admin.category.edit', ['category' => $category]);
    }

    public function create()
    {
        return view('pages.admin.category.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Category::create($data);
        return redirect()->route('category.index')->with(['message' => 'Kategori berhasil ditambah']);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $category = Category::findOrFail($id);
        $category->update($data);
        return redirect()->route('category.index')->with(['message' => 'Kategori berhasil diedit']);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('category.index')->with(['message' => 'Kategori berhasil dihapus']);
    }
}

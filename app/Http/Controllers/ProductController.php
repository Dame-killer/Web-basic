<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['brand', 'category'])->get();
        $brands = Brand::all();
        $categories = Category::all();
        $products = Product::all();
        return view('product.index', compact('products', 'brands', 'categories'));
    }

    public function create()
    {
        return view('product.create');
    }

    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'code' => 'required|unique:products,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Lưu dữ liệu
        Product::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
        ]);

        // Chuyển hướng sau khi thêm
        return redirect()->route('product.index')->with('success', 'Product added successfully!');
    }

    // public function edit(Product $product)
    // {
    //     return view('product.edit', compact('product'));
    // }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $product->update($request->only('name', 'code', 'description', 'brand_id', 'category_id'));

        return redirect()->back()->with('success', 'Product updated successfully!');
    }



    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index');
    }
}

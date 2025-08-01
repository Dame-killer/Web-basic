<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductDetail;
use App\Models\Size;
use App\Models\Color;
use App\Models\Power;
use App\Models\Other;
use App\Models\Product;

class ProductDetailController extends Controller
{
    public function index()
    {
        $product_details = ProductDetail::all();
        $sizes = Size::all();
        $colors = Color::all();
        $powers = Power::all();
        $others = Other::all();
        return view('product.product-detail', compact('product_details', 'sizes', 'colors', 'powers', 'others'));
    }

    public function create()
    {
        return view('product_detail.create');
    }

    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
        ]);

        // Lưu dữ liệu
        ProductDetail::create([
            'product_id' => $request->product_id,
            'size_id' => $request->size_id ?? null,
            'color_id' => $request->color_id ?? null, 
            'power_id' => $request->power_id ?? null,
            'other_id' => $request->other_id ?? null,
            'stock' => $request->stock,
            'price' => $request->price, 
        ]);

        // Chuyển hướng sau khi thêm
        return redirect()->route('product.show', $request->product_id)->with('success', 'Product detail added successfully!');
    }


    public function update(Request $request, ProductDetail $productDetail)
    {
        $request->validate([
            'stock' => 'required',
        ]);

        $productDetail->update($request->only('product_id', 'size_id', 'color_id', 'power_id', 'other_id', 'price', 'stock'));

        return redirect()->route('product.show', $request->product_id)->with('success', 'Product detail updated successfully!');
    }



    public function destroy(Request $request, ProductDetail $productDetail)
    {
        $productDetail->delete();
        return back()->with('success', 'Product detail deleted successfully!');
    }

}

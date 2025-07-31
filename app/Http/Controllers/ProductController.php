<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Size;
use App\Models\Color;
use App\Models\Power;
use App\Models\ProductDetail;
use App\Models\Other;

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
            'category_id' => 'required|exists:categories,id'
        ]);
        // Tạo thư mục nếu chưa tồn tại
        $uploadPath = public_path('uploads/products');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        // Xử lý upload ảnh
            $imageName = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/products'), $imageName);
            }
        // Lưu dữ liệu
        Product::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'image' => $imageName,
        ]);

        // Chuyển hướng sau khi thêm
        return redirect()->route('product.index')->with('success', 'Product added successfully!');
    }

    public function update(Request $request, Product $product)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'code' => 'required|string|unique:products,code,' . $product->id,
        'brand_id' => 'required|exists:brands,id',
        'category_id' => 'required|exists:categories,id',
    ]);

    $data = $request->only('name', 'code', 'description', 'brand_id', 'category_id');

    // Xử lý upload ảnh mới nếu có
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();

        // Xóa ảnh cũ nếu có
        $oldImagePath = public_path('uploads/products/' . $product->image);
        if ($product->image && file_exists($oldImagePath)) {
            unlink($oldImagePath);
        }

        // Upload ảnh mới
        $image->move(public_path('uploads/products'), $imageName);
        $data['image'] = $imageName;
    }

    $product->update($data);

    return redirect()->route('product.index')->with('success', 'Product updated successfully!');
}


    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index');
    }

    public function show($id)
    {
        $product = Product::with('brand', 'category')->findOrFail($id);

        // Lấy các bản ghi ProductDetail tương ứng
        $product_details = ProductDetail::with(['size', 'color', 'power', 'other'])
                                ->where('product_id', $id)
                                ->get();

        $sizes = Size::all();
        $colors = Color::all();
        $powers = Power::all();
        $others = Other::all();


        return view('product.product-detail', compact('product', 'product_details', 'sizes', 'colors', 'powers', 'others'));
    }

}

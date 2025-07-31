<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductDetail;
use App\Models\Product;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        $product_details = ProductDetail::with('product')->get();
        $product_details = ProductDetail::all();
        $products = Product::all();
        return view('order.index', compact('orders', 'product_details', 'products'));
    }

    public function create()
    {
        return view('order.create');
    }

    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50'
        ]);

        // 1️⃣ Lưu Order trước
        $order = Order::create([
            'code' => $request->code,
            'name' => $request->name,
            'order_date' => $request->order_date ?? now(),
            'address' => $request->address,
            'status' => $request->status,
            'total' => $request->total,
        ]);

        // 2️⃣ Lưu OrderDetail (nếu có sản phẩm)
        if ($request->has('product_details')) {
            foreach ($request->product_details as $index => $product_detail_id) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_detail_id' => $product_detail_id,
                    'quantity' => $request->quantities[$index],
                    'price' => $request->prices[$index],
                ]);
            }
        }

        // 3️⃣ Redirect về trang danh sách
        return redirect()->route('order.index')->with('success', 'Order added successfully!');
    }


    public function update(Request $request, Order $order)
    {
        $request->validate([
            'code' => 'required',
            'name' => 'required',
        ]);

        $order->update($request->only('code', 'name', 'order_date', 'address', 'status', 'total'));

        return redirect()->back()->with('success', 'Order updated successfully!');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('order.index');
    }
    public function show(Order $order)
    {
        $order->load(['details.productDetail.product', 'details.productDetail.color', 'details.productDetail.power']);

        return response()->json([
            'order' => $order,
            'details' => $order->details,
        ]);
    }
    public function getDetails(Order $order)
    {
        $details = $order->details()->with('productDetail.product', 'productDetail.color', 'productDetail.power')->get();

        return response()->json($details);
    }


}

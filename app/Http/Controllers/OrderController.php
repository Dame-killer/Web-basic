<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return view('order.index', compact('orders'));
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
            'code' => 'required|string|max:50',
            'order_date' => 'nullable|string',
        ]);

        // Lưu dữ liệu
        Order::create([
            'code' => $request->code,
            'name' => $request->name,
            'order_date' => $request->order_date ?? now(),
            'address' => $request->address,
            'status' => $request->status,
        ]);

        // Chuyển hướng sau khi thêm
        return redirect()->route('order.index')->with('success', 'Order added successfully!');
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'code' => 'required',
            'name' => 'required',
        ]);

        $order->update($request->only('code', 'name', 'order_date', 'address', 'status'));

        return redirect()->back()->with('success', 'Order updated successfully!');
    }



    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('order.index');
    }
}

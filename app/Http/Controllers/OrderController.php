<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductDetail;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        $order_details = OrderDetail::all();
        $product_details = ProductDetail::with('product', 'color', 'power')->get();

        return view('order.index', compact('orders', 'product_details', 'order_details'));
    }
    public function indexDashBoard()
    {
        $totalProducts = \App\Models\Product::count();
        $totalOrders = \App\Models\Order::count();
        $totalRevenue = \App\Models\Order::sum('total');
        $approvedRevenue = \App\Models\Order::where('status', 1)->sum('total');

        $monthlyRevenue = \App\Models\Order::select(
            DB::raw('MONTH(order_date) as month'),
            DB::raw('SUM(total) as revenue')
        )
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->keyBy('month');

        $months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];


        $revenues = [];
        for ($i = 1; $i <= 12; $i++) {
            $revenue = $monthlyRevenue->firstWhere('month', $i)->revenue ?? 0;
            $revenues[] = $revenue;
        }
        $pendingOrders = Order::where('status', 0)->count();
        $recentOrders = Order::orderBy('order_date', 'desc')->limit(5)->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'approvedRevenue',
            'months',
            'revenues',
            'pendingOrders',
            'recentOrders'
        ));
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


    public function update(Request $request, Order $order, $id)
    {
        $order = Order::findOrFail($id);
        $request->validate([
            'code' => 'required',
            'name' => 'required',
        ]);

        $order->update([
        'code' => $request->code,
        'name' => $request->name,
        'order_date' => $request->order_date ?? now(),
        'address' => $request->address,
        'status' => $request->status,
        'total' => $request->total,
        ]);

        $order->orderDetails()->delete();

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

        return redirect()->back()->with('success', 'Order updated successfully!');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('order.index');
    }
    public function show(Order $order)
    {
        $order->load(['orderDetails.productDetail.product', 'orderDetails.productDetail.color', 'orderDetails.productDetail.power']);

        return response()->json([
            'order' => $order,
            'orderDetails' => $order->orderDetails,
        ]);
    }
    public function getDetails($id)
    {
        $order = Order::with('orderDetails')->findOrFail($id);
        return response()->json($order->orderDetails);
    }

}

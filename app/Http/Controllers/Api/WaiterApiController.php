<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class WaiterApiController extends Controller
{
    public function listOrders()
    {
        $orders = Order::where('status', 'baru')->get();
        return response()->json($orders);
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status; 
        $order->save();

        return response()->json(['message' => 'Status pesanan diperbarui']);
    }
}

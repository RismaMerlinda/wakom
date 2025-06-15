<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class KasirApiController extends Controller
{
    public function listOrders()
    {
        $orders = Order::where('status', 'menunggu pembayaran')->get();
        return response()->json($orders);
    }

    public function prosesPembayaran($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'dibayar';
        $order->save();

        return response()->json(['message' => 'Pembayaran berhasil']);
    }
}

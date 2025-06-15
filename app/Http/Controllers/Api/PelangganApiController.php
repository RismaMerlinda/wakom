<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class PelangganApiController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->get();
        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $order = Order::create([
            'user_id' => auth()->id(),
            'menu_id' => $request->menu_id,
            'jumlah' => $request->jumlah,
            'status' => 'baru',
        ]);

        return response()->json($order, 201);
    }
}

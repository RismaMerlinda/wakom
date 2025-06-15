<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PelangganController extends Controller
{
    public function index()
    {
        $orders = Order::where('pelanggan_id', auth()->id())
            ->with(['items.menu', 'pelanggan'])
            ->orderBy('created_at')
            ->get();
        
        return view('pesanan.index', compact('orders'));
    }

    public function create()
    {
        $menus = Menu::all();
        return view('pesanan.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:tb_menu,id',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return $this->jsonResponse(false, 'Validasi gagal', $validator->errors(), 422);
            } else {
                return back()->withErrors($validator)->withInput();
            }
        }

        $order = Order::create([
            'pelanggan_id' => auth()->id(),
        ]);

        foreach ($request->items as $item) {
            if ($item['jumlah'] > 0) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $item['menu_id'],
                    'jumlah' => $item['jumlah'],
                ]);
            }
        }

        $order->load('items.menu');

        if ($request->expectsJson()) {
            return $this->jsonResponse(true, 'Pesanan berhasil dibuat', $order);
        } else {
            return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil dibuat!');
        }
    }

    
}
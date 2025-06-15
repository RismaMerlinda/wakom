<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transaksi;

class KasirController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.menu', 'pelanggan', 'waiter')
            ->where('status', 'pembayaran')
            ->orderBy('created_at')
            ->get();

        return view('kasir.list-orders', compact('orders'));
    }

    public function prosesPembayaran($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return redirect()->route('kasir.list-orders')->with('error', 'Order tidak ditemukan!');
        }

        if ($order->status !== 'pembayaran') {
            return redirect()->back()->with('error', 'Order tidak dalam status pembayaran!');
        }

        $order->status = 'disajikan';
        $order->save();

        // Calculate total price
        $total = 0;
        foreach ($order->items as $item) {
            $total += $item->jumlah * $item->menu->harga;
        }

        // Create transaction
        Transaksi::create([
            'order_id' => $order->id,
            'kasir_id' => auth()->id(),
            'total' => $total,
        ]);

        return redirect()->route('kasir.list-orders')->with('success', 'Pembayaran berhasil diproses!');
    }
}
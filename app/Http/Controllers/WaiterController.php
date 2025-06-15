<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use App\Models\User;

class WaiterController extends Controller
{
    // Melihat semua pesanan dengan status 'disajikan'
    public function listOrders()
    {
        $orders = Order::with('items.menu', 'pelanggan')
            ->where('status', 'disajikan')
            ->orderBy('created_at')
            ->get();

        return view('waiter.list-orders', compact('orders'));
    }

    // Menampilkan form untuk membuat pesanan baru
    public function showCreateOrder()
    {
        $users = User::where('role', 'pelanggan')->get();
        $menus = Menu::all(); 
        return view('waiter.create-order', compact('users', 'menus'));
    }

    // Membuat pesanan baru oleh waiter
    public function createOrder(Request $request)
    {
        $validated = $request->validate([
            'pelanggan_id' => 'required|exists:tb_user,id',
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:tb_menu,id',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'pelanggan_id' => $validated['pelanggan_id'],
            'waiter_id' => $request->user()->id,
        ]);

        foreach ($validated['items'] as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $item['menu_id'],
                'jumlah' => $item['jumlah'],
            ]);
        }

        return redirect()->route('waiter.show-create-order')->with('success', 'Pesanan berhasil dibuat!');
    }

    // Mengubah status pesanan menjadi selesai
    public function updateStatus($orderId)
    {
        $order = Order::find($orderId);
        if (!$order) {
            return redirect()->route('waiter.list-orders')->with('error', 'Order tidak ditemukan!');
        }

        $order->status = 'selesai';
        $order->save();

        return redirect()->route('waiter.list-orders')->with('success', 'Status pesanan diperbarui menjadi selesai!');
    }
}
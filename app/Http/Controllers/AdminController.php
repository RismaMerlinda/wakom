<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    // Validasi untuk register
    private function validateUserInput($request)
    {
        return Validator::make($request->all(), [
            'nama_user' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:tb_user,username',
            'password' => 'required|string|min:6',
        ]);
    }

    // Laporan transaksi
    public function indexTransaksi()
    {
        $transaksi = Transaksi::with('order.pelanggan', 'order.items.menu')->get();
        $totalPemasukan = $transaksi->sum('total');
        $totalTransaksi = $transaksi->count();

        return view('admin.transaksi', compact('transaksi', 'totalPemasukan', 'totalTransaksi'));
    }

    // ===================== Kasir =====================
    public function indexKasir()
    {
        $kasir = User::where('role', 'kasir')->get();
        return view('admin.kasir.index', compact('kasir'));
    }

    public function createKasir()
    {
        return view('admin.kasir.create');
    }

    public function storeKasir(Request $request)
    {
        $validator = $this->validateUserInput($request);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'nama_user' => $request->nama_user,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => 'kasir',
        ]);

        return redirect()->route('admin.kasir.index')->with('success', 'Kasir berhasil ditambahkan!');
    }

    public function destroyKasir($id)
    {
        $kasir = User::where('role', 'kasir')->find($id);
        if (!$kasir) {
            return redirect()->route('admin.kasir.index')->with('error', 'Kasir tidak ditemukan!');
        }

        $kasir->delete();
        return redirect()->route('admin.kasir.index')->with('success', 'Kasir berhasil dihapus!');
    }

    // ===================== Waiter =====================
    public function indexWaiter()
    {
        $waiter = User::where('role', 'waiter')->get();
        return view('admin.waiter.index', compact('waiter'));
    }

    public function createWaiter()
    {
        return view('admin.waiter.create');
    }

    public function storeWaiter(Request $request)
    {
        $validator = $this->validateUserInput($request);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'nama_user' => $request->nama_user,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => 'waiter',
        ]);

        return redirect()->route('admin.waiter.index')->with('success', 'Waiter berhasil ditambahkan!');
    }

    public function destroyWaiter($id)
    {
        $waiter = User::where('role', 'waiter')->find($id);
        if (!$waiter) {
            return redirect()->route('admin.waiter.index')->with('error', 'Waiter tidak ditemukan!');
        }

        $waiter->delete();
        return redirect()->route('admin.waiter.index')->with('success', 'Waiter berhasil dihapus!');
    }

    // ===================== Pelanggan =====================
    public function indexPelanggan()
    {
        $pelanggan = User::where('role', 'pelanggan')->get();
        return view('admin.pelanggan.index', compact('pelanggan'));
    }
}
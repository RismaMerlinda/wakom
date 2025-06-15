<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminApiController extends Controller
{
    public function listKasir()
    {
        $kasir = User::where('role', 'kasir')->get();
        return response()->json($kasir);
    }

    public function listWaiter()
    {
        $waiter = User::where('role', 'waiter')->get();
        return response()->json($waiter);
    }

    public function listPelanggan()
    {
        $pelanggan = User::where('role', 'pelanggan')->get();
        return response()->json($pelanggan);
    }
}

@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto p-4 sm:p-6 lg:p-8">
        <h1 class="text-2xl sm:text-3xl font-semibold text-gray-800 mb-6 flex items-center">
            <svg class="w-8 h-8 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            Laporan Transaksi
        </h1>

        <!-- Success and Error Messages -->
        @if(session('success'))
            <div class="bg-green-100 text-green-700 text-sm p-4 rounded-lg mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-700 text-sm p-4 rounded-lg mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('error') }}
            </div>
        @endif

        <!-- Summary Card -->
        <div class="bg-white p-6 rounded-xl shadow-md mb-8 grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="text-center p-4 bg-teal-50 rounded-lg">
                <h2 class="text-lg font-semibold text-gray-700 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 6c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"></path></svg>
                    Total Pemasukan
                </h2>
                <p class="text-2xl font-bold text-teal-600 mt-2">
                    Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                </p>
            </div>
            <div class="text-center p-4 bg-blue-50 rounded-lg">
                <h2 class="text-lg font-semibold text-gray-700 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Total Transaksi
                </h2>
                <p class="text-2xl font-bold text-blue-600 mt-2">{{ $totalTransaksi }}</p>
            </div>
        </div>

        <!-- Transaction List -->
        @forelse($transaksi as $trx)
            <div class="bg-white p-6 rounded-xl shadow-md mb-6 hover:shadow-lg transition-shadow duration-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-700 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        Transaksi #{{ $trx->id }} - Pesanan #{{ $trx->order->id }}
                    </h3>
                    <p class="mt-2 sm:mt-0 text-sm text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Tanggal: {{ $trx->created_at ? $trx->created_at->format('d M Y, H:i') : '-' }}
                    </p>
                </div>
                <p class="text-sm text-gray-600 mb-2 flex items-center">
                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Pelanggan: {{ $trx->order->pelanggan->nama_user ?? '-' }}
                </p>
                <ul class="space-y-2 mb-4">
                    @foreach($trx->order->items as $item)
                        <li class="flex justify-between text-gray-600 border-b border-gray-100 py-2">
                            <span class="text-sm">{{ $item->menu->nama }} (x{{ $item->jumlah }})</span>
                            <span class="text-sm font-medium text-teal-600">Rp {{ number_format($item->menu->harga * $item->jumlah, 0, ',', '.') }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="flex justify-between items-center border-t border-gray-200 pt-4">
                    <span class="text-base font-semibold text-gray-700">Total:</span>
                    <span class="text-base font-semibold text-teal-600">
                        Rp {{ number_format($trx->total, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        @empty
            <div class="bg-white p-6 rounded-xl shadow-md text-center">
                <p class="text-gray-600 text-sm flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Belum ada transaksi.
                </p>
            </div>
        @endforelse
    </div>
@endsection
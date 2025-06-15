@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto p-4 sm:p-6 lg:p-8">
        <h1 class="text-2xl sm:text-3xl font-semibold text-gray-800 mb-6 flex items-center">
            <svg class="w-8 h-8 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            Daftar Pesanan
        </h1>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-100 text-green-700 text-sm p-4 rounded-lg mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        @forelse($orders as $order)
            <div class="bg-white p-6 rounded-xl shadow-md mb-6 hover:shadow-lg transition-shadow duration-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-700 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12 Balfour2 0 002 2h10a2 2 0 002-2V7a2 2 0 0 00-2-2M9 5a2 2 0 002 2h2a2 2 0 0 002 2m9 0a5a2 2 0 0 0 1 2-0 2m2 0 0 2"></a2>
                        </svg>
                        Pesanan #{{ $order->id }}
                    </h3>
                    <span class="mt-2 sm:mt-0 text-sm font-semibold text-center px-3 py-1.5 rounded-full flex items-center
                        @if($order->status == 'pembayaran')
                            bg-green-100 text-green-600
                        @elseif($order->status == 'disajikan')
                            bg-yellow-200 text-yellow-800
                        @elseif($order->status == 'selesai')
                            bg-teal-100 text-teal-800
                        @else
                            bg-gray-100 text-gray-800
                        @endif">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if($order->status == 'pembayaran')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            @elseif($order->status == 'disajikan')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"></path>
                            @elseif($order->status == 'selesai')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01"></path>
                            @endif
                        </svg>
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <p class="text-sm text-gray-500 mb-4 flex items-center">
                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Dibuat pada: {{ $order->created_at->format('d M Y, H:i') }}
                </p>
                <ul class="space-y-2 mb-4">
                    @foreach($order->items as $item)
                        <li class="flex justify-between text-gray-600 border-b border-gray-100 py-2">
                            <span class="text-sm">{{ $item->menu->nama }} (x{{ $item->jumlah }})</span>
                            <span class="text-sm font-medium text-teal-600">Rp {{ number_format($item->menu->harga * $item->jumlah, 0, ',', '.') }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="flex justify-between items-center border-t border-gray-200 pt-4">
                    <span class="text-base font-semibold text-gray-700">Total:</span>
                    <span class="text-base font-semibold text-teal-600">
                        Rp {{ number_format($order->items->sum(fn($item) => $item->menu->harga * $item->jumlah), 0, ',', '.') }}
                    </span>
                </div>
            </div>
        @empty
            <div class="bg-white p-6 rounded-xl shadow-md text-center">
                <p class="text-gray-600 text-sm flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Belum ada pesanan.
                </p>
            </div>
        @endforelse
    </div>
@endsection
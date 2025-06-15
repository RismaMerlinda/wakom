<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warkom</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Import Google Fonts for modern typography -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 font-poppins antialiased">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-teal-800 text-white p-6 space-y-6 shadow-lg transform transition-all duration-300 md:p-8">
            <!-- Logo or Brand -->
            <div class="flex items-center space-x-2">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 6c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"></path>
                </svg>
                <h2 class="text-2xl font-bold tracking-tight">Warkom</h2>
            </div>
            <nav class="space-y-2">
                @auth
                    @if(auth()->user()->role === 'pelanggan')
                        <a href="{{ route('pesanan.create') }}" 
                           class="flex items-center space-x-2 text-teal-100 hover:text-white hover:bg-teal-700 rounded-lg px-4 py-2 transition duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            <span>Pesan Menu</span>
                        </a>
                        <a href="{{ route('pesanan.index') }}" 
                           class="flex items-center space-x-2 text-teal-100 hover:text-white hover:bg-teal-700 rounded-lg px-4 py-2 transition duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            <span>Daftar Pesanan</span>
                        </a>
                    @elseif(auth()->user()->role === 'waiter')
                        <a href="{{ route('waiter.list-orders') }}" 
                           class="flex items-center space-x-2 text-teal-100 hover:text-white hover:bg-teal-700 rounded-lg px-4 py-2 transition duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            <span>Daftar Order</span>
                        </a>
                        <a href="{{ route('waiter.show-create-order') }}" 
                           class="flex items-center space-x-2 text-teal-100 hover:text-white hover:bg-teal-700 rounded-lg px-4 py-2 transition duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            <span>Buat Order Pelanggan</span>
                        </a>
                    @elseif(auth()->user()->role === 'kasir')
                        <a href="{{ route('kasir.list-orders') }}" 
                           class="flex items-center space-x-2 text-teal-100 hover:text-white hover:bg-teal-700 rounded-lg px-4 py-2 transition duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <span>Pesanan Pembayaran</span>
                        </a>
                    @elseif(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.transaksi') }}" 
                           class="flex items-center space-x-2 text-teal-100 hover:text-white hover:bg-teal-700 rounded-lg px-4 py-2 transition duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            <span>Laporan Transaksi</span>
                        </a>
                        <a href="{{ route('admin.kasir.index') }}" 
                           class="flex items-center space-x-2 text-teal-100 hover:text-white hover:bg-teal-700 rounded-lg px-4 py-2 transition duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <span>Kelola Kasir</span>
                        </a>
                        <a href="{{ route('admin.waiter.index') }}" 
                           class="flex items-center space-x-2 text-teal-100 hover:text-white hover:bg-teal-700 rounded-lg px-4 py-2 transition duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <span>Kelola Waiter</span>
                        </a>
                        <a href="{{ route('admin.pelanggan.index') }}" 
                           class="flex items-center space-x-2 text-teal-100 hover:text-white hover:bg-teal-700 rounded-lg px-4 py-2 transition duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <span>Daftar Pelanggan</span>
                        </a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="flex items-center space-x-2 w-full text-left text-teal-100 hover:text-white hover:bg-teal-700 rounded-lg px-4 py-2 transition duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            <span>Logout</span>
                        </button>
                    </form>
                @endauth
                @guest
                    <a href="{{ route('login') }}" 
                       class="flex items-center space-x-2 text-teal-100 hover:text-white hover:bg-teal-700 rounded-lg px-4 py-2 transition duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                        <span>Login</span>
                    </a>
                @endguest
            </nav>
        </aside>

        <!-- Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white text-gray-800 p-4 md:p-6 shadow-sm flex items-center justify-between">
                <h1 class="text-2xl font-semibold tracking-tight">Welcome, {{ auth()->user()->nama_user }}</h1>
            </header>
            <!-- Main Content -->
            <main class="flex-1 p-4 md:p-6 bg-gray-50">
                @yield('content')
            </main>
            <!-- Footer -->
            <footer class="bg-white text-center p-4 text-gray-500 text-sm shadow-inner">
                <p>© {{ date('Y') }} Warkom - Website Pemesanan Makanan</p>
            </footer>
        </div>
    </div>

    <!-- Mobile Menu Toggle (Optional) -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.querySelector('aside');
            sidebar.classList.add('translate-x-0');
        });
    </script>
</body>
</html>
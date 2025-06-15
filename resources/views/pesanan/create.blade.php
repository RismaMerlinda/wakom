@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
        <h1 class="text-2xl sm:text-3xl font-semibold text-gray-800 mb-6 flex items-center">
            <svg class="w-8 h-8 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            Menu Pemesanan
        </h1>

        <!-- Success and Error Messages -->
        @if(session('success'))
            <div class="bg-green-100 text-green-700 text-sm p-4 rounded-lg mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 text-sm p-4 rounded-lg mb-6">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Menu Items -->
            <div class="flex-1">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($menus as $menu)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200">
                            <img src="{{ asset($menu->gambar) }}" 
                                 alt="{{ $menu->nama }}" 
                                 class="w-full h-48 object-cover"
                                 onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'">
                            <div class="p-5">
                                <h3 class="text-lg font-semibold text-gray-800">{{ $menu->nama }}</h3>
                                <p class="text-sm text-gray-500">{{ $menu->jenis }}</p>
                                <p class="text-base font-medium text-teal-600 mt-1">
                                    Rp {{ number_format($menu->harga, 0, ',', '.') }}
                                </p>
                                <p class="text-sm text-gray-600 mt-1">
                                    Stok: {{ $menu->stok > 0 ? $menu->stok : 'Habis' }}
                                </p>
                                <div class="mt-4 flex items-center gap-3">
                                    <input type="number" 
                                           min="0" 
                                           max="{{ $menu->stok }}" 
                                           placeholder="0" 
                                           class="w-20 border border-gray-200 rounded-lg p-2 focus:ring focus:ring-teal-300 focus:border-teal-500 outline-none transition duration-200"
                                           data-menu-id="{{ $menu->id }}"
                                           data-menu-name="{{ $menu->nama }}"
                                           data-menu-price="{{ $menu->harga }}"
                                           data-menu-stock="{{ $menu->stok }}"
                                           onchange="updateCart(this)"
                                           value="{{ old('items.' . $loop->index . '.jumlah', 0) }}">
                                    @error("items.{$loop->index}.jumlah")
                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full bg-white p-6 rounded-xl shadow-md text-center">
                            <p class="text-gray-600 text-sm flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Tidak ada menu tersedia.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Cart Sidebar -->
            <div class="lg:w-80 bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Keranjang
                </h2>
                <div id="cart-items" class="space-y-4 mb-4">
                    <p class="text-gray-600 text-sm">Belum ada item di keranjang.</p>
                </div>
                <p class="text-lg font-semibold text-gray-800 border-t pt-4">
                    Total: Rp <span id="cart-total">0</span>
                </p>
                <form method="POST" action="{{ route('pesanan.store') }}" id="cart-form">
                    @csrf
                    <div id="form-items"></div>
                    <button type="submit" 
                            id="order-button" 
                            class="w-full mt-4 bg-teal-600 text-white py-3 rounded-lg hover:bg-teal-700 transition duration-200 shadow-md hover:shadow-lg disabled:bg-gray-400 disabled:cursor-not-allowed flex items-center justify-center"
                            disabled>
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Pesan Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        let cart = {};

        function updateCart(input) {
            const menuId = input.dataset.menuId;
            const menuName = input.dataset.menuName;
            const menuPrice = parseFloat(input.dataset.menuPrice);
            const menuStock = parseInt(input.dataset.menuStock);
            let quantity = parseInt(input.value) || 0;

            // Validate quantity
            if (quantity < 0) {
                quantity = 0;
                input.value = 0;
            }
            if (quantity > menuStock) {
                quantity = menuStock;
                input.value = menuStock;
                alert(`Stok maksimum untuk ${menuName} adalah ${menuStock}.`);
            }

            // Update cart
            if (quantity > 0) {
                cart[menuId] = { name: menuName, price: menuPrice, quantity };
            } else {
                delete cart[menuId];
            }

            // Render cart
            renderCart();
        }

        function renderCart() {
            const cartItemsDiv = document.getElementById('cart-items');
            const cartTotalSpan = document.getElementById('cart-total');
            const formItemsDiv = document.getElementById('form-items');
            const orderButton = document.getElementById('order-button');

            // Clear previous content
            cartItemsDiv.innerHTML = '';
            formItemsDiv.innerHTML = '';
            let total = 0;
            let index = 0;

            // Populate cart items
            if (Object.keys(cart).length === 0) {
                cartItemsDiv.innerHTML = '<p class="text-gray-600 text-sm">Belum ada item di keranjang.</p>';
                orderButton.disabled = true;
            } else {
                for (const menuId in cart) {
                    const item = cart[menuId];
                    const itemTotal = item.price * item.quantity;
                    total += itemTotal;

                    // Cart display
                    const itemDiv = document.createElement('div');
                    itemDiv.className = 'flex justify-between items-center py-2 border-b border-gray-200';
                    itemDiv.innerHTML = `
                        <div>
                            <p class="text-sm font-medium text-gray-700">${item.name}</p>
                            <p class="text-sm text-gray-500">x${item.quantity} @ Rp ${item.price.toLocaleString('id-ID')}</p>
                        </div>
                        <p class="text-sm font-semibold text-teal-600">Rp ${itemTotal.toLocaleString('id-ID')}</p>
                    `;
                    cartItemsDiv.appendChild(itemDiv);

                    // Form inputs
                    formItemsDiv.innerHTML += `
                        <input type="hidden" name="items[${index}][menu_id]" value="${menuId}">
                        <input type="hidden" name="items[${index}][jumlah]" value="${item.quantity}">
                    `;
                    index++;
                }
                orderButton.disabled = false;
            }

            // Update total
            cartTotalSpan.textContent = total.toLocaleString('id-ID');
        }

        // Initialize cart with previous input values (e.g., after validation failure)
        document.querySelectorAll('input[type="number"][data-menu-id]').forEach(input => {
            const oldValue = @json(old('items', []))?.[input.dataset.menuId]?.jumlah || 0;
            if (oldValue > 0) {
                input.value = oldValue;
                updateCart(input);
            }
        });
    </script>
@endsection
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            ['nama' => 'Air Putih Dingin', 'jenis' => 'minuman', 'harga' => 3000, 'stok' => 50, 'gambar' => 'gambar/airputihdingin.jpg'],
            ['nama' => 'Ayam Kecap', 'jenis' => 'makanan', 'harga' => 18000, 'stok' => 20, 'gambar' => 'gambar/ayam kecap.png'],
            ['nama' => 'Ayam Pop', 'jenis' => 'makanan', 'harga' => 20000, 'stok' => 15, 'gambar' => 'gambar/ayam pop.png'],
            ['nama' => 'Ayam Rica Rica', 'jenis' => 'makanan', 'harga' => 22000, 'stok' => 10, 'gambar' => 'gambar/ayam rica rica.png'],
            ['nama' => 'Bubur Kacang Ijo', 'jenis' => 'makanan', 'harga' => 7000, 'stok' => 20, 'gambar' => 'gambar/buburkacangijo.png'],
            ['nama' => 'Es Dawet', 'jenis' => 'minuman', 'harga' => 8000, 'stok' => 25, 'gambar' => 'gambar/es dawet.png'],
            ['nama' => 'Es Jeruk', 'jenis' => 'minuman', 'harga' => 6000, 'stok' => 30, 'gambar' => 'gambar/esjeruk.jpg'],
            ['nama' => 'Es Kopi', 'jenis' => 'minuman', 'harga' => 12000, 'stok' => 15, 'gambar' => 'gambar/eskopi.jpg'],
            ['nama' => 'Es Teh', 'jenis' => 'minuman', 'harga' => 5000, 'stok' => 40, 'gambar' => 'gambar/esteh.jpg'],
            ['nama' => 'Hati Ayam', 'jenis' => 'makanan', 'harga' => 10000, 'stok' => 15, 'gambar' => 'gambar/hati ayam.png'],
            ['nama' => 'Indomie', 'jenis' => 'makanan', 'harga' => 9000, 'stok' => 25, 'gambar' => 'gambar/indomie.jpg'],
            ['nama' => 'Kulit Crispy', 'jenis' => 'makanan', 'harga' => 8000, 'stok' => 20, 'gambar' => 'gambar/kulit crispy.png'],
            ['nama' => 'Kulit Geprek', 'jenis' => 'makanan', 'harga' => 8500, 'stok' => 18, 'gambar' => 'gambar/kulit geprek.png'],
            ['nama' => 'Lemon Tea', 'jenis' => 'minuman', 'harga' => 7000, 'stok' => 30, 'gambar' => 'gambar/lemontea.jpg'],
            ['nama' => 'Lodho Ayam', 'jenis' => 'makanan', 'harga' => 20000, 'stok' => 12, 'gambar' => 'gambar/lodho ayam.png'],
            ['nama' => 'Mie Hot', 'jenis' => 'makanan', 'harga' => 14000, 'stok' => 15, 'gambar' => 'gambar/mie hot.png'],
            ['nama' => 'Mie Kari', 'jenis' => 'makanan', 'harga' => 15000, 'stok' => 10, 'gambar' => 'gambar/mie kari.png'],
            ['nama' => 'Mie Nyemek', 'jenis' => 'makanan', 'harga' => 16000, 'stok' => 15, 'gambar' => 'gambar/mie nyemek.png'],
            ['nama' => 'Mix Platter', 'jenis' => 'makanan', 'harga' => 25000, 'stok' => 10, 'gambar' => 'gambar/mixplatter.png'],
            ['nama' => 'Nasi Ayam Bakar', 'jenis' => 'makanan', 'harga' => 22000, 'stok' => 15, 'gambar' => 'gambar/nasiayambakar.jpg'],
            ['nama' => 'Nasi Ayam Geprek', 'jenis' => 'makanan', 'harga' => 18000, 'stok' => 20, 'gambar' => 'gambar/nasiayamgeprek.jpg'],
            ['nama' => 'Nasi Ayam Goreng', 'jenis' => 'makanan', 'harga' => 20000, 'stok' => 15, 'gambar' => 'gambar/nasiayamgoreng.png'],
            ['nama' => 'Nasi Bakar', 'jenis' => 'makanan', 'harga' => 17000, 'stok' => 10, 'gambar' => 'gambar/nasi bakar.png'],
            ['nama' => 'Nasi Goreng', 'jenis' => 'makanan', 'harga' => 16000, 'stok' => 20, 'gambar' => 'gambar/nasgor.jpg'],
            ['nama' => 'Nasi Goreng Seafood', 'jenis' => 'makanan', 'harga' => 22000, 'stok' => 12, 'gambar' => 'gambar/nasi goreng seafood.png'],
            ['nama' => 'Opor Ayam', 'jenis' => 'makanan', 'harga' => 18000, 'stok' => 12, 'gambar' => 'gambar/opor ayam.png'],
            ['nama' => 'Pop Ice', 'jenis' => 'minuman', 'harga' => 6000, 'stok' => 30, 'gambar' => 'gambar/popice.jpg'],
            ['nama' => 'Ramen', 'jenis' => 'makanan', 'harga' => 25000, 'stok' => 10, 'gambar' => 'gambar/ramen.png'],
            ['nama' => 'Roti Maryam', 'jenis' => 'makanan', 'harga' => 10000, 'stok' => 20, 'gambar' => 'gambar/roti maryam.png'],
            ['nama' => 'Roti Bakar', 'jenis' => 'makanan', 'harga' => 9000, 'stok' => 25, 'gambar' => 'gambar/rotibakar.jpg'],
            ['nama' => 'Sate Ayam', 'jenis' => 'makanan', 'harga' => 22000, 'stok' => 18, 'gambar' => 'gambar/sate ayam.png'],
            ['nama' => 'Seblak', 'jenis' => 'makanan', 'harga' => 14000, 'stok' => 15, 'gambar' => 'gambar/seblak.jpg'],
            ['nama' => 'Siomay', 'jenis' => 'makanan', 'harga' => 10000, 'stok' => 15, 'gambar' => 'gambar/siomay.png'],
        ];

        foreach ($menus as $menu) {
            DB::table('tb_menu')->insert([
                'nama' => $menu['nama'],
                'jenis' => $menu['jenis'],
                'harga' => $menu['harga'],
                'stok' => $menu['stok'],
                'gambar' => $menu['gambar'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

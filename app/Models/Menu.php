<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'tb_menu';

    protected $fillable = [
        'nama',
        'jenis',
        'harga',
        'stok',
        'gambar',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}

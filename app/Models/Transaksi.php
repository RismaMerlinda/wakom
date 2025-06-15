<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'tb_transaksi';

    protected $fillable = [
        'order_id',
        'kasir_id',
        'total',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

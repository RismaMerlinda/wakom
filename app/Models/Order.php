<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'tb_order';

    protected $fillable = [
        'pelanggan_id',
        'waiter_id',
        'status',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'pelanggan_id');
    }

    public function waiter()
    {
        return $this->belongsTo(User::class, 'waiter_id');
    }

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class);
    }
}

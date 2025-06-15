<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'tb_user';

    protected $fillable = [
        'nama_user',
        'username',
        'password',
        'role',
    ];

    protected $hidden = ['password'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

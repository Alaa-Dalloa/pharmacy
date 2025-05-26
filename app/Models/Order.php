<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'product_photo',
        'product_name',
        'count',
        'price_total',
        'address',
        'phone',
        'user_name',
        'order_price_total',
        'message_notify',
        'time_notify',
        'profitable'
    ];
}

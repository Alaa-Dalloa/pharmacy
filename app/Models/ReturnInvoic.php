<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnInvoic extends Model
{
    use HasFactory;
     protected $table = 'return_invoics';
    protected $fillable = [
        'product_name',
        'count',
        'price_total',
        'sell_date',
        'invoic_price_total'
        ];
}

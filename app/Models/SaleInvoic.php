<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleInvoic extends Model
{
    use HasFactory;
    protected $table = 'sale_invoics';
    protected $fillable = [
        'product_name',
        'quantity',
        'price_total',
        'profitable',
        'product_price',
        'invoice_price_total',
        'release_date'
        ];
}

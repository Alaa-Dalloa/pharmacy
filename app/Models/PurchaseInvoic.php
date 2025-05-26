<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoic extends Model
{
    use HasFactory;
    protected $table = 'purchase_invoics';
    protected $fillable = [
        'product_name',
        'quantity',
        'price_total',
        'product_price',
        'invoice_price_total',
        'repository',
        'start_date',
        'end_date',
        'release_date'

        ];
}

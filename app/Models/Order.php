<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Mass-assignable columns
    protected $fillable = [
        'customer_email',
        'total_amount',
        'shopify_order_id',
        'order_date',
    ];
}

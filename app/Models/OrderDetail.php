<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
       'order_id', 'product_detail_id', 'quantity', 'price'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
    public function ProductDetail()
    {
        return $this->belongsTo(ProductDetail::class);
    }
}

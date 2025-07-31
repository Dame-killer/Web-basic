<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'size_id',
        'color_id',
        'power_id',
        'other_id',
        'stock',
        'price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function other()
    {
        return $this->belongsTo(Other::class);
    }
    public function size()
    {
        return $this->belongsTo(Size::class);
    }
    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function power()
    {
        return $this->belongsTo(Power::class);
    }


}

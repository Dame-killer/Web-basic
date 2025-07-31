<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
   use HasFactory;

    protected $fillable = [
       'code', 'name', 'order_date', 'address', 'status' 
    ];

}

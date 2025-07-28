<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Power extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',   // (đảm bảo 'name' cũng được thêm nếu cần)
    ];
}

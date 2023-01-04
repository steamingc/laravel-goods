<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class goods extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'goods_nm',
        'color',
        'size',
        'price'
    ];

    protected $casts = [
        'rt' => 'datetime'
    ];

    public $timestamps = false;
}

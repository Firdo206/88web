<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $fillable = [
        'nama',
        'kode',
        'diskon',
        'berlaku_hingga',
        'deskripsi',
        'status',
    ];

    protected $casts = [
        'berlaku_hingga' => 'date',
    ];
}
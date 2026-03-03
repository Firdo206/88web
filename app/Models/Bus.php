<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bus extends Model
{
    protected $fillable = [
        'nama',
        'plat',
        'asal',
        'tujuan',
        'jam_berangkat',
        'harga',
        'kapasitas',
        'tipe',
        'fasilitas',
        'deskripsi',
        'promo',
        'status',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    // Accessor: emoji berdasarkan tipe bus
    public function getEmojiAttribute(): string
    {
        return match ($this->tipe) {
            'Sleeper'         => '🌙',
            'Super Eksekutif' => '⭐',
            'Eksekutif'       => '🏆',
            default           => '🎯',
        };
    }

    // Accessor: format harga rupiah
    public function getHargaFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }
}
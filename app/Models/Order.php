<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'kode_order', 'bus_id', 'user_id',
        'nama_penumpang', 'telepon',
        'tanggal_berangkat', 'jumlah_kursi',
        'total_harga', 'status', 'catatan', 'confirmed_at',
    ];

    protected $casts = [
        'tanggal_berangkat' => 'date',
        'confirmed_at'      => 'datetime',
    ];

    public function bus(): BelongsTo
    {
        return $this->belongsTo(Bus::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'Menunggu',
            'confirmed' => 'Dikonfirmasi',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default     => $this->status,
        };
    }

    public function getStatusClassAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'badge-warning',
            'confirmed' => 'badge-success',
            'completed' => 'badge-blue',
            'cancelled' => 'badge-danger',
            default     => 'badge-gray',
        };
    }

    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            $last = static::latest('id')->first();
            $order->kode_order = 'ORD' . str_pad(($last ? $last->id + 1 : 1), 3, '0', STR_PAD_LEFT);
        });
    }
}
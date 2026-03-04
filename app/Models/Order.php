<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'kode_order',
        'bus_id',
        'user_id',
        'nama_penumpang',
        'telepon',
        'tanggal_berangkat',
        'jumlah_kursi',
        'total_harga',
        'status',
        'catatan',
        'confirmed_at',
        // Payment fields
        'metode_bayar',
        'status_bayar',
        'bukti_transfer',
        'bukti_uploaded_at',
        'catatan_bayar',
        'verified_at',
    ];

    protected $casts = [
        'tanggal_berangkat' => 'date',
        'confirmed_at'      => 'datetime',
        'bukti_uploaded_at' => 'datetime',
        'verified_at'       => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relasi
    |--------------------------------------------------------------------------
    */
    public function bus(): BelongsTo
    {
        return $this->belongsTo(Bus::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors — Status Order
    |--------------------------------------------------------------------------
    */
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
            'pending'   => 'warning',
            'confirmed' => 'success',
            'completed' => 'blue',
            'cancelled' => 'danger',
            default     => 'gray',
        };
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors — Status Pembayaran
    |--------------------------------------------------------------------------
    */
    public function getStatusBayarLabelAttribute(): string
    {
        return match ($this->status_bayar) {
            'belum_bayar'          => 'Belum Bayar',
            'menunggu_verifikasi'  => 'Menunggu Verifikasi',
            'lunas'                => 'Lunas',
            'cod_pending'          => 'COD — Bayar di Tempat',
            default                => $this->status_bayar,
        };
    }

    public function getStatusBayarClassAttribute(): string
    {
        return match ($this->status_bayar) {
            'belum_bayar'         => 'danger',
            'menunggu_verifikasi' => 'warning',
            'lunas'               => 'success',
            'cod_pending'         => 'blue',
            default               => 'gray',
        };
    }

    public function getMetodeBayarLabelAttribute(): string
    {
        return match ($this->metode_bayar) {
            'transfer' => '🏦 Transfer Bank',
            'cod'      => '💵 COD (Bayar di Tempat)',
            default    => $this->metode_bayar,
        };
    }

    /*
    |--------------------------------------------------------------------------
    | Helper: apakah butuh bukti transfer
    |--------------------------------------------------------------------------
    */
    public function butuhBukti(): bool
    {
        return $this->metode_bayar === 'transfer'
            && in_array($this->status_bayar, ['belum_bayar', 'menunggu_verifikasi']);
    }

    public function sudahUploadBukti(): bool
    {
        return !is_null($this->bukti_transfer);
    }

    /*
    |--------------------------------------------------------------------------
    | Auto-generate kode_order
    |--------------------------------------------------------------------------
    */
    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            $last = static::latest('id')->first();
            $order->kode_order = 'ORD' . str_pad(($last ? $last->id + 1 : 1), 3, '0', STR_PAD_LEFT);
        });
    }
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Metode pembayaran
            $table->enum('metode_bayar', ['transfer', 'cod'])
                  ->default('transfer')
                  ->after('total_harga');

            // Status pembayaran
            $table->enum('status_bayar', ['belum_bayar', 'menunggu_verifikasi', 'lunas', 'cod_pending'])
                  ->default('belum_bayar')
                  ->after('metode_bayar');

            // Path bukti transfer
            $table->string('bukti_transfer')->nullable()->after('status_bayar');

            // Waktu upload bukti
            $table->timestamp('bukti_uploaded_at')->nullable()->after('bukti_transfer');

            // Catatan verifikasi dari admin
            $table->string('catatan_bayar')->nullable()->after('bukti_uploaded_at');

            // Waktu verifikasi pembayaran
            $table->timestamp('verified_at')->nullable()->after('catatan_bayar');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'metode_bayar',
                'status_bayar',
                'bukti_transfer',
                'bukti_uploaded_at',
                'catatan_bayar',
                'verified_at',
            ]);
        });
    }
};
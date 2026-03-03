<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buses', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('plat')->nullable();
            $table->string('asal');
            $table->string('tujuan');
            $table->time('jam_berangkat')->default('08:00');
            $table->integer('harga');
            $table->integer('kapasitas')->default(40);
            $table->enum('tipe', ['Ekonomi', 'Eksekutif', 'Super Eksekutif', 'Sleeper'])->default('Eksekutif');
            $table->string('fasilitas')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('promo')->nullable();
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buses');
    }
};
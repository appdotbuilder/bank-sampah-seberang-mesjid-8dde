<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi_setoran', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi')->unique()->comment('Transaction number');
            $table->foreignId('nasabah_id')->constrained('nasabah')->onDelete('cascade');
            $table->foreignId('jenis_sampah_id')->constrained('jenis_sampah')->onDelete('cascade');
            $table->decimal('berat_kg', 8, 2)->comment('Weight in kg');
            $table->decimal('harga_per_kg', 10, 2)->comment('Price per kg at transaction time');
            $table->decimal('nilai_setoran', 12, 2)->comment('Total deposit value');
            $table->boolean('sudah_dijual')->default(false)->comment('Whether this deposit has been sold to collector');
            $table->timestamps();
            
            $table->index('no_transaksi');
            $table->index('nasabah_id');
            $table->index('jenis_sampah_id');
            $table->index('sudah_dijual');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_setoran');
    }
};
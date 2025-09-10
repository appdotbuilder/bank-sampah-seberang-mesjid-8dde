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
        Schema::create('transaksi_penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi')->unique()->comment('Transaction number');
            $table->foreignId('pengepul_id')->constrained('pengepul')->onDelete('cascade');
            $table->foreignId('jenis_sampah_id')->constrained('jenis_sampah')->onDelete('cascade');
            $table->decimal('berat_kg', 8, 2)->comment('Weight in kg');
            $table->decimal('harga_per_kg', 10, 2)->comment('Selling price per kg');
            $table->decimal('nilai_jual', 12, 2)->comment('Total selling value');
            $table->decimal('keuntungan', 12, 2)->comment('Profit from this sale');
            $table->timestamps();
            
            $table->index('no_transaksi');
            $table->index('pengepul_id');
            $table->index('jenis_sampah_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_penjualan');
    }
};
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
        Schema::create('jenis_sampah', function (Blueprint $table) {
            $table->id();
            $table->string('kode_sampah')->unique()->comment('Unique waste type code');
            $table->string('jenis_sampah')->comment('Waste type name');
            $table->decimal('harga_beli', 10, 2)->comment('Purchase price per kg');
            $table->decimal('harga_jual', 10, 2)->comment('Selling price per kg');
            $table->decimal('stok_kg', 10, 2)->default(0)->comment('Current stock in kg');
            $table->timestamps();
            
            $table->index('kode_sampah');
            $table->index('jenis_sampah');
            $table->index('stok_kg');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_sampah');
    }
};
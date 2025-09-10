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
        Schema::create('nasabah', function (Blueprint $table) {
            $table->id();
            $table->string('kode_nasabah')->unique()->comment('Unique customer code');
            $table->string('nama')->comment('Customer name');
            $table->string('nik_nip')->unique()->comment('NIK or NIP number');
            $table->text('alamat')->comment('Customer address');
            $table->string('instansi')->nullable()->comment('Institution name');
            $table->decimal('saldo_total', 15, 2)->default(0)->comment('Total balance from deposits');
            $table->decimal('saldo_dapat_ditarik', 15, 2)->default(0)->comment('Withdrawable balance');
            $table->timestamps();
            
            $table->index('kode_nasabah');
            $table->index('nama');
            $table->index('nik_nip');
            $table->index(['saldo_total', 'saldo_dapat_ditarik']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nasabah');
    }
};
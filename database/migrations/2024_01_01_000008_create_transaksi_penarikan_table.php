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
        Schema::create('transaksi_penarikan', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi')->unique()->comment('Transaction number');
            $table->foreignId('nasabah_id')->constrained('nasabah')->onDelete('cascade');
            $table->decimal('jumlah_penarikan', 12, 2)->comment('Withdrawal amount');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('keterangan')->nullable()->comment('Notes or remarks');
            $table->timestamps();
            
            $table->index('no_transaksi');
            $table->index('nasabah_id');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_penarikan');
    }
};
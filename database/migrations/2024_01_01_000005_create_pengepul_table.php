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
        Schema::create('pengepul', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pengepul')->unique()->comment('Unique collector code');
            $table->string('nama')->comment('Collector name');
            $table->text('alamat')->comment('Collector address');
            $table->timestamps();
            
            $table->index('kode_pengepul');
            $table->index('nama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengepul');
    }
};
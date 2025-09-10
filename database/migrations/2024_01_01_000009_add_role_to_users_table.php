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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'nasabah'])->default('nasabah')->after('email');
            $table->string('nik_nip')->nullable()->after('role')->comment('NIK/NIP for nasabah role');
            
            $table->index('role');
            $table->index('nik_nip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'nik_nip']);
        });
    }
};
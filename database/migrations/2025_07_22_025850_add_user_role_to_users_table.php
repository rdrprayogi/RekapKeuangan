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
            $table->foreignId('user_role_id')->nullable()->constrained('user_roles');
            $table->string('nip')->nullable()->unique(); // Nomor Induk Pegawai
            $table->string('jabatan')->nullable();
            $table->string('unit_kerja')->nullable();
            $table->boolean('is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['user_role_id']);
            $table->dropColumn(['user_role_id', 'nip', 'jabatan', 'unit_kerja', 'is_active']);
        });
    }
};

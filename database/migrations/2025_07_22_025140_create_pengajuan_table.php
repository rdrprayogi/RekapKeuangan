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
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pengajuan')->unique();
            $table->foreignId('user_id')->constrained('users');
            $table->string('judul');
            $table->text('deskripsi');
            $table->text('keperluan');
            $table->decimal('total_harga', 15, 2);
            $table->enum('status', ['pending', 'approved', 'rejected', 'revision'])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->text('catatan_approval')->nullable();
            $table->timestamp('tanggal_pengajuan');
            $table->timestamp('tanggal_approval')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan');
    }
};

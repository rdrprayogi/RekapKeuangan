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
        Schema::create('revision_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')->constrained('pengajuan')->onDelete('cascade');
            $table->foreignId('revision_by')->constrained('users')->onDelete('cascade');
            $table->text('catatan_revision');
            $table->timestamp('tanggal_revision');
            $table->string('status_before')->default('pending'); // Status sebelum revisi
            $table->string('status_after')->nullable(); // Status setelah revisi (approved, rejected, dll)
            $table->timestamp('tanggal_resolved')->nullable(); // Kapan revisi selesai ditangani
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revision_history');
    }
};

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
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->unsignedBigInteger('revision_by')->nullable()->after('approved_by');
            $table->timestamp('tanggal_revision')->nullable()->after('tanggal_approval');
            
            $table->foreign('revision_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->dropForeign(['revision_by']);
            $table->dropColumn(['revision_by', 'tanggal_revision']);
        });
    }
};

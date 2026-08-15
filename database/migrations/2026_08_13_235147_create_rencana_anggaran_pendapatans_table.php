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
        Schema::create('rencana_anggaran_pendapatans', function (Blueprint $table) {
            $table->id();
            $table->uuid();

            $table->string('judul')->default('rencana anggaran pendapatan');
            $table->integer('tahun')->default(2026);
            $table->string('jenis')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rencana_anggaran_pendapatans');
    }
};

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
        Schema::create('ep_anggaran_pendapatan_belanja_desas', function (Blueprint $table) {
            $table->id();
            $table->uuid();

            $table->string('judul')->default('anggaran pendapatan dan belanja desa');
            $table->integer('tahun')->default(2026);
            $table->string('jenis')->default('APBDes');
            $table->string('status')->default('draft');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ep_anggaran_pendapatan_belanja_desas');
    }
};

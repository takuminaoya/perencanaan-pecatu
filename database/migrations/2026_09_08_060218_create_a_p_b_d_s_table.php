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
        Schema::create('ep_apbds', function (Blueprint $table) {
            $table->id();
            $table->uuid();

            $table->string('judul')->default('Anggaran Pendapatan Dan Belanja Desa Pecatu');
            $table->integer('tahun')->default(2026);
            $table->string('status')->default('draft');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ep_apbds');
    }
};

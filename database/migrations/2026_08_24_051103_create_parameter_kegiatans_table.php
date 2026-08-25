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
        Schema::create('ep_parameter_kegiatans', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('uraian');
            $table->string('kode_singkat')->nullable();
            $table->string('uraian_output')->nullable();
            $table->string('satuan_output')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ep_parameter_kegiatans');
    }
};

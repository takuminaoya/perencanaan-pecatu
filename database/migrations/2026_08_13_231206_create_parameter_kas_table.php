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
        Schema::create('ep_parameter_kas', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('parent_kode')->nullable();
            $table->string('nama');
            $table->string('uraian')->nullable();
            $table->string('satuan')->nullable();
            $table->string('tipe')->default('main');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ep_parameter_kas');
    }
};

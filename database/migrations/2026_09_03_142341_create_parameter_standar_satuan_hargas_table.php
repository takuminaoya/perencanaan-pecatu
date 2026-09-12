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
        Schema::create('ep_parameter_standar_satuan_hargas', function (Blueprint $table) {
            $table->id();
            $table->longText('uraian_barang')->nullable();
            $table->longText('spesifikasi')->nullable();
            $table->longText('satuan')->nullable();
            $table->bigInteger('harga_satuan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ep_parameter_standar_satuan_hargas');
    }
};

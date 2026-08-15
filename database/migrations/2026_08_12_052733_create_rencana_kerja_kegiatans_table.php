<?php

use App\Models\ParameterBidang;
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
        Schema::create('ep_rencana_kerja_kegiatans', function (Blueprint $table) {
            $table->id();
            $table->uuid();

            $table->string('judul')->default('rencana kerja kegiatan desa');
            $table->integer('tahun')->default(2026);
            $table->string('desa')->default('pemerintah desa pecatu');
            $table->string('kecamatan')->default('kuta selatan');
            $table->string('kabupaten')->default('badung');
            $table->string('provinsi')->default('bali');
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
        Schema::dropIfExists('ep_rencana_kerja_kegiatans');
    }
};

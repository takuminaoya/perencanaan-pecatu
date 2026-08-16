<?php

use App\Models\RencanaAnggaranBiaya;
use App\Models\RencanaKerjaKegiatanBidangDetail;
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
        Schema::create('ep_rencana_anggaran_biaya_bidangs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(RencanaAnggaranBiaya::class, 'rab_id')->constrained()->cascadeOnDelete();

            $table->foreignIdFor(RencanaKerjaKegiatanBidangDetail::class, 'rkkbd_id')->nullable();

            // text untuk mempercepat filter
            $table->string('bidang')->nullable();
            $table->string('sub')->nullable();
            $table->string('kegiatan')->nullable();
            $table->integer('waktu')->default(0);
            $table->string('indikator_waktu')->default('bulan');
            $table->string('keluaran')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ep_rencana_anggaran_biaya_bidangs');
    }
};

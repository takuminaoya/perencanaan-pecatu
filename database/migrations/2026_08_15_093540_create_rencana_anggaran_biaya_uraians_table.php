<?php

use App\Models\ParameterKas;
use App\Models\RencanaAnggaranBiaya;
use App\Models\RencanaAnggaranBiayaBidang;
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
        Schema::create('ep_rencana_anggaran_biaya_uraians', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(RencanaAnggaranBiaya::class, 'rab_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(RencanaAnggaranBiayaBidang::class, 'rabb_id')->constrained()->cascadeOnDelete();

            // ini parameter untuk main kas cth : Belanja
            $table->string('judul')->nullable();
            $table->foreignIdFor(RencanaKerjaKegiatanBidangDetail::class, 'rkkbd_id')->nullable();
            $table->foreignIdFor(ParameterKas::class, 'kas_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->string('kode_kas')->nullable();
            $table->string('nama_kas')->nullable();
            $table->bigInteger('jumlah_kas')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ep_rencana_anggaran_biaya_uraians');
    }
};

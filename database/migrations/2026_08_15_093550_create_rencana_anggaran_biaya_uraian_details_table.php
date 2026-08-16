<?php

use App\Models\ParameterKas;
use App\Models\RencanaAnggaranBiaya;
use App\Models\RencanaAnggaranBiayaBidang;
use App\Models\RencanaAnggaranBiayaUraian;
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
        Schema::create('ep_rencana_anggaran_biaya_uraian_details', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(RencanaAnggaranBiaya::class, 'rab_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(RencanaAnggaranBiayaBidang::class, 'rabb_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(RencanaAnggaranBiayaUraian::class, 'rabu_id')->constrained()->cascadeOnDelete();

            $table->string('judul')->nullable();
            $table->foreignIdFor(ParameterKas::class, 'kas_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->string('kode_kas')->nullable();
            $table->string('nama_kas')->nullable();
            $table->bigInteger('volume')->default(0);
            $table->string('indikator')->default('Org/Bln');
            $table->bigInteger('harga_satuan')->default(0);
            $table->bigInteger('jumlah')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ep_rencana_anggaran_biaya_uraian_details');
    }
};

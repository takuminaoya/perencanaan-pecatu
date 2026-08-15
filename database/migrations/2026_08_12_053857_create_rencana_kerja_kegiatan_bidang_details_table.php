<?php

use App\Models\ParameterBidang;
use App\Models\RencanaKerjaKegiatan;
use App\Models\RencanaKerjaKegiatanBidang;
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
        Schema::create('ep_rencana_kerja_kegiatan_bidang_details', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(RencanaKerjaKegiatanBidang::class, 'bidang_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(RencanaKerjaKegiatan::class, 'rkp_id')->constrained();
            $table->foreignIdFor(ParameterBidang::class, 'kegiatan_id')->constrained();

            $table->longText('nama_sub')->nullable();
            $table->longText('nama_kegiatan')->nullable();

            $table->longText('lokasi')->nullable();
            $table->integer('volume')->default(0);
            $table->string('satuan')->nullable();

            $table->bigInteger('sumber_biaya')->default(0);
            $table->string('sumber_kode')->default('PBH');

            // sasaran
            $table->integer('laki_laki')->default(0);
            $table->integer('perempuan')->default(0);
            $table->integer('artm')->default(0);

            // waktu pelaksanaan
            $table->integer('durasi')->nullable();
            $table->string('satuan_durasi')->default('bulan');

            $table->date('mulai')->nullable();
            $table->date('selesai')->nullable();

            $table->string('pelaksana_kegiatan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ep_rencana_kerja_kegiatan_bidang_details');
    }
};

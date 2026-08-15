<?php

use App\Models\ParameterBidang;
use App\Models\RencanaKerjaKegiatan;
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
        Schema::create('ep_rencana_kerja_kegiatan_bidangs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(RencanaKerjaKegiatan::class, 'rkp_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(ParameterBidang::class, 'bidang_id')->constrained()->cascadeOnDelete();
            $table->longText('nama_bidang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ep_rencana_kerja_kegiatan_bidangs');
    }
};

<?php

use App\Models\AnggaranPendapatanBelanjaDesa;
use App\Models\APBDRincianSubUtama;
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
        Schema::table('ep_rencana_anggaran_biaya_bidangs', function (Blueprint $table) {
            $table->foreignIdFor(AnggaranPendapatanBelanjaDesa::class, 'apbd_id')->after('rab_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(APBDRincianSubUtama::class, 'apbdrsu_id')->after('apbd_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ep_rencana_anggaran_biaya_bidangs', function (Blueprint $table) {
            $table->dropForeignIdFor(AnggaranPendapatanBelanjaDesa::class, 'apbd_id');
            $table->dropForeignIdFor(APBDRincianSubUtama::class, 'apbdrsu_id');
        });
    }
};

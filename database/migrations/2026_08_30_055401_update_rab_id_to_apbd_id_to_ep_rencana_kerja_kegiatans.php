<?php

use App\Models\AnggaranPendapatanBelanjaDesa;
use App\Models\RencanaAnggaranBiaya;
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
        Schema::table('ep_rencana_kerja_kegiatans', function (Blueprint $table) {
            $table->dropForeign(['rab_id']);
            $table->dropColumn('rab_id');

            $table->foreignIdFor(AnggaranPendapatanBelanjaDesa::class, 'apbd_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ep_rencana_kerja_kegiatans', function (Blueprint $table) {
            $table->dropForeign(['apbd_id']);
            $table->dropColumn('apbd_id');
            
            $table->foreignIdFor(RencanaAnggaranBiaya::class, 'rab_id')->constrained()->cascadeOnDelete();
        });
    }
};

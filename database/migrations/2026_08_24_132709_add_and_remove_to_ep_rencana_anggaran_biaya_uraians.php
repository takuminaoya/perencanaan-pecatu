<?php

use App\Models\ParameterKegiatan;
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
        Schema::table('ep_rencana_anggaran_biaya_uraians', function (Blueprint $table) {
            $table->foreignIdFor(ParameterKegiatan::class, 'kegiatan_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ep_rencana_anggaran_biaya_uraians', function (Blueprint $table) {
            $table->dropForeignIdFor(ParameterKegiatan::class, 'kegiatan_id');
        });
    }
};

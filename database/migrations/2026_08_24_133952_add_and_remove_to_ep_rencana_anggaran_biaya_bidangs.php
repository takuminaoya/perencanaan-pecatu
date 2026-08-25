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
        Schema::table('ep_rencana_anggaran_biaya_bidangs', function (Blueprint $table) {
            $table->string('kode_kegiatan')->nullable();
            $table->foreignIdFor(ParameterBidang::class, 'bidang_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ep_rencana_anggaran_biaya_bidangs', function (Blueprint $table) {
            $table->dropColumn('kode_kegiatan');
            $table->dropForeignIdFor(ParameterBidang::class, 'bidang_id');
        });
    }
};

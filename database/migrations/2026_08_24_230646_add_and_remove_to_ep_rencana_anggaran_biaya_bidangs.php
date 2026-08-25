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
            $table->foreignIdFor(ParameterBidang::class, 'main_bidang_id')->nullable()->after('kode_kegiatan')->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->foreignIdFor(ParameterBidang::class, 'sub_bidang_id')->nullable()->after('main_bidang_id')->constrained()->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ep_rencana_anggaran_biaya_bidangs', function (Blueprint $table) {
            $table->dropForeignIdFor(ParameterBidang::class, 'main_bidang_id');
            $table->dropForeignIdFor(ParameterBidang::class, 'sub_bidang_id');
        });
    }
};

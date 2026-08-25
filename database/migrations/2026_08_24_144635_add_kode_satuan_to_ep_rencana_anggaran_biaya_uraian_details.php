<?php

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
        Schema::table('ep_rencana_anggaran_biaya_uraian_details', function (Blueprint $table) {
            $table->string('kode_satuan')->default('add');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ep_rencana_anggaran_biaya_uraian_details', function (Blueprint $table) {
            $table->dropColumn('kode_satuan');
        });
    }
};

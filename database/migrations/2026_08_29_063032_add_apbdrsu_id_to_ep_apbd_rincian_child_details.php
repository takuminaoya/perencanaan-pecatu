<?php

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
        Schema::table('ep_apbd_rincian_child_details', function (Blueprint $table) {
            $table->foreignIdFor(APBDRincianSubUtama::class, 'apbdrsu_id')->after('apbdru_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ep_apbd_rincian_child_details', function (Blueprint $table) {
            $table->dropForeign(['apbdrsu_id']);
            $table->dropColumn('apbdrsu_id');
        });
    }
};

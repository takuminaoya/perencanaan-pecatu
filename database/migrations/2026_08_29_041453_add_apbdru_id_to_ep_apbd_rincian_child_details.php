<?php

use App\Models\APBDRicianChildDetail;
use App\Models\APBDRincianUtama;
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
            $table->foreignIdFor(APBDRincianUtama::class, 'apbdru_id')->after('apbdsc_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ep_apbd_rincian_child_details', function (Blueprint $table) {
            $table->dropForeign(['apbdru_id']);
            $table->dropColumn('apbdru_id');
        });
    }
};

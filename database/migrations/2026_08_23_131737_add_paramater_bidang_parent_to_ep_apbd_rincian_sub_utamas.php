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
        Schema::table('ep_apbd_rincian_sub_utamas', function (Blueprint $table) {
            $table->foreignIdFor(ParameterBidang::class, 'parent_bidang_id')->nullable()->after('apbdsb_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ep_apbd_rincian_sub_utamas', function (Blueprint $table) {
            $table->dropColumn('parent_bidang_id');
        });
    }
};

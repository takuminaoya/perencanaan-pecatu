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
        Schema::table('ep_apbd_rincian_utamas', function (Blueprint $table) {
            $table->foreignIdFor(ParameterBidang::class, 'main_id')->after('kas_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(ParameterBidang::class, 'sub_id')->after('main_id')->nullable()->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ep_apbd_rincian_utamas', function (Blueprint $table) {
            $table->dropForeign(['main_id']);
            $table->dropColumn('main_id');
            $table->dropForeign(['sub_id']);
            $table->dropColumn('sub_id');
        });
    }
};

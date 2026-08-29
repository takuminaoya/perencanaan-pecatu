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
        Schema::table('ep_apbd_rincian_sub_utamas', function (Blueprint $table) {
            $table->dropColumn('semula');
            $table->dropColumn('menjadi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ep_apbd_rincian_sub_utamas', function (Blueprint $table) {
            $table->bigInteger('semula')->default(0);
            $table->bigInteger('menjadi')->default(0);
        });
    }
};

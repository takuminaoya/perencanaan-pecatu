<?php

use App\Models\ParameterSumberDana;
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
            $table->foreignIdFor(ParameterSumberDana::class, 'sumber_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ep_apbd_rincian_child_details', function (Blueprint $table) {
            $table->dropForeign(['sumber_id']);
            $table->dropColumn('sumber_id');
        });
    }
};

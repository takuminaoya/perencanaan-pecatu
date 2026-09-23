<?php

use App\Models\ParameterGroupBidang;
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
        Schema::create('ep_parameter_group_bidangs', function (Blueprint $table) {
            $table->id();
            $table->longText('nama');
            $table->timestamps();
        });

        Schema::table('ep_apbd_kas_flows', function (Blueprint $table) {
            $table->foreignIdFor(ParameterGroupBidang::class, 'group_id')->after('sub_kegiatan_id')->nullable()->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ep_apbd_kas_flows', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
            $table->dropColumn('group_id');
        });

        Schema::dropIfExists('ep_parameter_group_bidangs');
    }
};

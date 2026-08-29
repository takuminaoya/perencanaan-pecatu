<?php

use App\Models\ParameterKegiatan;
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
            $table->foreignIdFor(ParameterKegiatan::class, 'kegiatan_id')->nullable()->after('bidang_id')->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->string('tipe')->default('masuk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ep_apbd_rincian_sub_utamas', function (Blueprint $table) {
            $table->dropForeign(['kegiatan_id']);
            $table->dropColumn('kegiatan_id');
            $table->dropColumn('tipe');

        });
    }
};

<?php

use App\Models\MasterJabatan;
use App\Models\User;
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
            $table->integer('sasaran_male');
            $table->integer('sasaran_female')->default(0);
            $table->integer('sasaran_artm')->default(0);

            $table->foreignIdFor(MasterJabatan::class, 'pelaksana_id')->nullable()->constrained()->nullOnDelete();
            $table->string('pelaksana')->nullable();
            $table->longText('tim_pelaksana')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ep_apbd_rincian_child_details', function (Blueprint $table) {
            $table->dropColumn('sasaran_male');
            $table->dropColumn('sasaran_female');
            $table->dropColumn('sasaran_artm');

            $table->dropForeign(['pelaksana_id']);
            $table->dropColumn('pelaksana_id');

            $table->dropColumn('pelaksana');
            $table->dropColumn('tim_pelaksana');
        });
    }
};

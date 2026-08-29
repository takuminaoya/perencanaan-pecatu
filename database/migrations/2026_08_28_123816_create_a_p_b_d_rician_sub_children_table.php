<?php

use App\Models\AnggaranPendapatanBelanjaDesa;
use App\Models\APBDRincianSubUtama;
use App\Models\APBDRincianUtama;
use App\Models\ParameterKas;
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
        Schema::create('ep_apbd_rincian_sub_children', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(AnggaranPendapatanBelanjaDesa::class, 'apbd_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(APBDRincianSubUtama::class, 'apbdsu_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(ParameterKas::class, 'kas_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ep_apbd_rincian_sub_children');
    }
};

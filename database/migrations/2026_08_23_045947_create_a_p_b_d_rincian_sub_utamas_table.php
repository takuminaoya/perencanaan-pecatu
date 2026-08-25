<?php

use App\Models\AnggaranPendapatanBelanjaDesa;
use App\Models\APBDDetailSub;
use App\Models\APBDDetailSubMain;
use App\Models\APBDRincianUtama;
use App\Models\ParameterBidang;
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
        Schema::create('ep_apbd_rincian_sub_utamas', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(AnggaranPendapatanBelanjaDesa::class, 'apbd_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(APBDRincianUtama::class, 'apbdru_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(ParameterKas::class, 'kas_id')->nullable();

            // pilihan
            $table->foreignIdFor(APBDDetailSubMain::class, 'apbdsm_id')->nullable();
            $table->foreignIdFor(APBDDetailSub::class, 'apbdsb_id')->nullable();
            // bidang
            $table->foreignIdFor(ParameterBidang::class, 'bidang_id')->nullable();

            $table->bigInteger('semula')->default(0);
            $table->bigInteger('menjadi')->default(0);

            $table->string('sumber_dana')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ep_apbd_rincian_sub_utamas');
    }
};

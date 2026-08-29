<?php

use App\Models\AnggaranPendapatanBelanjaDesa;
use App\Models\APBDRicianSubChild;
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
        Schema::create('ep_apbd_rincian_child_details', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(AnggaranPendapatanBelanjaDesa::class, 'apbd_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(APBDRicianSubChild::class, 'apbdsc_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(ParameterKas::class, 'kas_id')->nullable();

            $table->longText('judul');
            
            $table->bigInteger('semula_volume')->default(0);
            $table->bigInteger('semula_satuan')->default(0);
            $table->string('semula_indikator')->default('Tahun');
            $table->bigInteger('semula_total')->default(0);

            $table->bigInteger('menjadi_volume')->default(0);
            $table->bigInteger('menjadi_satuan')->default(0);
            $table->string('menjadi_indikator')->default('Tahun');
            $table->bigInteger('menjadi_total')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ep_apbd_rincian_child_details');
    }
};

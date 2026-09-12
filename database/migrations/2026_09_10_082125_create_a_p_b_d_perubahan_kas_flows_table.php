<?php

use App\Models\APBDKasFlow;
use App\Models\APBDPerubahan;
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
        Schema::create('ep_apbd_perubahan_kas_flows', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(APBDKasFlow::class, 'kas_flow_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(APBDPerubahan::class, 'perubahan_id')->constrained()->cascadeOnDelete();

            $table->bigInteger('volume')->default(0);
            $table->string('indikator_volume')->default('tahun');
            $table->bigInteger('satuan')->default(0);
            $table->bigInteger('jumlah')->default(0);

            $table->longText('detail_paket')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ep_apbd_perubahan_kas_flows');
    }
};

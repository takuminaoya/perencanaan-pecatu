<?php

use App\Models\AnggaranPendapatanBelanjaDesa;
use App\Models\APBDDetailMain;
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
        Schema::create('ep_apbd_detail_sub_mains', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(AnggaranPendapatanBelanjaDesa::class, 'apbd_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(APBDDetailMain::class, 'apbdm_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(ParameterKas::class)->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ep_apbd_detail_sub_mains');
    }
};

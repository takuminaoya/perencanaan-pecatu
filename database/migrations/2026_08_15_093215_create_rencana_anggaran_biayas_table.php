<?php

use App\Models\RencanaKerjaKegiatan;
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
        Schema::create('ep_rencana_anggaran_biayas', function (Blueprint $table) {
            $table->id();
            $table->uuid();

            $table->foreignIdFor(RencanaKerjaKegiatan::class, 'rkk_id')->constrained()->cascadeOnDelete();

            $table->string('judul')->default('rencana anggaran biaya');
            $table->integer('tahun')->default(2026);
            $table->string('status')->default('draft');
            $table->string('jenis')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ep_rencana_anggaran_biayas');
    }
};

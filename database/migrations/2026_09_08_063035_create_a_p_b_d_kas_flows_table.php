<?php

use App\Models\APBD;
use App\Models\MasterJabatan;
use App\Models\ParameterBidang;
use App\Models\ParameterKas;
use App\Models\ParameterKegiatan;
use App\Models\ParameterSumberDana;
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
        Schema::create('ep_apbd_kas_flows', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(APBD::class, 'apbd_id')->constrained()->cascadeOnDelete();

            $table->foreignIdFor(ParameterKas::class, 'utama_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(ParameterKas::class, 'sub_utama_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(ParameterKas::class, 'sub_sutama_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(ParameterKas::class, 'sub_ssutama_id')->nullable()->constrained()->nullOnDelete();

            $table->string('judul')->nullable();

            $table->bigInteger('volume')->default(0);
            $table->string('indikator_volume')->default('tahun');
            $table->bigInteger('satuan')->default(0);
            $table->bigInteger('jumlah')->default(0);

            $table->longText('detail_paket')->nullable();

            // Keluaran
            $table->foreignIdFor(ParameterBidang::class, 'bidang_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(ParameterBidang::class, 'sub_bidang_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(ParameterBidang::class, 'kegiatan_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(ParameterKegiatan::class, 'sub_kegiatan_id')->nullable()->constrained()->nullOnDelete();

            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->longText('keluaran')->nullable();

            $table->foreignIdFor(MasterJabatan::class, 'pelaksana_id')->nullable()->constrained()->nullOnDelete();

            $table->foreignIdFor(ParameterSumberDana::class, 'sumber_id')->nullable()->constrained()->nullOnDelete();
            $table->string('tipe')->default('masuk');

            $table->foreignIdFor(User::class, 'dibuat_oleh')->constrained()->cascadeOnDelete();
            $table->timestamps();   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ep_apbd_kas_flows');
    }
};

<?php

use App\Models\APBD;
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
        Schema::create('ep_apbd_perubahans', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(APBD::class, 'apbd_id')->constrained()->cascadeOnDelete();

            $table->string('judul')->default('Perubahan Anggaran Pendapatan Dan Belanja Desa Pecatu');
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ep_apbd_perubahans');
    }
};

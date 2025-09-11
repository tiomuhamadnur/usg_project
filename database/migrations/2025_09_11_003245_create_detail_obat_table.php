<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_obat', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->bigInteger('pemeriksaan_id')->unsigned()->nullable();
            $table->bigInteger('obat_id')->unsigned()->nullable();
            $table->string('jumlah')->nullable();
            $table->string('dosis')->nullable();
            $table->string('aturan_pakai')->nullable();
            $table->string('catatan_obat')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('pemeriksaan_id')->on('pemeriksaan')->references('id');
            $table->foreign('obat_id')->on('obat')->references('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_obat');
    }
};

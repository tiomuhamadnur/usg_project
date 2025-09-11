<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_layanan', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->bigInteger('pemeriksaan_id')->unsigned()->nullable();
            $table->bigInteger('layanan_id')->unsigned()->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('pemeriksaan_id')->on('pemeriksaan')->references('id');
            $table->foreign('layanan_id')->on('layanan')->references('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_layanan');
    }
};

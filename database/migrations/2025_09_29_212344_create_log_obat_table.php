<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_obat', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->enum('tipe', ['+', '-'])->nullable();
            $table->bigInteger('obat_id')->unsigned()->nullable();
            $table->bigInteger('pemeriksaan_id')->unsigned()->nullable();
            $table->bigInteger('qty')->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->text('catatan')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('pemeriksaan_id')->on('pemeriksaan')->references('id');
            $table->foreign('obat_id')->on('obat')->references('id');
            $table->foreign('user_id')->on('users')->references('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_obat');
    }
};

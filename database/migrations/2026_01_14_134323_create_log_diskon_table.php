<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_diskon', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('code')->unique()->nullable();
            $table->bigInteger('pemeriksaan_id')->unsigned()->nullable();
            $table->bigInteger('diskon_id')->unsigned()->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('pemeriksaan_id')->on('pemeriksaan')->references('id');
            $table->foreign('diskon_id')->on('diskon')->references('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_diskon');
    }
};

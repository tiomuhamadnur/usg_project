<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelurahan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kecamatan_id')->unsigned()->nullable();
            $table->string('name')->nullable();

            $table->foreign('kecamatan_id')->on('kecamatan')->references('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelurahan');
    }
};

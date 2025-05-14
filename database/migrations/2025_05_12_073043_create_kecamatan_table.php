<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kecamatan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kota_id')->unsigned()->nullable();
            $table->string('name')->nullable();

            $table->foreign('kota_id')->on('kota')->references('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kecamatan');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kota', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('provinsi_id')->unsigned()->nullable();
            $table->string('name')->nullable();

            $table->foreign('provinsi_id')->on('provinsi')->references('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kota');
    }
};

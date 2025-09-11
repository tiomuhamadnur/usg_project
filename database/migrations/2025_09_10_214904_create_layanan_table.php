<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('layanan', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('code')->unique()->nullable();
            $table->string('name')->nullable();
            $table->text('deskripsi')->nullable();
            $table->bigInteger('harga')->nullable();
            $table->bigInteger('kategori_id')->unsigned()->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('kategori_id')->on('kategori')->references('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanan');
    }
};

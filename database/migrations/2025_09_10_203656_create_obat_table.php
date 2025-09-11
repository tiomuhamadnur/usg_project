<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('obat', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('code')->unique()->nullable();
            $table->string('name')->nullable();
            $table->string('kandungan')->nullable();
            $table->bigInteger('stock')->nullable();
            $table->string('bpom')->nullable();
            $table->bigInteger('harga_modal')->nullable();
            $table->bigInteger('harga_jual')->nullable();
            $table->string('merk')->nullable();
            $table->text('deskripsi')->nullable();
            $table->bigInteger('unit_id')->unsigned()->nullable();
            $table->bigInteger('sediaan_id')->unsigned()->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('unit_id')->on('unit')->references('id');
            $table->foreign('sediaan_id')->on('sediaan')->references('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('obat');
    }
};

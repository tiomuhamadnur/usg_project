<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('device', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->bigInteger('room_id')->unsigned()->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('room_id')->on('room')->references('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('device');
    }
};

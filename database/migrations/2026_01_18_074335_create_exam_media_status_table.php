<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_media_status', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->bigInteger('pemeriksaan_id')->unsigned()->nullable();
            $table->enum('media_type', ['photo', 'video']);
            $table->text('media_path')->nullable();
            $table->timestamp('last_checked_at')->nullable();
            $table->boolean('sent_status')->default(false);
            $table->timestamp('sent_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('pemeriksaan_id')->on('pemeriksaan')->references('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_media_status');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemeriksaan', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('code')->unique()->nullable();
            $table->bigInteger('pasien_id')->unsigned()->nullable();
            $table->dateTime('datetime')->nullable();
            $table->bigInteger('room_id')->unsigned()->nullable();
            $table->text('rencana_pasien')->nullable();
            $table->text('keluhan_pasien')->nullable();
            $table->text('alergi_obat')->nullable();
            $table->text('alergi_makanan')->nullable();
            $table->bigInteger('admin_id')->unsigned()->nullable();

            $table->string('nadi')->nullable();
            $table->string('temperatur')->nullable();
            $table->string('napas')->nullable();
            $table->string('tekanan_darah_systolic')->nullable();
            $table->string('tekanan_darah_diastolic')->nullable();
            $table->string('tinggi_badan')->nullable();
            $table->string('berat_badan')->nullable();
            $table->string('lingkar_perut')->nullable();
            $table->bigInteger('suster_id')->unsigned()->nullable();

            $table->text('keluhan_utama')->nullable();
            $table->text('keluhan_tambahan')->nullable();
            $table->text('diagnosa_utama')->nullable();
            $table->text('diagnosa_sekunder')->nullable();
            $table->text('hasil_pemeriksaan')->nullable();
            $table->text('terapi_obat')->nullable();
            $table->text('saran')->nullable();
            $table->text('resep_dokter')->nullable();
            $table->text('tindakan')->nullable();
            $table->text('rujukan')->nullable();
            $table->bigInteger('dokter_id')->unsigned()->nullable();
            $table->bigInteger('status_pemeriksaan_id')->unsigned()->nullable();

            $table->bigInteger('total_bayar')->nullable();
            $table->bigInteger('metode_pembayaran_id')->unsigned()->nullable();
            $table->bigInteger('status_pembayaran_id')->unsigned()->nullable();
            $table->bigInteger('kasir_id')->unsigned()->nullable();
            $table->string('no_urut')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // Foreign Key
            $table->foreign('pasien_id')->on('pasien')->references('id');
            $table->foreign('room_id')->on('room')->references('id');
            $table->foreign('admin_id')->on('users')->references('id');
            $table->foreign('suster_id')->on('users')->references('id');
            $table->foreign('dokter_id')->on('users')->references('id');
            $table->foreign('status_pemeriksaan_id')->on('status_pemeriksaan')->references('id');
            $table->foreign('metode_pembayaran_id')->on('metode_pembayaran')->references('id');
            $table->foreign('status_pembayaran_id')->on('status_pembayaran')->references('id');
            $table->foreign('kasir_id')->on('users')->references('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan');
    }
};

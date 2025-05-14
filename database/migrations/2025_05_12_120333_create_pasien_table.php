<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pasien', function (Blueprint $table) {
            // Table
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('member_code')->unique()->nullable();
            $table->string('name')->nullable();
            $table->bigInteger('gender_id')->unsigned()->nullable();
            $table->string('nik')->unique()->nullable();
            $table->string('no_bpjs')->unique()->nullable();
            $table->string('no_rm')->unique()->nullable();
            $table->string('satu_sehat_id')->unique()->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('email')->unique()->nullable();
            $table->bigInteger('agama_id')->unsigned()->nullable();
            $table->bigInteger('pendidikan_id')->unsigned()->nullable();
            $table->bigInteger('pekerjaan_id')->unsigned()->nullable();
            $table->bigInteger('golongan_darah_id')->unsigned()->nullable();
            $table->text('alamat')->nullable();
            $table->bigInteger('provinsi_id')->unsigned()->nullable();
            $table->bigInteger('kota_id')->unsigned()->nullable();
            $table->bigInteger('kecamatan_id')->unsigned()->nullable();
            $table->bigInteger('kelurahan_id')->unsigned()->nullable();
            $table->text('alergi_obat')->nullable();
            $table->text('alergi_makanan')->nullable();

            $table->bigInteger('hubungan_pasien_id')->unsigned()->nullable();
            $table->string('pj_name')->nullable();
            $table->bigInteger('pj_gender_id')->unsigned()->nullable();
            $table->string('pj_nik')->nullable();
            $table->string('pj_no_hp')->nullable();
            $table->text('pj_alamat')->nullable();
            $table->bigInteger('pj_provinsi_id')->unsigned()->nullable();
            $table->bigInteger('pj_kota_id')->unsigned()->nullable();
            $table->bigInteger('pj_kecamatan_id')->unsigned()->nullable();
            $table->bigInteger('pj_kelurahan_id')->unsigned()->nullable();
            $table->softDeletes();
            $table->timestamps();

            // Foreign Key
            $table->foreign('gender_id')->on('gender')->references('id');
            $table->foreign('agama_id')->on('agama')->references('id');
            $table->foreign('pendidikan_id')->on('pendidikan')->references('id');
            $table->foreign('pekerjaan_id')->on('pekerjaan')->references('id');
            $table->foreign('golongan_darah_id')->on('golongan_darah')->references('id');
            $table->foreign('provinsi_id')->on('provinsi')->references('id');
            $table->foreign('kota_id')->on('kota')->references('id');
            $table->foreign('kecamatan_id')->on('kecamatan')->references('id');
            $table->foreign('kelurahan_id')->on('kelurahan')->references('id');

            $table->foreign('hubungan_pasien_id')->on('hubungan_pasien')->references('id');
            $table->foreign('pj_gender_id')->on('gender')->references('id');
            $table->foreign('pj_provinsi_id')->on('provinsi')->references('id');
            $table->foreign('pj_kota_id')->on('kota')->references('id');
            $table->foreign('pj_kecamatan_id')->on('kecamatan')->references('id');
            $table->foreign('pj_kelurahan_id')->on('kelurahan')->references('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pasien');
    }
};

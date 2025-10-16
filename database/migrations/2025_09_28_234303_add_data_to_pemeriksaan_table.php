<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pemeriksaan', function (Blueprint $table) {
            $table->dateTime('datetime_registrasi')->nullable()->after('datetime');
            $table->dateTime('datetime_pemeriksaan_awal')->nullable()->after('datetime_registrasi');
            $table->dateTime('datetime_pemeriksaan_dokter')->nullable()->after('datetime_pemeriksaan_awal');
            $table->dateTime('datetime_invoice')->nullable()->after('datetime_pemeriksaan_dokter');
        });
    }

    public function down(): void
    {
        Schema::table('pemeriksaan', function (Blueprint $table) {
            $table->dropColumn('datetime_registrasi');
            $table->dropColumn('datetime_pemeriksaan_awal');
            $table->dropColumn('datetime_pemeriksaan_dokter');
            $table->dropColumn('datetime_invoice');
        });
    }
};

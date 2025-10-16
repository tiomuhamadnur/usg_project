<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->string('berat_badan')->nullable()->after('hpht');
            $table->string('tinggi_badan')->nullable()->after('berat_badan');
            $table->string('lingkar_perut')->nullable()->after('tinggi_badan');
        });
    }

    public function down(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->dropColumn('berat_badan');
            $table->dropColumn('tinggi_badan');
            $table->dropColumn('lingkar_perut');
        });
    }
};

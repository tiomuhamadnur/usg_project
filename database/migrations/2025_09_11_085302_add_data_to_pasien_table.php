<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->date('hpht')->nullable()->after('no_hp');
            $table->date('hpl')->nullable()->after('no_hp');
            $table->string('gravida')->nullable()->after('no_hp');
            $table->string('para')->nullable()->after('no_hp');
            $table->string('abortus')->nullable()->after('no_hp');
        });
    }

    public function down(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->dropColumn('hpht');
            $table->dropColumn('hpl');
            $table->dropColumn('gravida');
            $table->dropColumn('para');
            $table->dropColumn('abortus');
        });
    }
};

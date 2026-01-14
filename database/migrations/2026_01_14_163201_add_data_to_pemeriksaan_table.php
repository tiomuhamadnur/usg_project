<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pemeriksaan', function (Blueprint $table) {
            $table->bigInteger('total_diskon')->nullable()->after('total_bayar');
            $table->bigInteger('total_grand')->nullable()->after('total_diskon');
        });
    }

    public function down(): void
    {
        Schema::table('pemeriksaan', function (Blueprint $table) {
            $table->dropColumn(['total_diskon', 'total_grand']);
        });
    }
};

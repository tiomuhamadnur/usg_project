<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_obat', function (Blueprint $table) {
            $table->boolean('is_confirmed')->nullable()->default(false)->after('catatan_obat');
        });
    }

    public function down(): void
    {
        Schema::table('detail_obat', function (Blueprint $table) {
            $table->dropColumn('is_confirmed');
        });
    }
};

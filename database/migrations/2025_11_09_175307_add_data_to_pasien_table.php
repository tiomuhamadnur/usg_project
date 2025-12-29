<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->bigInteger('campaign_id')->unsigned()->nullable()->after('alergi_makanan');

            $table->foreign('campaign_id')->on('campaign')->references('id');
        });
    }

    public function down(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->dropForeign(['campaign_id']);

            $table->dropColumn('campaign_id');
        });
    }
};

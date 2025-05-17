<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('uuid')->unique()->nullable()->after('id');
            $table->bigInteger('role_id')->unsigned()->nullable()->after('email');
            $table->bigInteger('gender_id')->unsigned()->nullable()->after('email');
            $table->string('no_hp')->nullable()->after('email');
            $table->string('gelar_belakang')->nullable()->after('email');
            $table->string('gelar_depan')->nullable()->after('email');
            $table->softDeletes()->before('created_at');

            $table->foreign('role_id')->on('role')->references('id');
            $table->foreign('gender_id')->on('gender')->references('id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revert foreign keys
            $table->dropForeign(['role_id']);
            $table->dropForeign(['gender_id']);

            // Revert column changes
            $table->dropColumn('uuid');
            $table->dropColumn('role_id');
            $table->dropColumn('gender_id');
            $table->dropColumn('gelar_depan');
            $table->dropColumn('gelar_belakang');
            $table->dropColumn('no_hp');
        });
    }
};

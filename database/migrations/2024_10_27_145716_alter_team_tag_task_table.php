<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('team_tag_task', function (Blueprint $table) {
            $table->unsignedBigInteger('team_tag_id');
            $table->foreign('team_tag_id')->references('id')->on('team_tags')->onDelete('cascade');
            $table->dropForeign(['team_id']);
            $table->dropColumn('team_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('team_tag_task', function (Blueprint $table) {
            $table->unsignedBigInteger('team_id');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->dropForeign(['team_tag_id']);
            $table->dropColumn('team_tag_id');

        });
    }
};

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
        Schema::table('team_task_user', function (Blueprint $table) {
            $table->dropColumn(['email_reminder','push_reminder']);
        });

        Schema::drop('team_tag_user');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('team_task_user', function (Blueprint $table) {
            $table->boolean('email_reminder')->default(false);
            $table->boolean('push_reminder')->default(false);
        });

        Schema::create('team_tag_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id');
            $table->unsignedBigInteger('team_tag_id');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('team_tag_id')->references('id')->on('team_tags')->onDelete('cascade');
            $table->timestamps();
        });
    }
};

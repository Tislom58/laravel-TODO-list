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
            $table->boolean('email_reminder')->default('0');
            $table->boolean('push_reminder')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('team_task_user', function (Blueprint $table) {
            //
        });
    }
};

<?php

use App\Models\TeamTask;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reminder_preferences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_task_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('email_reminder')->default(false);
            $table->boolean('push_reminder')->default(false);
            $table->foreign('team_task_id')->references('id')->on('team_tasks')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        $team_tasks = TeamTask::all();
        foreach($team_tasks as $task) {
            foreach ($task->team->members as $member) {
                DB::table('reminder_preferences')->insert([
                    'team_task_id' => $task->id,
                    'user_id' => $member->id,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminder_preferences');
    }
};

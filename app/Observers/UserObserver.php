<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        //
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        if ($user->wasChanged('team_id') && isset($user->team_id)) {
            $team_tasks = $user->team->tasks;
            foreach ($team_tasks as $task) {
                DB::table('reminder_preferences')->insert([
                    'team_task_id' => $task->id,
                    'user_id' => $user->id,
                ]);
            }
        }
        elseif ($user->wasChanged('team_id') && !isset($user->team_id)) {
            DB::table('reminder_preferences')
                ->where('user_id', $user->id)
                ->delete();

            DB::table('team_tasks')
                ->where('author_id', $user->id)
                ->delete();

            DB::table('team_tags')
                ->where('author_id', $user->id)
                ->delete();

            DB::table('team_task_user')
                ->where('user_id', $user->id)
                ->delete();
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}

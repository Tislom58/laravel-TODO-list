<?php

namespace App\Observers;

use App\Models\TeamTask;
use Illuminate\Support\Facades\DB;

class TeamTaskObserver
{
    /**
     * Handle the TeamTask "created" event.
     */
    public function created(TeamTask $teamTask): void
    {
        $team_members = $teamTask->team->members;
        foreach ($team_members as $member) {
            DB::table('reminder_preferences')->insert([
                'team_task_id' => $teamTask->id,
                'user_id' => $member->id,
            ]);
        }
    }

    /**
     * Handle the TeamTask "updated" event.
     */
    public function updated(TeamTask $teamTask): void
    {
        //
    }

    /**
     * Handle the TeamTask "deleted" event.
     */
    public function deleted(TeamTask $teamTask): void
    {
        //
    }

    /**
     * Handle the TeamTask "restored" event.
     */
    public function restored(TeamTask $teamTask): void
    {
        //
    }

    /**
     * Handle the TeamTask "force deleted" event.
     */
    public function forceDeleted(TeamTask $teamTask): void
    {
        //
    }
}

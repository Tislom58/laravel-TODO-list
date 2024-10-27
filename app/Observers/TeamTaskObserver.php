<?php

namespace App\Observers;

use App\Models\TeamTask;

class TeamTaskObserver
{
    /**
     * Handle the TeamTask "created" event.
     */
    public function created(TeamTask $teamTask): void
    {
        //
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

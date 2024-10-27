<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TeamTaskUser extends Model
{
    use HasFactory;

    protected $table = 'team_task_user';

    public function team_tasks(): belongsToMany
    {
        return $this->belongsToMany(TeamTask::class);
    }
}

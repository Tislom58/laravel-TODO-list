<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamTaskUser extends Model
{
    use HasFactory;

    protected $table = 'team_task_user';

    public function team_tasks()
    {
        return $this->belongsToMany(TeamTask::class);
    }
}

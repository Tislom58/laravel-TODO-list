<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(TeamTask::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function team_tags(): HasMany
    {
        return $this->hasMany(TeamTag::class);
    }
}

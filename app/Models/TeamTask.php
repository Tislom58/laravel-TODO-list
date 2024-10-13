<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TeamTask extends Model
{
    use HasFactory;

    public function users(): belongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function author(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function team(): belongsTo
    {
        return $this->belongsTo(Team::class);
    }
}

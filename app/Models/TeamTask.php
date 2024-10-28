<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Observers\TeamTaskObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([TeamTaskObserver::class])]
class TeamTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'due_date',
    ];

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
    public function tags(): belongsToMany
    {
        return $this->belongsToMany(TeamTag::class);
    }
}

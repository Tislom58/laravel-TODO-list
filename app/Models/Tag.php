<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
    ];

    public function task(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'tasks_tags');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

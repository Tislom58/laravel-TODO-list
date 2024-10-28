<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'due_date',
    ];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'tasks_tags');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

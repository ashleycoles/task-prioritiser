<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property float $estimate
 * @property string $deadline
 * @property int $priority
 */
class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'estimate',
        'deadline',
    ];

    public function scopeOrderByPriority(Builder $query, string $direction = 'desc'): void
    {
        $query->orderBy('priority', $direction);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}

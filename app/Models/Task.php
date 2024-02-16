<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'description',
        'status',
        'assigned_to',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => TaskStatus::class,
    ];

    /**
     * The user assigned to this task.
     */
    public function assigned_to(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    /**
     * Whether the task is in pending status.
     */
    public function isPending(): bool
    {
        return $this->status == TaskStatus::Pending;
    }

    /**
     * Whether the task is in progress status.
     */
    public function isInProgress(): bool
    {
        return $this->status == TaskStatus::InProgress;
    }

    /**
     * Whether the task is in completed status.
     */
    public function isCompleted(): bool
    {
        return $this->status == TaskStatus::Completed;
    }
}

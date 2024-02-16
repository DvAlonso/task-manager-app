<?php

namespace App\Models;

use App\Concerns\Formattable;
use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model implements Formattable
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
        'assigned_user_id',
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

    /**
     * Move a task to a new status.
     */
    public function move(TaskStatus $status): void
    {
        $this->update([
            'status' => $status,
        ]);
    }

    /**
     * Assign the task to an user.
     */
    public function assign(User $user): void
    {
        $this->update([
            'assigned_user_id' => $user->id,
        ]);
    }

    /**
     * Unset the assigned user.
     */
    public function unassign(): void
    {
        $this->update([
            'assigned_user_id' => null
        ]);
    }

    /**
     * Format the entity for API response displaying.
     */
    public function format(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'assigned_to' => optional($this->assigned_to)->format(),
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }

    public static function booted()
    {
        // Set default status when creating a new task unless specified.
        static::creating(function (Task $task) {
            if (is_null($task->status)) {
                $task->status = TaskStatus::Pending;
            }
        });
    }
}

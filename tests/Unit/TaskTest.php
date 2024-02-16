<?php

namespace Tests\Unit;

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function test_task_is_pending(): void
    {
        $task = Task::factory()->status(TaskStatus::Pending)->make();
        $this->assertTrue($task->isPending());
    }

    public function test_task_is_in_progress(): void
    {
        $task = Task::factory()->status(TaskStatus::InProgress)->make();
        $this->assertTrue($task->isInProgress());
    }

    public function test_task_is_completed(): void
    {
        $task = Task::factory()->status(TaskStatus::Completed)->make();
        $this->assertTrue($task->isCompleted());
    }
}

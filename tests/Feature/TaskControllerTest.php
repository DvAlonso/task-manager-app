<?php

namespace Tests\Feature;

use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    public function test_task_list_can_be_retrieved(): void
    {
        $this->setUpApiUser();

        $response = $this->getJson(route('api:tasks:index'));

        $response->assertStatus(200);
    }

    public function test_task_can_be_shown(): void
    {
        $this->setUpApiUser();

        $task = Task::factory()->create();

        $response = $this->getJson(route('api:tasks:show', $task));

        $response->assertStatus(200);
    }

    public function test_task_can_be_created(): void
    {
        $this->setUpApiUser();

        $response = $this->postJson(route('api:tasks:store', [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(3),
        ]));

        $response->assertStatus(200);
        $this->assertDatabaseCount('tasks', 1);
    }

    public function test_task_can_be_updated(): void
    {
        $this->setUpApiUser();

        $task = Task::factory()->create();

        $response = $this->putJson(route('api:tasks:update', $task), [
            'title' => $title = fake()->sentence(),
            'description' => $description = fake()->paragraph(3),
        ]);

        $response->assertStatus(200);
        $task->refresh();
        $this->assertEquals($task->title, $title);
        $this->assertEquals($task->description, $description);
    }

    public function test_task_can_be_assigned(): void
    {
        $user = $this->setUpApiUser();

        $task = Task::factory()->create();

        $response = $this->putJson(route('api:tasks:assign', $task), [
            'user_id' => $user->id,
        ]);

        $response->assertStatus(200);
        $task->refresh();
        $this->assertTrue($task->isAssigned());
    }

    public function test_task_can_be_unassigned(): void
    {
        $this->setUpApiUser();

        $task = Task::factory()->create();

        $response = $this->putJson(route('api:tasks:assign', $task));

        $response->assertStatus(200);
        $task->refresh();
        $this->assertFalse($task->isAssigned());
    }

    public function test_task_can_be_moved(): void
    {
        $this->setUpApiUser();

        $task = Task::factory()->create();

        $response = $this->putJson(route('api:tasks:status', $task), [
            'status' => TaskStatus::InProgress,
        ]);
        $response->assertStatus(200);
        $task->refresh();
        $this->assertTrue($task->isInProgress());

        $response = $this->putJson(route('api:tasks:status', $task), [
            'status' => TaskStatus::Completed,
        ]);
        $response->assertStatus(200);
        $task->refresh();
        $this->assertTrue($task->isCompleted());

        $response = $this->putJson(route('api:tasks:status', $task), [
            'status' => TaskStatus::Pending,
        ]);
        $response->assertStatus(200);
        $task->refresh();
        $this->assertTrue($task->isPending());
        
    }

    public function test_task_can_be_deleted(): void
    {
        $this->setUpApiUser();

        $task = Task::factory()->create();

        $response = $this->deleteJson(route('api:tasks:delete', $task));

        $response->assertStatus(200);
        $this->assertSoftDeleted('tasks', [
            'id' => $task->id,
        ]);
    }

    public function test_validations_are_applied_on_creation(): void
    {
        $this->setUpApiUser();

        $response = $this->postJson(route('api:tasks:store'));

        $response->assertStatus(422);
    }

    public function test_validations_are_applied_on_update(): void
    {
        $this->setUpApiUser();

        $task = Task::factory()->create();

        $response = $this->putJson(route('api:tasks:update', $task));

        $response->assertStatus(422);
    }

    public function test_validations_are_applied_on_assign(): void
    {
        $this->setUpApiUser();

        $task = Task::factory()->create();

        $response = $this->putJson(route('api:tasks:assign', $task), [
            'user_id' => -1
        ]);

        $response->assertStatus(422);
    }

    public function test_validations_are_applied_on_move(): void
    {
        $this->setUpApiUser();

        $task = Task::factory()->create();

        $response = $this->putJson(route('api:tasks:status', $task), [
            'status' => 'wrong-status'
        ]);

        $response->assertStatus(422);
    }

    public function test_endpoints_are_protected_by_api_token(): void
    {
        $task = Task::factory()->create();

        $response = $this->getJson(route('api:tasks:index'));
        $response->assertStatus(401);

        $response = $this->getJson(route('api:tasks:show', $task));
        $response->assertStatus(401);

        $response = $this->postJson(route('api:tasks:store'));
        $response->assertStatus(401);

        $response = $this->putJson(route('api:tasks:update', $task));
        $response->assertStatus(401);

        $response = $this->putJson(route('api:tasks:assign', $task));
        $response->assertStatus(401);

        $response = $this->putJson(route('api:tasks:status', $task));
        $response->assertStatus(401);

        $response = $this->deleteJson(route('api:tasks:delete', $task));
        $response->assertStatus(401);


    }
}

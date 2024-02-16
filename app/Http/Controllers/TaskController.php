<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Helpers\PaginatorHelper;
use App\Http\Requests\Tasks\AssignTaskRequest;
use App\Http\Requests\Tasks\MoveTasksRequest;
use App\Http\Requests\Tasks\StoreTaskRequest;
use App\Http\Requests\Tasks\UpdateTaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    /**
     * Show a paginated list of tasks.
     */
    public function index(): JsonResponse
    {
        $tasks = Task::paginate(10);

        return response()->success([
            'paginator' => PaginatorHelper::format($tasks),
            'tasks' => $tasks->transform(function (Task $task) {
                return $task->format();
            }),
        ]);
    }

    /**
     * Create a new task.
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $data = $request->safe();
    
        $task = Task::create($data->all());

        return response()->success([
            'message' => 'Resource created',
            'task' => $task->format(),
        ]);
    }

    /**
     * Show an specific task.
     */
    public function show(Task $task): JsonResponse
    {
        return response()->success([
            'task' => $task->format(),
        ]);
    }

    /**
     * Update the task.
     */
    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $data = $request->safe();
        
        $task->update($data->all());

        return response()->success([
            'message' => 'Resource updated',
            'task' => $task->format(),
        ]);
    }

    /**
     * Assign the task to an user or revoke the assignment.
     */
    public function assign(AssignTaskRequest $request, Task $task): JsonResponse
    {
        $data = $request->safe();

        if ($data->has('user_id') && ! is_null($data->user_id)) {
            $user = User::find($data->user_id);
            $task->assign($user);
        } else {
            $task->unassign();
        }

        return response()->success([
            'message' => 'Task assignation updated',
            'task' => $task->format(),
        ]);
    }

    /**
     * Move a task to a new status.
     */
    public function move(MoveTasksRequest $request, Task $task): JsonResponse
    {
        $data = $request->safe();

        $task->move(TaskStatus::tryFrom($data->status));

        return response()->success([
            'message' => 'Task status updated',
            'task' => $task->format(),
        ]);
    }

    /**
     * Delete an specific task.
     */
    public function delete(Task $task): JsonResponse
    {
        $task->delete();

        return response()->success([
            'message' => 'Resource deleted',
        ]);
    }
}

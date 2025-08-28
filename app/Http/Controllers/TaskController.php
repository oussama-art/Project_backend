<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    /**
     * Liste les tâches d’un projet.
     */
    public function index(Project $project)
    {
        $tasks = $project->tasks()
            ->with(['assignedUser', 'project'])
            ->get();

        return TaskResource::collection($tasks);
}


    /**
     * Crée une nouvelle tâche dans un projet.
     */
    public function store(StoreTaskRequest $request, Project $project)
    {
        $task = $project->tasks()->create($request->validated());
        $task->load(['assignedUser', 'project']);

        return (new TaskResource($task))
            ->additional(['message' => 'Task created successfully'])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Affiche une tâche.
     */
    public function show(Task $task)
    {
        $task->load(['assignedUser', 'project']);

        return new TaskResource($task);
    }

    /**
     * Met à jour une tâche.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());
        $task->load(['assignedUser', 'project']);

        return response()->json([
            ... (new TaskResource($task))->toArray(request()),
            'message' => 'Task updated successfully',
        ]);
    }


    /**
     * Supprime une tâche.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully',
        ], 200);
    }
    public function updateStatus(UpdateTaskStatusRequest $request, Task $task)
    {
        $task->update([
            'status' => $request->validated()['status'],
        ]);

        $resource = (new TaskResource($task->fresh(['assignedUser', 'project'])))->toArray(request());

        return response()->json([
            ...$resource,
            'message' => 'Task status updated successfully'
        ], 200);
    }




}

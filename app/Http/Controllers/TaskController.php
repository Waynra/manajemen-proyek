<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskController extends Controller
{
    /**
     * Display a listing of tasks for a project.
     */
    public function index(Project $project)
    {
        $this->authorize('view', $project);
        return $project->tasks()->orderBy('created_at', 'desc')->get();
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(StoreTaskRequest $request, Project $project)
    {
        $this->authorize('update', $project);
        
        $task = $project->tasks()->create($request->validated());
        
        if ($request->has('assignees')) {
            $task->assignees()->sync($request->input('assignees'));
        }

        return $task->load('assignees');
    }

    /**
     * Display the specified task.
     */
    public function show(Project $project, Task $task)
    {
        $this->authorize('view', $project);
        
        if ($task->project_id !== $project->id) {
            abort(404);
        }

        return $task->load('assignees');
    }

    /**
     * Update the specified task in storage.
     */
    public function update(UpdateTaskRequest $request, Project $project, Task $task)
    {
        $this->authorize('update', $project);
        
        if ($task->project_id !== $project->id) {
            abort(404);
        }

        $task->update($request->validated());

        if ($request->has('assignees')) {
            $task->assignees()->sync($request->input('assignees'));
        }

        return $task->load('assignees');
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Project $project, Task $task)
    {
        $this->authorize('delete', $project);
        
        if ($task->project_id !== $project->id) {
            abort(404);
        }

        $task->delete();

        return response()->noContent();
    }
}

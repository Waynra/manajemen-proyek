<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return inertia('Project/Index', [
            'projects' => Project::where('user_id', auth()->id())->latest()->get()
        ]);
    }

    public function create()
    {
        return inertia('Project/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $project = Project::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->route('projects.show', $project);
    }

    public function show(Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }

        return inertia('Project/Show', [
            'project' => $project,
            'tasks' => $project->tasks()->orderBy('created_at', 'desc')->with('assignees')->get(),
            'users' => User::all(['id', 'name'])
        ]);
    }

    public function edit(Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }

        return inertia('Project/Edit', [
            'project' => $project
        ]);
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }

        $project->update($request->validated());

        return redirect()->route('projects.show', $project)->with('success', 'Project updated successfully');
    }

    public function destroy(Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }

        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully');
    }
}

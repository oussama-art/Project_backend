<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Liste des projets de l’utilisateur connecté.
     */
    public function index(Request $request)
    {
        $projects = $request->user()
            ->projects()
            ->with(['tasks', 'user'])
            ->get();

        return ProjectResource::collection($projects);
    }

    /**
     * Créer un nouveau projet.
     */
    public function store(StoreProjectRequest $request)
    {
        $project = $request->user()->projects()->create($request->validated());
        $project->load(['user', 'tasks']); // éviter le N+1

        return (new ProjectResource($project))
            ->additional(['message' => 'Project created successfully'])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Afficher un projet.
     */
    public function show(Project $project)
    {
        $project->load(['tasks', 'user']);

        return new ProjectResource($project);
    }

    /**
     * Mettre à jour un projet.
     */
    public function update(StoreProjectRequest $request, Project $project)
    {
        $project->update($request->validated());
        $project->load(['tasks', 'user']);

        return (new ProjectResource($project))
            ->additional(['message' => 'Project updated successfully']);
    }

    /**
     * Supprimer un projet.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return response()->json(['message' => 'Project deleted successfully'], 200);
    }
}

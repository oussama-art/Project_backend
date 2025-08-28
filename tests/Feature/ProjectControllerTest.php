<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function actingAsNewUser(): User
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        return $user;
    }

    /** @test */
    public function a_user_can_list_only_his_projects_with_pagination_and_relations()
    {
        $user = $this->actingAsNewUser();

        $myProjects = Project::factory()->count(6)->for($user, 'user')->create();

        Project::factory()->count(3)->create(); // autres projets

        $response = $this->getJson('/api/projects');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id','title','description','owner','tasks','created_at'],
                ],
                'links',
                'meta'
            ]);
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $user = $this->actingAsNewUser();

        $payload = ['title' => 'My Project', 'description' => 'Test'];

        $response = $this->postJson('/api/projects', $payload);

        $response->assertCreated()
                 ->assertJsonPath('data.title', 'My Project');
    }

    /** @test */
    public function show_returns_a_project_with_relations()
    {
        $user = $this->actingAsNewUser();
        $project = Project::factory()->for($user, 'user')->create();

        $response = $this->getJson("/api/projects/{$project->id}");

        $response->assertOk()
                ->assertJsonPath('id', $project->id);
        
    }

    /** @test */
    public function a_user_can_update_a_project()
    {
        $user = $this->actingAsNewUser();
        $project = Project::factory()->for($user, 'user')->create();

        $response = $this->putJson("/api/projects/{$project->id}", [
            'title' => 'Updated title',
            'description' => 'Updated desc'
        ]);

        $response->assertOk()
                 ->assertJsonPath('data.title', 'Updated title');
    }

    /** @test */
    public function a_user_can_delete_a_project()
    {
        $user = $this->actingAsNewUser();
        $project = Project::factory()->for($user, 'user')->create();

        $response = $this->deleteJson("/api/projects/{$project->id}");

        $response->assertOk()
                 ->assertJson(['message' => 'Project deleted successfully']);
    }
}

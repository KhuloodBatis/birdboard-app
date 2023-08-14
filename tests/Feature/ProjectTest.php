<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public  function test_guests_cannot_create_project()
    {
        $attriutes = Project::factory()->raw();
        $this->postJson('/projects', $attriutes)
            ->assertUnauthorized()
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);
    }

    public function test_guests_cant_view_a_projects()
    {
        $this->get('/projects')->assertRedirect('login');
    }

    public function test_guests_cant_view_a_single_project()
    {
        $project = Project::factory()->create();
        $this->get($project->path())->assertRedirect('login');
    }


    /**@test  */
    public function test_a_user_can_create_project_successfully()
    {
        $this->withoutExceptionHandling();
        $attriutes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];

        $this->actingAs(User::factory()->create())
        ->get('/projects/create')->assertStatus(200);

        $this->actingAs(User::factory()->create())
            ->post('/projects', $attriutes)->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', $attriutes);
    }

    public function test_a_users_can_view_their_a_project()
    {    $this->be(User::factory()->create());
        $this->withoutExceptionHandling();
        $project = Project::factory()->create(['owner_id'=>auth()->id()]);
        $this->get($project->path())
            ->assertsee($project->title)
            ->assertsee($project->description);
    }

    public function test_n_auth_user_cannot_view_the_projects_of_others(){
        $this->be(User::factory()->create());

        $project = Project::factory()->create();
        $this->get($project->path())
        ->assertStatus(403);
    }
    public function test_a_project_requires_a_title()
    {
        $attriutes = Project::factory()->raw(['title' => []]);
        $this->actingAs(User::factory()->create())
            ->post('/projects', $attriutes)->assertSessionHasErrors('title');
    }

    public function test_a_project_requires_a_description()
    {
        $attriutes = Project::factory()->raw(['description' => []]);
        $this->actingAs(User::factory()->create())
            ->post('/projects', $attriutes)->assertSessionHasErrors('description');
    }

    public function test_only_authenticated_users_can_create_projects()
    {

        $attriutes = Project::factory()->raw();
        $this->post('/projects', $attriutes)->assertRedirect('login');
    }

    public function test_it_belongs_to_an_owner(){
        $project = Project::factory()->create();
        $this->assertInstanceOf('App\Models\User',$project->owner);
    }
}

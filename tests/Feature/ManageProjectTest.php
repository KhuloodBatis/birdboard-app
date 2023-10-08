<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Attribute;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ManageProjectTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**@test  */
    public  function test_guests_cannot_create_project()
    {
        $attriutes = Project::factory()->raw();
        $this->postJson('/projects', $attriutes)
            ->assertUnauthorized()
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);
    }

    /**@test  */
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
        $this->signIn();
        $attriutes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => 'General notes'
        ];

        $this->actingAs(User::factory()->create())
            ->get('/projects/create')->assertStatus(200);

        $response =  $this->post('/projects', $attriutes);

        $project = Project::where($attriutes)->first();

        $this->assertDatabaseHas('projects', $attriutes);
        $this->get($project->path())
            ->assertSee($attriutes['title'])
            ->assertSee($attriutes['description'])
            ->assertSee($attriutes['notes']);
    }

    /**@test  */
    public function test_user_can_update_project_successfully()
    {
        $this->signIn();

        $this->withoutExceptionHandling();

        $project = Project::factory()->create(['owner_id' => auth()->id()]);

        $this->patch($project->path(), $attriutes= [
            'title' => 'changed',
            'description' => 'changed',
            'notes' => 'changed'
        ]);

        $this->get($project->path().'/edit')->assertOk();
        $this->assertDatabaseHas('projects', $attriutes);
    }

       /**@test  */
       public function test_user_can_update_project_general_notes_successfully()
       {
           $this->signIn();

           $this->withoutExceptionHandling();

           $project = Project::factory()->create(['owner_id' => auth()->id()]);

           $this->patch($project->path(), $attriutes =[
               'notes' => 'changed'
           ]);

           $this->get($project->path().'/edit')->assertOk();
           $this->assertDatabaseHas('projects', $attriutes);
       }

    /**@test  */
    public function test_users_can_view_their_a_project()
    {
        $this->signIn();
        // $this->withoutExceptionHandling();
        $project = Project::factory()->create(['owner_id' => auth()->id()]);
        $this->get($project->path())
            ->assertsee($project->title)
            ->assertsee($project->description);
    }

    /**@test  */
    public function test_un_auth_user_cannot_view_the_projects_of_others()
    {
        $this->signIn();

        $project = Project::factory()->create();
        $this->get($project->path())
            ->assertStatus(403);
    }


    /**@test  */
    public function test_un_auth_user_cannot_update_the_projects_of_others()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->patch($project->path(), [])
            ->assertStatus(403);
    }

    /**@test  */
    public function test_a_project_requires_a_title()
    {
        $attriutes = Project::factory()->raw(['title' => []]);
        $this->actingAs(User::factory()->create())
            ->post('/projects', $attriutes)->assertSessionHasErrors('title');
    }

    /**@test  */
    public function test_a_project_requires_a_description()
    {
        $attriutes = Project::factory()->raw(['description' => []]);
        $this->actingAs(User::factory()->create())
            ->post('/projects', $attriutes)->assertSessionHasErrors('description');
    }

    /**@test  */
    public function test_only_authenticated_users_can_create_projects()
    {

        $attriutes = Project::factory()->raw();
        $this->post('/projects', $attriutes)->assertRedirect('login');
    }

    /**@test  */
    public function test_it_belongs_to_an_owner()
    {
        $project = Project::factory()->create();
        $this->assertInstanceOf('App\Models\User', $project->owner);
    }
}

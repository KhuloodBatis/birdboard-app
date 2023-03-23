<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**@test  */
    public function test_a_user_can_a_project_successfully()
    {
        $this->withoutExceptionHandling();
        $attriutes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];

        $this->post('/projects', $attriutes)->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', $attriutes);
        $this->get('/projects')->assertSee($attriutes['title']);
    }

    public function test_a_user_can_view_a_project()
    {
        $this->withoutExceptionHandling();
        $project = Project::factory()->create();
        $this->get($project->path())
            ->assertsee($project->title)
            ->assertsee($project->description);
    }

    public function test_a_project_requires_a_title()
    {
        $attriutes = Project::factory()->raw(['title' => []]);
        $this->post('/projects', $attriutes)->assertSessionHasErrors('title');
    }

    public function test_a_project_requires_a_description()
    {
        $attriutes = Project::factory()->raw(['description' => []]);
        $this->post('/projects', $attriutes)->assertSessionHasErrors('description');
    }
}

<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_projects_can_have_tasks()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(
            Project::factory()->raw()
        );
        $this->post($project->path() . '/tasks', ['body' => 'Test task']);

        $this->get($project->path())
            ->assertSee('Test task');
    }

    public function test_a_task_can_be_updated()
    {
        $project =  ( new ProjectFactory())->ownedBy($this->signIn())->withTasks(1)->create();
        $this->patch($project->tasks[0]->path(),[
            'body' => 'changed',
        ]);
        $this->assertDatabaseHas('tasks',
        [
            'body' => $project->tasks[0]->body,
        ]);
    }

    public function test_a_task_can_be_completed()
    {
        $project =  ( new ProjectFactory())->ownedBy($this->signIn())->withTasks(1)->create();
        $this->actingAs($project->owner)
        ->patch($project->tasks[0]->path(),[
            'body' => 'changed',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks',
        [
            'body' => 'changed',
            'completed' =>true,
        ]);
    }
    public function test_a_task_can_be_incompleted()
    {

        $project =  ( new ProjectFactory())->ownedBy($this->signIn())->withTasks(1)->create();
        $this->actingAs($project->owner)
        ->patch($project->tasks[0]->path(),[
            'body' => 'changed',
            'completed' => true
        ]);

        $this->patch($project->tasks[0]->path(),[
            'body' => 'changed',
            'completed' => false
        ]);

        $this->assertDatabaseHas('tasks',
        [
            'body' => 'changed',
            'completed' => false
        ]);
    }

    public function test_only_the_owner_of_a_project_may_add_tasks()
    {

        $project = Project::factory()->create();

        $project =  ( new ProjectFactory())->ownedBy($this->signIn())->withTasks(1)->create();
        $this->post($project->tasks[0]->path())
            ->assertStatus(405);

        $this->assertDatabaseMissing('tasks', ['body' => 'change']);
    }

    public function test_only_the_owner_of_a_project_may_update_tasks()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->patch($project->path() . '/tasks', ['body' => 'Test task'])
            ->assertStatus(405);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
    }

    public function test_a_task_requires_a_body()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(
            Project::factory()->raw()
        );

        $attributes = Task::factory()->raw(['body' => '']);

        $this->post($project->path() . '/tasks', $attributes)
            ->assertSessionHasErrors('body');
    }
}

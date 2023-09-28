<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_projects_can_have_tasks()
    {
        $this->withoutExceptionHandling();
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
        $this->withExceptionHandling();
        $this->signIn();
        $project = auth()->user()->projects()->create(
            Project::factory()->raw()
        );

        $task = Task::factory()->create(['project_id'=> $project->id]);

        $this->patch($project->path() . '/tasks/'. $task->id,
        [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks',
        [
            'body' => 'changed',
            'completed' => true
        ]);
    }

    public function test_only_the_owner_of_a_project_may_add_tasks()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $task = Task::factory()->create(['project_id'=> $project->id]);
        $this->patch($task->path(), ['body' => 'change'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'change']);
    }

    public function test_only_the_owner_of_a_project_may_update_tasks()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->post($project->path() . '/tasks', ['body' => 'Test task'])
            ->assertStatus(403);

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

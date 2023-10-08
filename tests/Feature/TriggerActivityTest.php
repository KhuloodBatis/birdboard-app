<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;


    public function test_creating_a_project_can_records_activity()
    {
        $project = (new ProjectFactory)->create();

        $this->assertCount(1, $project->activity);
        $this->assertEquals('created', $project->activity->last()->description);
    }


    public function test_updating_a_project_can_records_activity()
    {
        $project = (new ProjectFactory)->create();

        $project->update(['title' => 'Changed']);
        $this->assertCount(2, $project->activity);
        $this->assertEquals('updated', $project->activity->last()->description);
    }

    public function test_completing_a_new_task_records_activity()
    {
        $project = (new ProjectFactory)->create();
        $project->addTask('Some Task');
        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'foobar',
                'completed' => true,
            ]);
        $this->assertCount(3, $project->activity);
        $this->assertEquals('completed_task', $project->activity->last()->description);
    }

    public function test_completing_a_task_records_activity()
    {
        $project = (new ProjectFactory)->withTasks(1)->create();
        $this->actingAs($project->owner)
        ->patch($project->tasks[0]->path(),[
        'body' =>'foobar',
        'completed' => true,
    ]);

        $this->assertCount(3,$project->activity);
    }

    public function test_incompleting_a_task_records_activity_()
    {
        $project = (new ProjectFactory)->withTasks(1)->create();
        $this->actingAs($project->owner)
        ->patch($project->tasks[0]->path(),[
        'body' =>'foobar',
        'completed' => true,
    ]);

        $this->assertCount(3,$project->activity);

        $this->patch($project->tasks[0]->path(),[
            'body' =>'foobar',
            'completed' => false,
        ]);

        $this->assertCount(4,$project->fresh()->activity);
        $this->assertEquals('incompleted_task', $project->fresh()->activity->last()->description);

    }

    public function test_deleting_a_task_records_activity()
    {
        $project = (new ProjectFactory)->withTasks(1)->create();
        $project->tasks[0]->delete();
        $this->assertCount(3,$project->fresh()->activity);
    }
}

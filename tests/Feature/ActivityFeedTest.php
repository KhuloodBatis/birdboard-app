<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ActivityFeedTest extends TestCase
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

    public function test_completing_a_new_task_records_project_activity()
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

    // public function test_updating_a_task_records_project_activity()
    // {
    //     $project = (new ProjectFactory)->ownedBy($this->signIn())->withTasks(1)->create();
    //     $this->patch($project->tasks[0]->path(),[
    //     'body' =>'foobar',
    //     'completed' => true,
    // ]);

    //     $this->assertCount(2,$project->activity);
    // }
}

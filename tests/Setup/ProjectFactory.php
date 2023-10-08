<?php

namespace Tests\Setup;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Tests\TestCase;

class ProjectFactory extends TestCase
{
    protected $tasksCount = 0;

    protected $user;

    public function __construct( ) {

    }

    public function withtasks($count)
    {
        $this->tasksCount = $count;
        return $this;
    }

    public function ownedBy($user)
    {
       $this->user = $user;
       return $this;
    }


    public function create()
    {

       $project = Project::factory()->create([
            'owner_id' => User::factory()->create(),
        ]);
        Task::factory($this->tasksCount)->create(
            [
                'project_id' => $project->id,
            ]
        );
        return $project;
    }
}

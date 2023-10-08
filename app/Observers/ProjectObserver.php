<?php

namespace App\Observers;

use App\Models\Activity;
use App\Models\Project;

class ProjectObserver
{
    /**
     * Handle the Project "created" event.
     */
    public function created(Project $project): void
    {
        $this->recordActivity($project,'created');
    }

    /**
     * Handle the Project "updated" event.
     */
    public function updated(Project $project): void
    {
           $this->recordActivity($project,'updated');
    }

    public function recordActivity($project,$type)
    {
        Activity::create([
            'project_id' => $project->id,
            'description' => $type
           ]);
    }

    /**
     * Handle the Project "deleted" event.
     */
    public function deleted(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "restored" event.
     */
    public function restored(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "force deleted" event.
     */
    public function forceDeleted(Project $project): void
    {
        //
    }
}

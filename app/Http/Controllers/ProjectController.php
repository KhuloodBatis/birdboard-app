<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->projects;

        return view('projects.index', compact('projects'));
    }

    public function create()
    {

      return view('projects.create');
    }
    public function show(Project $project)
    {
        if(auth()->user()->isNot($project->owner)){
            abort(403);
        }
        return view('projects.show', compact('project'));
    }


    public function store()
    {
        //validate

        $attributes = request()->validate([
            'title' => ['required','string'],
            'description' => ['required','string'],
        ]);

      $project = auth()->user()->projects()->create( $attributes);


        return redirect( $project->path());
    }
}

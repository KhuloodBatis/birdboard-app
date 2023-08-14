<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();

        return view('projects.index', compact('projects'));
    }


    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }


    public function store()
    {
        //validate

        $attributes = request()->validate([
            'title' => ['required','string'],
            'description' => ['required','string'],
        ]);

       auth()->user()->projects()->create( $attributes);


        return redirect('/projects');
    }
}

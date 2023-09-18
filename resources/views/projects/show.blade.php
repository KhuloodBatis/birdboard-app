@extends ('layouts.app')
@section('content')



<header class="flex items-center mb-3">
    <div class="flex justify-between items-end w-full ">
        <p class="text-grey text-sm font-normal">
           <a href="/projects" >My Projects</a> / {{$project->title}}
        </p>
        <a href="/projects/create" class="button">New Project</a>
    </div>

   </header>

   <main>

    <div class="lg:flex -mx-3">
        <div class="lg:w-3/4 px-6 mb-6">
            <div class="mb-8">
                    <h2 class="text-grey text-lg font-normal mb-3">Tasks</h2>
                        {{--tasks--}}
                    <div class="card mb-3"> LOREM IPSUM.</div>
                    <div class="card mb-3"> LOREM IPSUM.</div>
                    <div class="card mb-3"> LOREM IPSUM.</div>
                    <div class="card "> LOREM IPSUM.</div>

            </div>
            <div>
                <h2 class="text-grey text-lg font-normal mb-3">Genral Notes</h2>
                    {{-- general notes--}}
                <textarea class="card w-full" style="min-height: 200px"> LOREM IPSUM.</textarea>

            </div>

        </div>
        <div class="lg:w-1/4">

          @include ("projects.card")

    </div>
   </main>


@endsection

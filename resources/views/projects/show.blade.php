@extends ('layouts.app')
@section('content')



<header class="flex items-center mb-3">
    <div class="flex justify-between items-end w-full ">
        <p class="text-grey text-sm font-normal">
           <a href="/projects" >My Projects</a> / {{$project->title}}
        </p>
        <a href="{{$project->path()}}/edit" class="button">Edit Project</a>
    </div>

   </header>

   <main>

    <div class="lg:flex -mx-3">
        <div class="lg:w-3/4 px-6 mb-6">
            <div class="mb-8">
                    <h2 class="text-grey text-lg font-normal mb-3">Tasks</h2>
                        {{--tasks--}}
                        @foreach($project->tasks as $task)

                    <div class="card mb-3">
                        <form method="POST" action="{{$task->path()}}" >
                           @method('PATCH')
                           @csrf

                         <div class="flex">
                            <input name="body" value="{{$task->body}}" class='w-full {{$task->completed ? 'text-grey' : ''}}'>
                            <input name="completed" type="checkbox" onchange="this.form.submit()" {{$task->completed ? 'checked': ''}}>
                        </div>

                        </form>

                    </div>

                        @endforeach

                        <div class="card mb-3">
                           <form action="{{$project->path() .'/tasks'}}" method="POST">
                             @csrf

                             <input placeholder="Add a new task" class="w-full" name="body" >
                        </form>
                        </div>
            </div>
            <div>
                <h2 class="text-grey text-lg font-normal mb-3">Genral Notes</h2>
                    {{-- general notes--}}
                    <form action="{{$project->path()}}" method="POST">
                      @csrf
                      @method('PATCH')
                        <textarea
                        name="notes"
                        class="card w-full mb-3 min-h-[200px]"
                        placeholder="Anything special that you want to make a note of?"
                        >{{$project->notes}}</textarea>
                    <button
                    type="submit"
                    class="button"
                    >
                    Save
                    </button>
                    </form>
                        @if ($errors->any())
                            <div class="field mt-6">
                                @foreach ($errors->all() as $error)
                                    <li class="text-sm text-red-700 ">{{ $error }}</li>
                                @endforeach
                            </div>
                        @endif
                    </div>

        </div>
        <div class="lg:w-1/4">

          @include ("projects.card")

    </div>
   </main>


@endsection

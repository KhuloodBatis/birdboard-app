
    <div class="card " style="height: 200px ">

         <h1 class="font-normal text-xl py-4 -ml-5 border-l-4 border-cyan-400 pl-4 mb-3 ">
          <a href="{{$project->path()}}">  {{$project->title}}</a>

        </h1>

         <div class='text-grey'>{{str_limit($project->description,80)}}</div>

    </div>



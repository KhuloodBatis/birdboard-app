<!DOCTYPE html>
<html lang="en">
<head>

    <title></title>
</head>
<body>
   <h1>Birdboard </h1>
   <ul>


    @forelse($projects as $project )

   <li>
    <a href="{{$project->path()}}">{{ $project->title }}</a>
</li>
@empty
 <li>
    No Projects
 </li>
 @endforelse

</ul>
</body>
</html>

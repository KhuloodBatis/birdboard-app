<!DOCTYPE html>
<html lang="en">
<head>

    <title></title>
</head>
<body>
   <h1>Birdboard </h1>
   <ul>


    @foreach ($projects as $project )

   <ul>{{$project->title}}</ul>

    @endforeach

</ul>
</body>
</html>

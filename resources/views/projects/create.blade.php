@extends ('layouts.app')
@section('content')


    <form class="container" action="/projects" method="POST">
       @csrf
       <h1 class="heading is-1">Create a Projects</h1>

    <div class="field">
            <label class="lable" for="title">Title</label>
        <div class="control">
             <input type="text" class="input" name="title" placeholder="Title">
        </div>
    </div>

    <div class="field">
        <label class="lable" for="description">Description</label>
    <div class="control">
         <input type="textarea" class="input" name="description" placeholder="description">
    </div>
</div>

<div class="field">

    <div class="control">
         <button type="submit" class="button is-link">Create Project</button>
    </div>
</div>

</form>

@endsection

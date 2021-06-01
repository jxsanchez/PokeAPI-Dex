@extends("master")

<!-- Set title of page -->
@section("title", "User Teams | PokéAPI Team Builder")

@section("nav")
    @include("nav")
@stop

@section("content")
    @foreach($allTeams as $team)
        <div class="container">
            <p>{{$team->team}}</p>

            <p>Created by: {{$team->userId}}</p>
            <p>{{$team->updated_at->diffForHumans()}}</p>
        </div>
    @endforeach
@endsection


@section("footer")
    @include("footer")
@stop
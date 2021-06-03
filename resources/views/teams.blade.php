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

            <p>{{$team->likeCount}} Likes</p>
            <p>{{$team->updated_at->diffForHumans()}}</p>
            
            @if(Auth::check() && $team->userId != Auth::id())
                <p>Created by: {{$team->userId}}</p>
                <i class="fa fa-thumbs-up"></i>
            @endif
        </div>
    @endforeach
@endsection


@section("footer")
    @include("footer")
@stop
@extends("master")

<!-- Set title of page -->
@section("title", "User Teams | PokéAPI Team Builder")

@section("nav")
    @include("nav")
@stop

@section("content")
    @foreach($allTeams as $team)
        <div class="container team-info">
            <div class="row team-container d-flex justify-content-start">
                @foreach($team->team as $pokemon)
                    <div class="col-sm-2 pokemon-icon-container d-flex flex-column justify-content-center align-items-start">
                        <a href="/pokemon/{{$pokemon->name}}" class="d-flex flex-column justify-content-start">
                            <img class="pokemon-icon" src="{{$pokemon->sprite_url}}" alt="">
                            <p class="pokemon-name">{{$pokemon->name}}</p>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-start">
                <p>{{$team->likeCount}} Likes</p>
                <p>{{$team->updated_at}}</p>
            </div>
            
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
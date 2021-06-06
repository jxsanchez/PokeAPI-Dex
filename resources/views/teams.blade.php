@extends("master")

<!-- Set title of page -->
@section("title", "User Teams | PokéAPI Team Builder")

@section("nav")
    @include("nav")
@stop

@section("content")
    <div class="container teams-container d-flex flex-column">
        <h6>Check out other trainers' teams!</h6>
        @foreach($allTeams as $key => $team)
            <div class="container team-info" style="padding: 10px 0;">
                <p class="trainer-name">TRAINER NAME: {{$team->userName}}</p>
                <div class="row team-container d-flex justify-content-start">
                    @foreach($team->team as $pokemon)
                        <div class="col-sm-2 pokemon-icon-container d-flex flex-column justify-content-center align-items-start">
                            <a href="/pokemon/{{$pokemon->name}}" class="d-flex flex-column team-pokemon-link">
                                <img class="pokemon-icon" src="{{$pokemon->sprite_url}}" alt="">
                                <p class="pokemon-name">{{$pokemon->name}}</p>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="teams-stats-container d-flex justify-content-start">
                    <p>
                        {{$team->likeCount}} Likes
                        
                        @if(Auth::check() && $team->userId != Auth::id())
                            <i class="fa fa-thumbs-up"></i>
                        @endif
                    </p>
                    <p class="dot-divider"> • </p>
                    <p>{{$team->updated_at}}</p>
                </div>
            </div>

            @if($key != count($allTeams) - 1)
                <hr style="border: 1px solid #ebedfa; width: 100%">
            @endif
        @endforeach
    </div>
@endsection


@section("footer")
    @include("footer")
@stop
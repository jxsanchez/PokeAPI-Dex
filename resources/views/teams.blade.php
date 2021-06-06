@extends("master")

<!-- Set title of page -->
@section("title", "User Teams | PokéAPI Team Builder")

@section("nav")
    @include("nav")
@stop

@section("content")
    <div class="container teams-container d-flex flex-column">
        <h5 style="text-align: center;">Check out other trainers' teams!</h5>

        @if(!Auth::check())
            <p class="home-msg" style="margin: 15px 0 15px">
                <a href="/login" class="body-link">LOGIN</a> or 
                <a href="/register" class="body-link">REGISTER</a> 
                to create a team and like other teams.
            </p>
        @endif

        <hr style="border: 1px solid #ebedfa; width: 100%">

        @foreach($allTeams as $key => $team)
        <!-- 0 padding on left/right to line up pokemon names on left -->
            <div class="container team-info" style="padding: 10px 0; width: 100%;">
                @if(Auth::check() && $team->userId != Auth::id())
                    @if($team->userId != Auth::id())
                        <p class="trainer-name">TRAINER: {{$team->userName}}</p>
                    @else
                        <p class="trainer-name">YOUR TEAM</p>
                    @endif
                @else
                    <p class="trainer-name">TRAINER: {{$team->userName}}</p>
                @endif

                <div class="row team-container d-flex justify-content-start" style="width: fit-content">
                    @foreach($team->team as $pokemon)
                        <div class="pokemon-icon-container team-pokemon-container col-sm-2 d-flex flex-column justify-content-center align-items-start">
                            <a href="/pokemon/{{$pokemon->name}}" class="d-flex flex-column team-pokemon-link">
                                <img class="pokemon-icon" src="{{$pokemon->sprite_url}}" alt="">
                                <p class="pokemon-name">{{$pokemon->name}}</p>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="team-stats-container d-flex justify-content-start align-items-center">
                    <form id="likes-container-{{$team->id}}" 
                          onsubmit="return likeTeam({{$team->id}}, {{$team->userId}}, {{$team->likeCount}})">
                        {{$team->likeCount}}

                        <!-- Print "s" on likes if not 1 -->
                        @if($team->likeCount != 1)
                            Likes
                        @else
                            Like
                        @endif
                        
                        @if(Auth::check() && $team->userId != Auth::id() && !(in_array(Auth::id(), explode("|", $team->likedBy))))
                            <button class="submit-like-btn" type="submit">
                                <i class="fa fa-thumbs-up"></i>
                            </button>
                        @endif
                    </form>
                    <div class="dot-divider"> • </div>
                    <div class="d-flex align-items-center">{{$team->updated_at}}</div>
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
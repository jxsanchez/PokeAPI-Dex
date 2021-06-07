@extends("master")

<!-- Set title of page -->
@section("title", "User Teams | PokéAPI Team Builder")

@section("nav")
    @include("nav")
@stop

@section("content")
    <div class="container teams-container d-flex flex-column">
        <h5 style="text-align: center;">Check out other trainers' teams!</h5>

        <!-- Print login or register message if not logged in -->
        @if(!Auth::check())
            <p class="home-msg" style="margin: 15px 0 15px">
                <a href="/login" class="body-link">LOGIN</a> or 
                <a href="/register" class="body-link">REGISTER</a> 
                to create a team and like other teams.
            </p>
        @endif

        <hr class="section-divider">

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

                <div class="team-container row d-flex justify-content-start" >
                    @foreach($team->team as $pokemon)
                        <div class="pokemon-icon-container team-pokemon-container col-sm-2 d-flex flex-column justify-content-center align-items-start">
                            <a class="team-pokemon-link d-flex flex-column" href="/pokemon/{{$pokemon->name}}">
                                <img class="pokemon-icon" src="{{$pokemon->sprite_url}}" alt="">
                                <p class="pokemon-name">{{$pokemon->name}}</p>
                            </a>
                        </div>
                    @endforeach
                </div> <!-- end of team-container -->

                <div class="team-stats-container d-flex justify-content-start align-items-center">
                    <!-- Like Team form, calls AJAX function to like team and update like count -->
                    <form id="likes-container-{{$team->id}}" 
                          onsubmit="return likeTeam({{$team->id}}, {{$team->userId}}, {{$team->likeCount}})">
                        {{$team->likeCount}}

                        <!-- Print "s" on likes if not 1 -->
                        @if($team->likeCount != 1)
                            Likes
                        @else
                            Like
                        @endif
                        
                        <!-- Show like button for user if they are logged in and have not liked the team already -->
                        @if(Auth::check() && $team->userId != Auth::id() && !(in_array(Auth::id(), explode("|", $team->likedBy))))
                            <button class="submit-like-btn" type="submit">
                                <i class="fa fa-thumbs-up"></i>
                            </button>
                        @endif
                    </form> <!-- end of likeTeam() form -->

                    <div class="dot-divider"> • </div>
                    <div class="d-flex align-items-center">{{$team->updated_at}}</div>
                </div> <!-- end of team-stats-container -->
            </div>

            <!-- Show section divider for all teams except last -->
            @if($key != count($allTeams) - 1)
                <hr class="section-divider">
            @endif
        @endforeach
    </div>
@endsection

@section("footer")
    @include("footer")
@stop
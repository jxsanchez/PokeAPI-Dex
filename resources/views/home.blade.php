@extends("master")

<!-- Set title of page -->
@section("title", "Home | PokéAPI Team Builder")

@section("nav")
    @include("nav")
@stop

<!-- Set page content -->
@section("content")
@php
    $currentNum = 1; // Use to display Pokémon number next to name in select

    // Create array of Pokémon in team if user is logged in
    if(Auth::check()) {
        if($team->pokemonCount > 1) {
            $teamArr = explode("|", $team->team);
        } else if($team->pokemonCount == 1) {
            $teamArr = [$team->team];
        }
    }
@endphp
<div class="container home-container d-flex flex-column align-items-center justify-content-center">
    <img class="main-logo" src="img/main-logo.png" alt="PokéAPI Team Builder Logo">

    @if(Auth::check())
        @if($team->pokemonCount > 0)
            <div class="row team-container d-flex justify-content-center">
                    @foreach($teamArr as $key=>$pokemon)
                    <div class="col-sm-2 pokemon-icon-container d-flex flex-column align-items-center">
                        <a href="/pokemon/{{$pokemon}}" class="d-flex flex-column align-items-center">
                            <img class="pokemon-icon" src="{{$teamIcons[$key]}}" alt="">
                            <p class="pokemon-name">{{ucfirst($pokemon)}}</p>
                        </a>

                        <form action="/team/remove" method="post">
                            <input name="pokemonName" type="text" value="{{$pokemon}}" hidden>

                            {{csrf_field() }}

                            <button class="remove-pokemon-btn btn btn-danger" type="submit">x</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <p class="home-msg">
                Select a Pokémon from any generation to start building your team.
            </p>
        @endif
    @else
        <p class="home-msg">
            <a href="/login" class="body-link">LOGIN</a> or 
            <a href="/register" class="body-link">REGISTER</a> 
            to create a  team or
            <a href="/teams" class="body-link">VIEW</a> existing teams.
        </p>
    @endif

    <div class="gen-list-container container">
        <div class="search-pokemon-input-container row d-flex justify-content-center">
            <form class="search-pokemon-form input-group mb-3" action="/pokemon" method="POST">
                <input class="form-control" type="text" name="pokemonName" placeholder="Search by Name">
                
                {{csrf_field() }}

                <div class="input-group-append">
                    <button class="search-pokemon-btn btn btn-outline-secondary" type="submit">Go!</button>
                </div>
            </form>
        </div>

        <div class="row">
            @for($i = 0; $i < 4; $i++)
                <div class="col-sm">
                    <div class="form-group">
                        <form action="/pokemon" method="POST">                
                            <!-- Create <select> options using list of Pokémon -->
                            <select name="pokemonName" class="pokemon-select form-control" onchange="this.form.submit()">
                                <option value="none" selected disabled hidden>Gen {{$i + 1}}</option>
                                @foreach($pokeLists[$i] as $pokemon)
                                    <option value="{{$pokemon["name"]}}">{{$currentNum++}} - {{ucfirst($pokemon["name"])}}</option>
                                @endforeach
                    
                                {{csrf_field() }}
                            </select>
                        </form>
                    </div>
                </div>
            @endfor
        </div> <!-- end row 1 -->

        <div class="row">
            @for($i = 4; $i < 8; $i++)
                <div class="col-sm">
                    <div class="form-group">
                        <form action="/pokemon" method="POST">                
                            <!-- Create <select> options using list of Pokémon -->
                            <select class="pokemon-select form-control" name="pokemonName" onchange="this.form.submit()">
                                <option value="none" selected disabled hidden>Gen {{$i + 1}}</option>
                                @foreach($pokeLists[$i] as $pokemon)
                                    <option value="{{$pokemon["name"]}}">{{$currentNum++}} - {{ucfirst($pokemon["name"])}}</option>
                                @endforeach
                    
                                {{csrf_field() }}
                            </select>
                        </form>
                    </div>
                </div>
            @endfor
        </div> <!-- end row 2 -->
    </div> <!-- end list-container -->
</div>
@endsection

@section("footer")
    @include("footer")
@stop
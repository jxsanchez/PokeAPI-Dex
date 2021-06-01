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
    <h1>PokéAPI Team Builder</h1>
    <h5>Build a team of your favorite Pokémon!</h5>

    @if(Auth::check())
        @if($team->pokemonCount > 0)
            <div class="team-container d-flex justify-content-center">
                    @foreach($teamArr as $key=>$pokemon)
                    <div class="pokemon-info-container d-flex flex-column align-items-center">
                        <a href="/pokemon/{{$pokemon}}" class="d-flex flex-column align-items-center">
                            <img class="pokemon-icon" src="{{$teamIcons[$key]}}" alt="">
                            {{ucfirst($pokemon)}}
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
            Select a Pokémon from any generation to start building your team.
        @endif
    @else
        Login or register to create a  team.
    @endif

    <div class="list-container container">
        <div class="row">
            @for($i = 0; $i < 4; $i++)
                <div class="col-sm">
                    <div class="form-group">
                        <form action="/pokemon" method="POST">                
                            <!-- Create <select> options using list of Pokémon -->
                            <select name="pokemonName" class="form-control" id="pokemon-select" onchange="this.form.submit()">
                                <option value="none" selected disabled hidden>Generation {{$i + 1}}</option>
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
                            <select class="form-control" name="pokemonName" id="pokemon-select" onchange="this.form.submit()">
                                <option value="none" selected disabled hidden>Generation {{$i + 1}}</option>
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
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

    if($team) {
        $teamArr = explode("|", $team->team);
    }
@endphp
<div class="container home-container d-flex flex-column align-items-center justify-content-center">
    <h1>PokéAPI Team Builder</h1>
    <h5>Build a team of your favorite Pokémon!</h5>

    @if($team)
        <div class="team-container d-flex justify-content-center">
            @foreach($teamArr as $pokemon)
                <a href="/pokemon/{{$pokemon}}">{{$pokemon}}</a>
            @endforeach
        </div>
    @else
        Login to create a  team!
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
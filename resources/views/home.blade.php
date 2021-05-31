@extends("master")

<!-- Set title of page -->
@section("title", "Home | PokéAPI Dex")

@section("nav")
    @include("nav")
@stop

<!-- Set page content -->
@section("content")
@php
    $currentNum = 1; // Use to display Pokémon number next to name in select
@endphp
<div class="container home-container d-flex flex-column align-items-center justify-content-center">
    <h1>PokéAPI Dex</h1>
    <h5>Learn more about your favorite Pokémon!</h5>

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
        </div> <!-- end row 1 -->
    </div> <!-- end list-container -->
</div>
@endsection

@section("footer")
    @include("footer")
@stop
@extends("master")

<!-- Set title of page (don't need double set of {} because this isn't an echo) -->
@section("title", "{$pokemon["name"]} | PokéAPI Dex ")

@section("nav")
    @include("nav")
@stop

<!-- Set page content -->
@section("content")
    @php
        $i = 0;

        // Iterate through flavor text until an english description is found
        while($pokemonSpecies["flavor_text_entries"][$i]["language"]["name"] != "en") {
            $i++;
        }

        // Get second to last character, the generation number, from the API endpoint
        $gen = substr($pokemonSpecies["generation"]["url"], -2, 1);
    @endphp

    <div class="container d-flex align-items-center">
        <div class="row">
            <div class="col-md-6">
                <img class="poke-img"
                src="{{$pokemon["sprites"]["other"]["official-artwork"]["front_default"]}}" 
                alt="{{$pokemon["name"]}}" />
            </div>

            <div class="col-md-6">
                <h1 class="poke-name">{{ucfirst($pokemon["name"])}} #{{$pokemonSpecies["pokedex_numbers"][0]["entry_number"]}}</h1>
    
                <div class="type-container">
                    <!-- Use Pokémon type to set class name -->
                    <div class="d-inline type-btn {{$pokemon["types"][0]["type"]["name"]}}">
                        {{$pokemon["types"][0]["type"]["name"]}}
                    </div>
                
                    <!-- Prints second type if second type exists -->
                    @if(count($pokemon["types"]) == 2)
                        <div class="d-inline type-btn {{$pokemon["types"][1]["type"]["name"]}}">
                            {{$pokemon["types"][1]["type"]["name"]}}
                        </div>
                    @endif
                </div>
        
                <p class="poke-desc">{{$pokemonSpecies["flavor_text_entries"][$i]["flavor_text"]}}</p>
        
                <a class="btn nav-btn" href="/generation/{{$gen}}"><i class="fa fa-angle-left"></i> back</a>
            </div>
        </div>
    </div>

@endsection

@section("footer")
    @include("footer")
@endsection
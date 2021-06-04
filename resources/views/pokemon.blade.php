@extends("master")

<!-- Set title of page (don't need double set of {} because this isn't an echo) -->
@section("title", "#".$pokemonSpecies["pokedex_numbers"][0]["entry_number"]." ".ucfirst($pokemon["name"])." | PokéAPI Team Builder ")

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
    @endphp

    <div class="pokemon-info-container container d-flex align-items-center">
        <div class="row">
            <!-- Pokémon Image -->
            <div class="col-md-6">
                <img class="poke-img"
                src="{{$pokemon["sprites"]["other"]["official-artwork"]["front_default"]}}" 
                alt="{{$pokemon["name"]}}" />
            </div>

            <div class="poke-info-col col-md-6">
                <!-- Pokémon Name and Add Button -->
                <div class="poke-name-container d-flex align-items-center">
                    <h1 class="poke-name">
                        #{{$pokemonSpecies["pokedex_numbers"][0]["entry_number"]}} {{ucfirst($pokemon["name"])}}
                    </h1>
                </div>
    
                <div class="type-container">
                    <!-- Use Pokémon type to set class name -->
                    <div class="d-inline text-center type-btn {{$pokemon["types"][0]["type"]["name"]}}">
                        {{$pokemon["types"][0]["type"]["name"]}}
                    </div>
                
                    <!-- Prints second type if second type exists -->
                    @if(count($pokemon["types"]) == 2)
                        <div class="d-inline text-center type-btn {{$pokemon["types"][1]["type"]["name"]}}">
                            {{$pokemon["types"][1]["type"]["name"]}}
                        </div>
                    @endif
                </div>
        
                <p class="poke-desc">
                    {{$pokemonSpecies["flavor_text_entries"][$i]["flavor_text"]}}
                </p>

                {{-- <div class="accordion" id="accordionExample">
                    <div class="card">
                      <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                          <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            Evolutionary Chain
                          </button>
                        </h2>
                      </div>
                  
                      <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">
                          <!-- Evolution Line -->
                <div class="evo-line-container">
                    <div class="evo-line-row row d-flex align-items-center">
                        <!-- Display evolution line with each stage in its own column -->
                        @foreach($evoChainArr as $key=>$stage)
                            <div class="evo-line-col col-md d-flex flex-column justify-content-center">
                                @foreach($stage as $currMon)
                                    <div class="stage-container d-flex align-items-center">
                                        <!-- Display arrow from previous evolution to current Pokémon-->
                                        @if($key != 0) 
                                            <i class="next-evo-arrow-right fa fa-arrow-right"></i>
                                        @endif
                                        <a  class="evo-line-stage d-flex flex-column align-items-center justify-content-center" 
                                            href="/pokemon/{{$currMon["species"]["name"]}}">
                                            <img class="evo-chain-icon" src="{{$currMon["sprites"]["versions"]["generation-viii"]["icons"]["front_default"]}}" alt="">
                                            {{ucfirst($currMon["species"]["name"])}}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div> <!-- end of evo-line-container -->
                        </div>
                      </div>
                    </div>
                    
                  </div> --}}

                <div class="row options-container">
                    <div class="option-col options-text-col col-md-6">
                        @if(Auth::check())
                            What will YOU do?
                        @else
                            LOGIN to catch this Pokémon.
                        @endif
                    </div>
        
                    <div class="option-col options-col col-md-6 d-flex flex-column justify-content-start">
                        <!-- Display add logged in users -->
                        @if(Auth::check())
                        <!-- Display add button if no Pokémon on team -->
                            @if($team->pokemonCount < 1)
                                <form class="add-poke-form" action="/team/add" method="POST">
                                    <input name="pokemonName" type="text" value="{{$pokemon["name"]}}" hidden>
                                    
                                    {{csrf_field() }}
                                    
                                    <button type="submit" class="option-btn">CATCH</button>
                                </form>
                            <!-- Display add button if team is not full and Pokémon is not on team already -->
                            @elseif($team->pokemonCount >=1 &&  $team->pokemonCount < 6)
                                @if(!str_contains($team->team, $pokemon["name"]))
                                    <form class="add-poke-form" action="/team/add" method="POST">
                                        <input name="pokemonName" type="text" value="{{$pokemon["name"]}}" hidden>
                                        
                                        {{csrf_field() }}
                                        
                                        <button type="submit" class="option-btn">CATCH</button>
                                    </form>
                                @endif <!-- end of if(!str_contains($team->team, $pokemon["name"])) -->
                            @endif <!-- end of elseif($team->pokemonCount >=1 &&  $team->pokemonCount < 6) -->
                        @else
                            <a class="option-btn" href="/login">LOGIN</a>
                        @endif <!-- end of if(Auth::check()) -->
        
                        <a class="option-btn" href="/">RUN</a>
                    </div> <!-- end of option col -->
                </div> <!-- end of options-container -->
            </div> <!-- end of poke-info-col -->
        </div>
    </div> <!-- end of pokemon-info-container -->
@endsection

@section("footer")
    @include("footer")
@endsection
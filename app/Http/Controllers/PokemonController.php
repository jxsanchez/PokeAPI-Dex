<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use PokePHP\PokeApi;
use App\Models\PokemonTeam;

class PokemonController extends Controller
{
    public function showPokemon(Request $req) {
        $api = new PokeApi;

        // Get Pokémon data
        $pokemon = json_decode($api->pokemon($req->pokemonName), true);
        $pokemonSpecies = json_decode($api->pokemonSpecies($req->pokemonName), true);

        // Explode evolution chain URL to get id used to call evolution chain route
        $evoChainId = explode("/", $pokemonSpecies["evolution_chain"]["url"])[6];
        $evoChain = json_decode($api->evolutionChain($evoChainId));

        // Get first stage
        if($evoChain->chain->species->name != null) {
            echo $evoChain->chain->species->name;
        }

        // Get second stage evolutions
        if(isset($evoChain->chain->evolves_to)) {
            $i = 0;

            while($i < count($evoChain->chain->evolves_to)) {
                echo $evoChain->chain->evolves_to[$i]->species->name;

                $i++;
            }
            
        }

        // Get third stage evolutions
        if(isset($evoChain->chain->evolves_to[0]->evolves_to)) {
            $i = 0;
            
            while($i < count($evoChain->chain->evolves_to)) {
                $j = 0;
                while($j < count($evoChain->chain->evolves_to[0]->evolves_to)) {
                    echo $evoChain->chain->evolves_to[$i]->evolves_to[$j]->species->name;

                    $j++;
                }

                $i++;
            }            
        }

        // If authenticated and has a team, use team from database
        if(Auth::check() && $team = PokemonTeam::where("userId", Auth::id())->first()) {
            return view("pokemon", [
                "pokemon" => $pokemon,
                "pokemonSpecies" => $pokemonSpecies,
                "team" => $team,
                "evoChain" => $evoChain
            ]);
        
        }
        
        // Display view with default object
        return view("pokemon", [
            "pokemon" => $pokemon,
            "pokemonSpecies" => $pokemonSpecies,
            "team" => (object)["pokemonCount" => "0"],
            "evoChain" => $evoChain
        ]);
    }
}

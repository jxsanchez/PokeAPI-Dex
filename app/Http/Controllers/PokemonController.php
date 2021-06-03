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
        $evoChain = json_decode($api->evolutionChain($evoChainId), true);
        $evoChainArr = array();

        // Get first stage
        if(isset($evoChain["chain"]["species"]["name"])) {
            $firstStageName = $evoChain["chain"]["species"]["name"];
            $currentPokeObj = json_decode($api->pokemon($firstStageName), true);
            
            array_push($evoChainArr, array($currentPokeObj));
        }

        // Get second stage evolutions if there are any
        if(isset($evoChain["chain"]["evolves_to"])) {
            $i = 0;

            // Array to hold second stage evolutions
            $secondStageArr = array();

            // Populate second stage array
            while($i < count($evoChain["chain"]["evolves_to"])) {
                $secondStageName = $evoChain["chain"]["evolves_to"][$i]["species"]["name"];
                $currentPokeObj = json_decode($api->pokemon($secondStageName), true);

                array_push($secondStageArr, $currentPokeObj);

                $i++;
            }
            
            // Add array of second stage evolutions to main evolutions array
            array_push($evoChainArr, $secondStageArr);
        }

        // Get third stage evolutions if there are any
        if(isset($evoChain["chain"]["evolves_to"][0]["evolves_to"])) {
            $i = 0;

            // Array to hold third stage evolutions
            $thirdStageArr = array();
            
            while($i < count($evoChain["chain"]["evolves_to"])) {
                $j = 0;

                while($j < count($evoChain["chain"]["evolves_to"][0]["evolves_to"])) {
                    $thirdStageName = $evoChain["chain"]["evolves_to"][$i]["evolves_to"][$j]["species"]["name"];
                    $currentPokeObj = json_decode($api->pokemon($thirdStageName), true);

                    array_push($thirdStageArr, $currentPokeObj);

                    $j++;
                }

                $i++;
            }   
            
            // Add array of third stage evolutions to main evolutions array
            array_push($evoChainArr, $thirdStageArr);
        }

        // If authenticated and has a team, use team from database
        if(Auth::check() && $team = PokemonTeam::where("userId", Auth::id())->first()) {
            return view("pokemon", [
                "pokemon" => $pokemon,
                "pokemonSpecies" => $pokemonSpecies,
                "team" => $team,
                "evoChainArr" => $evoChainArr
            ]);
        
        }
        
        // Display view with default object
        return view("pokemon", [
            "pokemon" => $pokemon,
            "pokemonSpecies" => $pokemonSpecies,
            "team" => (object)["pokemonCount" => "0"],
            "evoChainArr" => $evoChainArr
        ]);
    }
}

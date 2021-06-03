<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use PokePHP\PokeApi;
use App\Models\PokemonTeam;

class HomeController extends Controller
{
    // Return home view
    public function index() {
        // Enable calls to PokéAPI
        $api = new PokeApi;

        // Empty array that will hold arrays of Pokémon from each generation
        $pokeLists = array();

        // Get sorted list of Pokémon in each generation
        for($i = 1; $i <= 8; $i++) {
            // Get list of Pokémon from current generation.
            $data = json_decode($api->gameGeneration($i), true);

            // List to be sorted by Pokémon number
            $tempList = array();

            for($j = 0; $j < count($data["pokemon_species"]); $j++) {
                // Get url
                $pokemonUrl = $data["pokemon_species"][$j]["url"];

                // Explode url to separate Pokémon number
                $urlArr = explode("/", $pokemonUrl);

                // Store Pokémon species array with Pokémon number as key.
                $tempList[$urlArr[6]] = $data["pokemon_species"][$j];

                // Sort all Pokémon in generation
                ksort($tempList);
            }

            // Add sorted list of Pokémon to main array
            array_push($pokeLists, $tempList);
        }
        
        // Check if user logged in and if they have a team
        if(Auth::check() && $team = PokemonTeam::where("userId", Auth::id())->first()) {
            // Store icon urls
            $teamIcons = array();

            // Set icons for each Pokémon in team
            if($team->pokemonCount > 0) {
                $tempArr = explode("|", $team->team);

                foreach($tempArr as $pokemonName) {
                    $pokemon = json_decode($api->pokemon($pokemonName), true);

                    // Check if Pokémon has gen 8 icon, else add gen 7 icon
                    if($pokemon["sprites"]["versions"]["generation-viii"]["icons"]["front_default"] != null) {
                        array_push($teamIcons, $pokemon["sprites"]["versions"]["generation-viii"]["icons"]["front_default"]);
                    } else {
                        array_push($teamIcons, $pokemon["sprites"]["versions"]["generation-vii"]["icons"]["front_default"]);
                    }
                }
            }

            return view("home", [
                "pokeLists" => $pokeLists,
                "team" => $team,
                "teamIcons" => $teamIcons
            ]);
        } else {
            // If user is not logged in or does not have a team, return object with no team and empty teamIcons array
            return view("home", [
                "pokeLists" => $pokeLists,
                "team" => (object)["pokemonCount" => "0"],
                "teamIcons" => []
            ]);
        }
    }
}

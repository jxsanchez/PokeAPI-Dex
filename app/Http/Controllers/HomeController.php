<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PokePHP\PokeApi;

class HomeController extends Controller
{
    // Return home view
    public function index() {
        // Enable calls to PokéAPI
        $api = new PokeApi;

        // Empty array that will hold arrays of Pokémon from each generation
        $pokeLists = array();

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

        return view("home", [
            "pokeLists" => $pokeLists
        ]);
    }
}

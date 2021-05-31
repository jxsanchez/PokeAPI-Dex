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

            // Hold list of Poké
            $tempList = array();

            for($j = 0; $j < count($data["pokemon_species"]); $j++) {
                $pokemonUrl = $data["pokemon_species"][$j]["url"];

                $urlArr = explode("/", $pokemonUrl);

                $tempList[$urlArr[6]] = $data["pokemon_species"][$j];

                ksort($tempList);
            }

            array_push($pokeLists, $tempList);
        }

        return view("home", [
            "pokeLists" => $pokeLists
        ]);
    }

    function compareUrl($a, $b) {
        return strcmp($a["url"], $b["url"]);
    }
}

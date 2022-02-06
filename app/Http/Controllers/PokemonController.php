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

        if(is_string($pokemon)) {
            return redirect()->back()->withErrors(['error' => 'The Pokémon you are looking for cannot be found!']);
        }

        $pokemonSpecies = json_decode($api->pokemonSpecies($req->pokemonName), true);


        // If authenticated and has a team, use team from database
        if(Auth::check() && $team = PokemonTeam::where("userId", Auth::id())->first()) {
            return view("pokemon", [
                "pokemon" => $pokemon,
                "pokemonSpecies" => $pokemonSpecies,
                "team" => $team
            ]);
        
        }
        
        // Display view with default object
        return view("pokemon", [
            "pokemon" => $pokemon,
            "pokemonSpecies" => $pokemonSpecies,
            "team" => (object)["pokemonCount" => "0"]
        ]);
    }

    public function test() {
        $api = new PokeApi;

        $i = 1;

        $species = json_decode($api->pokemonSpecies($i), true);
        $pokemon = json_decode($api->pokemon($i), true);

        dd($species);

        // dd($response);

        while(!is_string($response)) {
            $i++;
        }

        echo $i;
    }
}

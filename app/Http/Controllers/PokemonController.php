<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PokePHP\PokeApi;

class PokemonController extends Controller
{
    public function showPokemon(Request $req) {
        $api = new PokeApi;

        // Get Pokémon data
        $pokemon = json_decode($api->pokemon($req->pokemonName), true);
        $pokemonSpecies = json_decode($api->pokemonSpecies($req->pokemonName), true);

        return view("pokemon", [
            "pokemon" => $pokemon,
            "pokemonSpecies" => $pokemonSpecies
        ]);
    }
}

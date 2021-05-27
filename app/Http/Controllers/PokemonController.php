<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PokePHP\PokeApi;

class PokemonController extends Controller
{
    public function showPokemon(Request $req) {
        $api = new PokeApi;

        // Get Pokémon data
        $pokemon = json_decode($api->pokemon($req->pokemon), true);
        $pokemonSpecies = json_decode($api->pokemonSpecies($req->pokemon), true);

        return view("pokemon", [
            "pokemon" => $pokemon,
            "pokemonSpecies" => $pokemonSpecies
        ]);
    }
}

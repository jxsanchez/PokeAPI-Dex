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

        $team = PokemonTeam::where("id", Auth::id())->first();

        return view("pokemon", [
            "pokemon" => $pokemon,
            "pokemonSpecies" => $pokemonSpecies,
            "team" => $team
        ]);
    }
}

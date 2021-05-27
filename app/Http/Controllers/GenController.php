<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PokePHP\PokeApi;

class GenController extends Controller
{
    public function getGenPokemon(Request $req) {
        // Enable calls to PokéAPI
        $api = new PokeApi;

       // Decode JSON object containing Pokémon from specified generation
        $data = json_decode($api->gameGeneration($req->gens), true);

        // Store array of Pokémon objects
        $pokeList = $data["pokemon_species"];

        // Render home view with list of Pokémon
        return view("home", [
            "pokeList" => $pokeList
        ]);
    }
}
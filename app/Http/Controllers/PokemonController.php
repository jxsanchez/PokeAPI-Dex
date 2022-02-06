<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use PokePHP\PokeApi;
use App\Models\Pokemon;
use App\Models\PokemonTeam;

class PokemonController extends Controller
{
    public function showPokemon(Request $req) {
        if($pokemon = Pokemon::where('name', '=', $req->pokemonName)->first()) {
            $viewData = [ 'pokemon' => $pokemon ];

            // If authenticated and has a team, use team from database
            if(Auth::check() && $team = PokemonTeam::where("userId", Auth::id())->first()) {
                $viewData['team'] = $team;
            }

            return view('pokemon', $viewData);
        } else {
            return redirect()->back()->withErrors(['error' => 'The Pokémon you are looking for cannot be found!']);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use PokePHP\PokeApi;
use App\Models\Pokemon;
use App\Models\PokemonTeam;

class HomeController extends Controller
{
    // Return home view
    public function index() {
        // Enable calls to PokéAPI
        $api = new PokeApi;

        $viewData = [];

        // Empty array that will hold arrays of Pokémon from each generation
        $pokeLists = [];

        // Store each generation of Pokémon in an index of $pokeLists
        for($i = 1; $i <= 8; $i++) {
            $pokeLists[] = Pokemon::select('pokedex_number', 'name')
                ->where('generation', '=', $i)
                ->orderBy('pokedex_number', 'asc')
                ->get();
        }
        
        // Check if user logged in and if they have a team
        if(Auth::check() && $teamRecord = PokemonTeam::where("userId", Auth::id())->first()) {
            // Explode team column to get Pokémon names
            $teamMembers = explode('|', $teamRecord->team);

            $team = [];

            // Store record for each Pokémon on team 
            foreach($teamMembers as $pokemonName) {
                $team[] = Pokemon::where('name', '=', $pokemonName)->first();
            }

            // Add team to view data
            $viewData['team'] = $team;
        }

        $viewData['pokeLists'] = $pokeLists;

        return view('home', $viewData);
    }
}

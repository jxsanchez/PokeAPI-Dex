<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\PokemonTeam;

class TeamController extends Controller
{
    public function add(Request $req) {
        // Current user's id
        $userId = Auth::id();

        // Get user's team
        $team = PokemonTeam::where("id",$userId)->first();

        // Explode team into array
        $teamArr = explode("|", $team->team);

        // Add new Pokémon to array
        array_push($teamArr, $req->pokemonName);

        // Update count and implode new array
        $updatedCount = count($teamArr);
        $updatedTeam = implode("|", $teamArr);

        PokemonTeam::where("id", $userId)->update(array(
            "pokemonCount" => $updatedCount,
            "team"=>$updatedTeam,
            "updated_at"=>Carbon::today()));

        return redirect("/");
    }

    public function remove(Request $req) {
       // Current user's id
       $userId = Auth::id();

       // Get user's team
       $team = PokemonTeam::where("id",$userId)->first();

       // Explode team into array
       $teamArr = explode("|", $team->team);

       // Remove Pokémon from array
        if(($key = array_search($req->pokemonName, $teamArr)) !== false) {
            unset($teamArr[$key]);
        }

       // Update count and implode new array
       $updatedCount = count($teamArr);
       $updatedTeam = implode("|", $teamArr);

       PokemonTeam::where("id", $userId)->update(array(
           "pokemonCount" => $updatedCount,
           "team"=>$updatedTeam,
           "updated_at"=>Carbon::today()));

       return redirect("/"); 
    }
}

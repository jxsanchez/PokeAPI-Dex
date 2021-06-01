<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\PokemonTeam;

class TeamController extends Controller
{
    public function create(Request $req) {
        // Create PokemonTeam object
        $team = new PokemonTeam();

        $team->userId = Auth::id();
        $team->team = $req->pokemonName;
        $team->pokemonCount = "1";
        
        $team->save();

        return redirect("/");
    }

    public function add(Request $req) {
        // Current user's id
        $userId = Auth::id();

        // Get user's team if they have a team, else add their team to the database
        if($team = PokemonTeam::where("userId",$userId)->first())
        {
            $updatedTeam = "";
            $updatedCount = 0;

            // If user's team is empty, set team string to Pokémon name and count to 1, else
            // perform explode, array_push, and implode to update string and count
            if($team->pokemonCount < 1) {
                $updatedTeam = $req->pokemonName;
                $updatedCount = 1;
            } else {
                // Explode team into array
                $teamArr = explode("|", $team->team);

                // Add new Pokémon to array
                array_push($teamArr, $req->pokemonName);

                // Update count and implode new array
                $updatedCount = count($teamArr);
                $updatedTeam = implode("|", $teamArr);
            }

            PokemonTeam::where("userId", $userId)->update(array(
                "pokemonCount" => $updatedCount,
                "team"=>$updatedTeam,
                "updated_at"=>Carbon::today()));

            return redirect("/");
        } else {
            $this->create($req);

            return redirect("/");
        }
    }

    public function remove(Request $req) {
       // Current user's id
       $userId = Auth::id();

       // Get user's team
       $team = PokemonTeam::where("userId",$userId)->first();

       // Explode team into array
       $teamArr = explode("|", $team->team);

       // Remove Pokémon from array
        if(($key = array_search($req->pokemonName, $teamArr)) !== false) {
            unset($teamArr[$key]);
        }

       // Update count and implode new array
       $updatedCount = count($teamArr);
       $updatedTeam = implode("|", $teamArr);

       PokemonTeam::where("userId", $userId)->update(array(
           "pokemonCount" => $updatedCount,
           "team"=>$updatedTeam,
           "updated_at"=>Carbon::today()));

       return redirect("/"); 
    }
}

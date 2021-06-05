<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\PokemonTeam;
use App\Models\User;

use PokePHP\PokeApi;
use Carbon\Carbon;

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

    public function getAllTeams() {
        $dbTeams = PokemonTeam::all()->sortByDesc("updated_at");

        // print_r($dbTeams);

        $allTeams = array();

        foreach($dbTeams as $team) {
            $api = new PokeApi;

            $teamArr = explode("|", $team["team"]);
            
            $teamObj = (object)[];
            $tempArr = array();

            $teamCreator = User::findOrFail($team->userId);

            // Set Creator ID, Creator name, like count, and date updated
            $teamObj->userId = $team->userId;
            $teamObj->userName = $teamCreator->name;
            $teamObj->likeCount = $team->likeCount;
            $teamObj->updated_at = $team->updated_at->diffForHumans();

            foreach($teamArr as $pokemon) {
                $tempPokeObj = (object)[];

                $pokemonData = json_decode($api->pokemon($pokemon), true);

                $tempPokeObj->name = $pokemon;
                $tempPokeObj->sprite_url = $pokemonData["sprites"]["versions"]["generation-viii"]["icons"]["front_default"];

                array_push($tempArr, $tempPokeObj);
            }
            
            // Set team array with name and url
            $teamObj->team = $tempArr;

            // Push current user's team with all info onto allTeams array
            array_push($allTeams, $teamObj);
        }

        return view("teams", [
            "allTeams" => $allTeams
        ]);
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
                "updated_at"=>Carbon::now()));

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
           "updated_at"=>Carbon::now()));

       return redirect("/"); 
    }
}

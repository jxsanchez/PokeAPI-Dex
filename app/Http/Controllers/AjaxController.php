<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\PokemonTeam;

class AjaxController extends Controller
{
    public function likeTeam(Request $req) {
        // Get team user clicked like button for
        if($team = PokemonTeam::where("id", $req->teamId)->first()) {
            // Increment likeCount by 1
            PokemonTeam::where("id", $req->teamId)->increment("likeCount", 1);

            $updatedLikedBy = "";

            if($team->likeCount < 1) {
                $updatedLikedBy = Auth::id();
            } else {
                // Get likedBy into array
                $likeArr = explode("|", $team->likedBy);

                // Add user's id to likedBy array
                array_push($likeArr, Auth::id());

                // Revert array to deliminated string
                $updatedLikedBy = implode("|", $likeArr);
            }

            // Update likedBy string
            PokemonTeam::where("id", $req->teamId)->update(array(
                "likedBy" => $updatedLikedBy
            ));
        }

        $msg = (intval($req->likeCount + 1))." Like";

        if($req->likeCount + 1 > 1) {
            $msg .= "s";
        }

        return response()->json(array("msg" => $msg));
    }
}

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

            // Updated string of users who have liked this team
            $updatedLikedBy = "";

            if($team->likeCount < 1) {
                // Set new likeBy string to logged-in user's ID if no likes yet
                $updatedLikedBy = Auth::id();
            } else {
                // Get likedBy into array
                $likeArr = explode("|", $team->likedBy);

                // Add logged-in user's id to likedBy array
                array_push($likeArr, Auth::id());

                // Revert array to deliminated string
                $updatedLikedBy = implode("|", $likeArr);
            }

            // Update likedBy string
            PokemonTeam::where("id", $req->teamId)->update(array(
                "likedBy" => $updatedLikedBy
            ));
        }

        // Updated like count message
        $msg = (intval($req->likeCount + 1))." Like";

        // Add "s" to "Like" if like count is greater than 1.
        $msg .= ($req->likeCount + 1 > 1) ? "s" : "";            

        return response()->json(array("msg" => $msg));
    }
}

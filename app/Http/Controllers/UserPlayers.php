<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\userPlayers as UserPlayersModel;

class UserPlayers extends Controller
{
    public function getUserPlayers (Request $req, $userId = null) {

        $userId = $userId ?? $req->user()->id;
        $players = UserPlayersModel::where('user_id', $userId)->select()->get();
        $res = [];

        foreach($players as $player) {
            array_push($res, $player->player_id);
        }

        return $res;
    }

    public function resetUserPlayers(Request $req, $userId = null) {
        $userId = $userId ?? $req->user()->id;
        $players = $req->validate(["players" => "required"])["players"];
        $data = [];

        foreach($players as $player) {
            array_push($data, ["player_id" => $player, "user_id"=> $userId]);
        }

        UserPlayersModel::where('user_id', $userId)->delete();
        UserPlayersModel::insert($data);
    }

}

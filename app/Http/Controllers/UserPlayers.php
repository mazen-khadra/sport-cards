<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\userPlayers as UserPlayersModel;
use App\Models\img as ImgModel;

class UserPlayers extends Controller
{
    public function getUserPlayers (Request $req, $userId = null) {

        $userId = $userId ?? $req->user()->id;
        return UserPlayersModel::where('user_id', $userId)->select()->get();
    }

    public function resetUserPlayers(Request $req, $userId = null) {
        $userId = $userId ?? $req->user()->id;
        $players = $req->validate(["players" => "required"])["players"];
        $data = [];

        foreach($players as $player) {
            array_push($data, [
                "player_id" => $player['id'],
                "name" => $player['name'],
                "position" => $player['position'],
                "market_value" => $player['market_value'],
                "img_id" => ImgModel::getImgIdByUrl($player['img_url']),
                "user_id"=> $userId
            ]);
        }

        UserPlayersModel::where('user_id', $userId)->delete();
        UserPlayersModel::insert($data);
    }

}

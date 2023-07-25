<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\userPlayers as UserPlayersModel;
use App\Models\img as ImgModel;

class UserPlayers extends Controller
{
    public function getUserPlayers (Request $req, $userId = null) {

        $userId = $userId ?? $req->user()->id;
        return UserPlayersModel::where('user_id', $userId)->select()->get();
    }

    public function resetUserPlayers(Request $req, $userId = null, $onlyAdd = null) {
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
                "user_id"=> $userId,
                "created_at" => Carbon::now()->toDateTimeString(),
                "updated_at" => Carbon::now()->toDateTimeString()
            ]);
        }

        if(empty($onlyAdd))
          UserPlayersModel::where('user_id', $userId)->delete();

        UserPlayersModel::insert($data);

        return ["message" => "success"];
    }

    public function deletePlayer(Request $req, $userId = null) {
        $userId = $userId ?? $req->user()->id;
        $playerId = $req->validate(["playerId" => "required"])["playerId"];

        UserPlayersModel::where('player_id', $playerId)
            ->where('user_id', $userId)->delete();

        return $this->getUserPlayers($req);
    }
}

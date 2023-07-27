<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matches as MatchModel;

class Matches extends Controller
{
    public function index(Request $req, $onlyOwn = null) {
        $data = MatchModel::query()->select();
        $userId = $req->user()->id;

        if(!empty($onlyOwn))
          $data = $data->where('user_id', $userId);

        return $data->orderByDesc('created_at')->get();
    }

    public function add(Request $req) {
        $req->validate([ "result" => "required" ]);
        $data = $req->all();
        $data["user_id"] = $req->user()->id;

        MatchModel::create($data);

        if(!empty($req->budget))
           $req->user()->updateOrFail(["budget" => $req->budget]);

        return ["message" => "success"];
    }

    public function getUserMatchesStats($userId) {
        $total = MatchModel::where('user_id', $userId)
            ->orWhere('opponent_user_id', $userId)->count();
        $wins = MatchModel::whereRaw("user_id = $userId AND result = 'WIN'")
            ->orWhereRaw("opponent_user_id	 = $userId AND result = 'LOSE'")
            ->count();
        $loses = MatchModel::whereRaw("user_id = $userId AND result = 'LOSE'")
            ->orWhereRaw("opponent_user_id = $userId AND result = 'WIN'")
            ->count();

        return [ "total"=> $total, "wins"=> $wins, "loses"=> $loses ];
    }


}

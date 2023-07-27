<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User as UserModel;
use App\Http\Controllers\UserPlayers as UserPlayersController;
use App\Http\Controllers\Matches as MatchesController;

class User extends Controller
{
    public function index() {
        return UserModel::all();
    }

    public function updateUserInfo(Request $req) {
        $data = $req->only([
            'img_url', 'name', 'birthdate', 'budget', 'score', 'mobile'
        ]);

        $user = $req->user();
        $user->updateOrFail($data);
    }

    public function getDetails(Request $req, UserModel $user) {
        $user->players = (new UserPlayersController())
            ->getUserPlayers($req, $user->id);
        $user->matchStats = (new MatchesController())
            ->getUserMatchesStats($user->id);
        return $user;
    }
}

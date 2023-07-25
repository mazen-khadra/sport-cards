<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitation as InvitationModel;

class Invitation extends Controller
{
    public function index(Request $req, $onlyOwnSent = null, $onlyOwnReceive = null, $onlyNotAccept = null) {
        $userId = $req->user()->id;
        $data = InvitationModel::query()->select();
        $onlyOwnSent = $onlyOwnSent ?? $req->query('onlyOwnSent');
        $onlyOwnReceive = $onlyOwnReceive ?? $req->query('onlyOwnReceive');
        $onlyNotAccept = $onlyNotAccept ?? $req->query('onlyNotAccept');

        if(!empty($onlyOwnSent))
          $data = $data->where('creat_by_user_id', $userId);

        if(!empty($onlyOwnReceive))
          $data = $data->where('to_user_id', $userId);

        if(!empty($onlyNotAccept))
            $data = $data->where('is_accepted', 0);

        return $data->orderByDesc('created_at')->get();
    }

    public function add(Request $req) {
        $userId = $req->user()->id;
        $req->validate(['to_user_id' => 'required']);

        InvitationModel::create([
            'creat_by_user_id' => $userId,
            'to_user_id' => $req->to_user_id,
        ]);

        return ["message" => "success"];
    }

    public function decide(Request $req, InvitationModel $invitation) {
        $isAccepted = $req->is_accepted;
        $invitation->update(["is_accepted" => $isAccepted]);
        return ["message" => "success"];
    }

}

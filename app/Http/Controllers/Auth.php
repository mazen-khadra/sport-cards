<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User as UserModel;
use App\Models\img as ImgModel;
use Illuminate\Support\Facades\Auth as AuthFacade;

class Auth extends Controller
{
    public function signUp(Request $req) {
       $req->validate([
           "name" => "bail|required",
           "email" => "bail|required|email|unique:users",
           "password" => "bail|required"
       ]);

       $data = $req->all();
       $data["img_id"] = ImgModel::getImgIdByUrl($data["img_url"]);
       UserModel::create($data);

       return $this->logIn($req);
    }

    public function logIn(Request $req) {
        $cred = $req->validate([
            "email" => "bail|required|email",
            "password" => "bail|required"
        ]);

        if(AuthFacade::attempt($cred)) {
            $user = AuthFacade::user();
            $token = $user->createToken($user->id)->plainTextToken;
            $user->token = $token;
            return response($user);
        }

        return response(null, 401);
    }

    public function getLoggedInUser() {
        if(AuthFacade::check())
            return AuthFacade::user();

        return response(null, 401);
    }
}

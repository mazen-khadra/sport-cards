<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User as UserModel;

class User extends Controller
{
    public function updateUserInfo(Request $req) {
        $data = $req->only([
            'img_url', 'name', 'birthdate', 'budget', 'score', 'mobile'
        ]);

        $user = $req->user();
        $user->updateOrFail($data);
    }
}

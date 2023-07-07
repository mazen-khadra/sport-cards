<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\img As ImgModel;

class Img extends Controller
{
    function uploadImg(Request $req) {
        $img = $req->file('img');
        $url = $img->storeAs (
            'public-imgs',
            Date::now()->unix() . '_' . $img->getClientOriginalName()
        );

        ImgModel::getImgIdByUrl($url);
        return $url;
    }
}

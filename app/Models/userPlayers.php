<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\img as ImgModel;


class userPlayers extends Model
{
    use HasFactory;

    protected $appends = ['img_url'];

    public function getImgUrlAttribute() {
        return ImgModel::getImgUrlById($this->attributes['img_id']);
    }

}

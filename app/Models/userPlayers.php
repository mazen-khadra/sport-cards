<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\img as ImgModel;


class userPlayers extends Model
{
    use HasFactory;

    protected $fillable = ['player_id', 'user_id', 'name', 'position', 'market_value', 'img_id'];
    protected $appends = ['img_url'];
    protected $guarded = [''];
    protected $hidden =  ['img_id', 'updated_at'];
    public function getImgUrlAttribute() {
        return ImgModel::getImgUrlById($this->attributes['img_id']);
    }

}

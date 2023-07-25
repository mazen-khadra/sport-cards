<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User as UserModel;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = ['to_user_id', 'creat_by_user_id', 'is_accepted'];

    protected $appends = ["to_user", "creat_by_user"];

    public function getToUserAttribute() {
      return UserModel::where("id", $this->attributes["to_user_id"])->first();
    }
    public function getCreatByUserAttribute() {
      return UserModel::where("id", $this->attributes["creat_by_user_id"])->first();
    }
}

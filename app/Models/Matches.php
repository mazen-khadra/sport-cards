<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User as UserModel;

class Matches extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'result', 'score', 'opponent_user_id'];

    protected $appends = ['user', 'opponent_user'];

    public function getUserAttribute() {
        return UserModel::where('id', $this->attributes['user_id'])->first();
    }

    public function getOpponentUserAttribute() {
        return UserModel::where('id', $this->attributes['opponent_user_id'])->first();
    }
}

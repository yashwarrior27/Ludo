<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded=[];

    public function CreatedUser()
     {
         return $this->hasOne(User::class,'id','created_id');
     }

    public function AcceptedUser()
    {
        return $this->hasOne(User::class,'id','accepted_id');
    }
    public function Winner()
    {
        return $this->hasOne(User::class,'id','winner_id');
    }

    public function Category()
    {
        return $this->hasOne(Category::class,'id','category_id');
    }

    public function GameResult()
    {
        return $this->hasMany(GameResult::class,'game_id','id');
    }
}

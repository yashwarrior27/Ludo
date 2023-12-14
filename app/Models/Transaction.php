<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function Game()
    {
        return $this->hasOne(Game::class,'id','type_id');
    }

    public function User()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}

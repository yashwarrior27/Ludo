<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function Deposit()
    {
           return $this->hasOne(Transaction::class,'type_id','id')->where('trans',0);
    }

    public function Bonus()
    {
        return $this->hasOne(Transaction::class,'type_id','id')->where('trans',2);
    }
}

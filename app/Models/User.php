<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded=[];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    public function TotalBalance()
     {
        $totalBalance=Transaction::where('user_id',$this->id)
        ->whereIn('trans',['0','2','3','4'])
        ->where('status',1)
        ->sum('amount');

        $totalWithdrawal=Transaction::where('user_id',$this->id)
        ->whereIn('trans',['1','5','6'])
        ->where('status',1)
        ->sum('amount');

         return (float)$totalBalance-(float)$totalWithdrawal;
        // return 500;
     }

    public function WithdrawalableAmount()
    {
          $totalWin=(float) Transaction::where('user_id',$this->id)
      ->where('trans','3')
      ->where('status',1)
      ->sum('amount');

      if($totalWin<=0)
         return 0;

      $totaldeposit=(float) Transaction::where('user_id',$this->id)
      ->whereIn('trans',['0','2','4'])
      ->where('status',1)
      ->sum('amount');


      $totalPenalty=(float) Transaction::where('user_id',$this->id)
      ->where('trans','5')
      ->where('status',1)
      ->sum('amount');

     $totalWithdrawal=(float) Transaction::where('user_id',$this->id)
      ->where('trans','6')
      ->where('status',1)
      ->sum('amount');

      $totalPlay=(float) Transaction::where('user_id',$this->id)
      ->where('trans','1')
      ->where('status',1)
      ->sum('amount');

      if(($totaldeposit-$totalPlay-$totalPenalty)>=0)
          return $totalWin-$totalWithdrawal;
       else
       {
           $t=($totaldeposit-$totalPlay-$totalPenalty);
           return $totalWin-$totalWithdrawal-$t;
       }
    }

    public function UserDetail()
    {
        return $this->hasOne(UserDetail::class,'user_id','id');
    }

    public function Parent()
    {
        return $this->hasOne(static::class,'id','parent_id');
    }
}

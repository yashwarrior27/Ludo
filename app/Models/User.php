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

        // return (float)$totalBalance-(float)$totalWithdrawal;
        return 500;
     }

    public function WithdrawalableAmount()
    {
       $totalBalance=(float) $this->TotalBalance();

      $totalWin=(float) Transaction::where('user_id',$this->id)
      ->where('trans','3')
      ->where('status',1)
      ->sum('amount');

       return $totalBalance>($totalBalance-$totalWin)?$totalBalance-($totalBalance-$totalWin):0;
    }

}

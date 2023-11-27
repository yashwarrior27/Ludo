<?php

namespace App\Helper;

use App\Models\Deposit;
use App\Models\Price;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserCoin;


class Helper{

    public static function Deposit(Deposit $deposit)
    {
        try
        {
            $deposit->status='success';
            $deposit->save();

            $user=User::find($deposit->user_id);
            $user->deposits+=$deposit->amount;
            $user->save();

           $usercoin= UserCoin::create([
                'user_id'=>$deposit->user_id,
                'deposit_id'=>$deposit->id,
                'coins'=>(float)$deposit->coin_quantity*2,
                'lockin_days'=>Price::first()->lockin_days,
            ]);

            $trans[]=[
                'user_id'=>$deposit->user_id,
                'deposit_id'=>$deposit->id,
                'amount'=>(float)$deposit->coin_quantity*2,
                'trans'=>0,
                'type_id'=>$usercoin->id,
                'type'=>'deposit'
            ];

            $parent=User::find($user->parent_id);
            if(!empty($parent->deposits) && $parent->deposits>0){
            $trans[]=[
                 'user_id'=>$parent->id,
                 'deposit_id'=>null,
                 'amount'=>(float)$deposit->amount*(env('Level_1',10)/100),
                 'trans'=>2,
                 'type_id'=>$user->id,
                 'type'=>'level_1'
            ];
            }
            if($user->parent_id!=1)
            {
                $superparent=User::find($parent->parent_id);

                if(!empty($superparent->deposits) && $superparent->deposits>0){
               $trans[]=[
                   'user_id'=>$superparent->id,
                   'deposit_id'=>null,
                   'amount'=>(float)$deposit->amount*(env('Level_2',5)/100),
                   'trans'=>2,
                   'type_id'=>$user->id,
                   'type'=>'level_2'
               ];
            }
            }

            Transaction::insert($trans);

        }
        catch(\Exception $e)
        {
         throw new \ErrorException($e->getMessage());
        }
    }

}
